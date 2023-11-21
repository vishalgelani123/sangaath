<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\BulkUpload;
use App\Models\Site;
use App\Models\Village;
use App\Models\Household;
use App\Models\Beneficiary;

class BulkUploadController extends Controller
{
    /**
     * Get all the files that are bulk uploaded
     *
     * @return \Inertia\Response;
     */
    public function index()
    {
        $sites = Site::select("id", "name")->get();
        $bulkUploads = BulkUpload::orderBy("created_at", "DESC")->get()->map(fn ($upload) => $upload->format());

        $templateDownloadLinks = [
            "hh_head" => env("APP_ENV") == "local" ? "/bulk-upload-templates/hh_head_template.csv" : "/bulk-upload-templates/hh_head_template.csv",
            "hh_individual" => env("APP_ENV") == "local" ? "/bulk-upload-templates/hh_individual_template.csv" : "/bulk-upload-templates/hh_individual_template.csv"
        ];

        return Inertia::render("BulkUpload", ["all_bulk_uploads" => $bulkUploads, "sites" => $sites, "templates" => $templateDownloadLinks]);
    }

    /**
     * Validates the file and if the file is correct, bulk data would be imported
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function upload(Request $request)
    {
        $siteId = $request->site_id;

        $fileType = $request->type;
        $file = $request->file("file");

        $validated = false;
        $error = null;

        list($validated, $error) = $this->getDataFromCSV($file, $fileType, $siteId);
        if (!$validated) {
            return ["status" => -1, "error" => $error["error"], "download_link" => $error["download_url"]];
        }

        return ["status" => 1, "message" => "Data uploaded successfully"];
    }

    private function getDataFromCSV($file, $fileType, $siteId)
    {
        $siteVillages = Village::where("site_id", $siteId)->pluck("id", "name")->toArray();

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        $mappedRows = [];
        foreach ($rows as $row) {
            $row = array_splice($row, 0, count($header));
            if (count($header) != count($row)) {
                continue;
            }
            $mappedRow = array_combine($header, array_splice($row, 0, count($header)));
            $mappedRows[] = $mappedRow;
        }

        $validated = false;
        $formattedRows = [];
        $error = null;
        if ($fileType == "hh_head") {
            list($validated, $formattedRows, $error) = $this->getHouseholdHeadData($header, $mappedRows, $siteVillages);
        }else if ($fileType == "individual_members") {
            list($validated, $formattedRows, $error) = $this->getIndividualMemberData($header, $mappedRows, $siteVillages);
        }

        if (!$validated) {
            $downloadURL = env("APP_ENV") == "local" ? "/".$error["file"] : env("APP_URL")."/".$error["file"];
            $error["download_url"] = $downloadURL;
            return [false, $error];
        }else {
            if ($fileType == "hh_head") {
                Household::insert($formattedRows);
            }else {
                Beneficiary::insert($formattedRows);
            }

            $destinationPath = public_path('uploads');
            $filename = time()."_".$file->getClientOriginalName();

            // Move the uploaded file to the destination path
            $file->move($destinationPath, $filename);

            $bulkUpload = new BulkUpload;
            $bulkUpload->file_name = $filename;
            $bulkUpload->type = $fileType;
            $bulkUpload->site_id = $siteId;
            $bulkUpload->save();
        }

        return [$validated, $error];
    }

    /**
     * Validates the household head file
     *
     * @param array $header
     * @param array $rows
     * @param array $siteVillages
     *
     * @return array
     */
    private function getHouseholdHeadData($header, $rows, $siteVillages)
    {
        $villageIds = array_values($siteVillages);

        $usedHHIds = Household::select("hh_id", "village_id")
            ->whereIntegerInRaw("village_id", $villageIds)
            ->get()
            ->groupBy("village_id")
            ->map(function ($group) {
                return $group->pluck("hh_id")->toArray();
            })
            ->toArray();

        $usedHHIdsSameFile = [];

        $requiredHeaders = [
            "village",
            "hh_id",
            "name",
            "mobile",
            "age",
            "social_status",
            "social_eco_status",
            "card_score",
            "hh_income",
            "caste",
            "state",
            "qr_code"
        ];

        foreach ($requiredHeaders as $value) {
            if (!in_array($value, $header)) {
                $error = [
                    "error" => "invalid_header",
                    "file" => ""
                ];
                return [false, [], $error];
            }
        }

        $formattedRows = [];
        $hasError = false;

        foreach ($rows as $index => $row) {
            if (!array_key_exists($row["village"], $siteVillages)) {
                $hasError = true;
                $rows[$index]["error"] = "Village does not exists";
                continue;
            }

            $villageId = $siteVillages[$row["village"]];

            if (isset($usedHHIds[$villageId]) && in_array($row["hh_id"], $usedHHIds[$villageId])) {
                $hasError = true;
                $rows[$index]["error"] = "HH ID already exists in the database";
                continue;
            }

            if (isset($usedHHIdsSameFile[$villageId]) && in_array($row["hh_id"], $usedHHIdsSameFile[$villageId])) {
                $hasError = true;
                $rows[$index]["error"] = "Duplicate HH ID in the same file";
                continue;
            }

            $socialStatus = strtolower($row["social_status"]);
            if ($socialStatus == "bpl antyodaya") {
                $socialStatus = "bpl_antyodaya";
            }
            $formattedSocialStatus = str_replace(" ", "-", $socialStatus);
            if (!in_array($formattedSocialStatus, ["apl", "apl-1", "apl-2", "bpl", "bpl_antyodaya"])) {
                $formattedSocialStatus = "";
            }

            $caste = strtolower($row["caste"]);
            $state = strtolower($row["state"]);

            $cardScore = strtolower($row["card_score"]);
            if ($cardScore == "0 to 20") {
                $cardScore = "0_20";
            }else if ($cardScore == "Above 20") {
                $cardScore = "above_20";
            }else {
                $cardScore = "";
            }

            $formattedRow = [
                "village_id" => $villageId,
                "hh_id" => $row["hh_id"],
                "name" => $row["name"],
                "mobile" => $row["mobile"],
                "age" => $row["age"],
                "social_status" => $formattedSocialStatus,
                "social_eco_status" => $formattedSocialStatus,
                "card_score" => $cardScore,
                "hh_income" => $row["hh_income"],
                "caste" => $caste,
                "state" => $state,
                "qr_code" => $row["qr_code"]
            ];

            $formattedRows[] = $formattedRow;

            if (!isset($usedHHIdsSameFile[$villageId])) {
                $usedHHIdsSameFile[$villageId] = [];
            }

            $usedHHIdsSameFile[$villageId][] = $row["hh_id"];
        }

        if ($hasError) {
            $header[] = "error";
            array_unshift($rows, $header);

            // Generate the CSV content
            $csvContent = '';
            foreach ($rows as $row) {
                $csvContent .= implode(',', array_values($row)) . "\n";
            }

            // Save the updated CSV content to a file or output it
            $fileName = time()."-error.csv";
            file_put_contents($fileName, $csvContent);

            $error = [
                "error" => "invalid_data",
                "file" => $fileName
            ];
            return [false, [], $error];
        }

        return [true, $formattedRows, null];
    }

    /**
     * Validates the individual member data file
     *
     * @param array $header
     * @param array $rows
     * @param array $siteVillages
     *
     * @return array
     */
    private function getIndividualMemberData($header, $rows, $siteVillages)
    {
        $villageIds = array_values($siteVillages);

        $usedMemberIds = Beneficiary::select("member_id", "village_id")
            ->whereIntegerInRaw("village_id", $villageIds)
            ->get()
            ->groupBy("village_id")
            ->map(function ($group) {
                return $group->pluck("member_id")->toArray();
            })
            ->toArray();

        $usedMemberIdsSameFile = [];

        $requiredHeaders = [
            "village",
            "hh_id",
            "member_id",
            "name",
            "full_address",
            "landmark",
            "age",
            "marital_sts",
            "gender",
            "income",
            "caste_cf",
            "type_of_house",
            "disability",
            "aadhar_card",
            "bank_ac",
            "election_card",
            "status_of_women",
            "religion",
            "land_ownership",
            "education_sts",
            "height_cm",
            "weight_kgs"
        ];

        foreach ($requiredHeaders as $value) {
            if (!in_array($value, $header)) {
                $error = [
                    "error" => "invalid_header",
                    "file" => ""
                ];
                return [false, [], $error];
            }
        }

        $formattedRows = [];
        $hasError = false;

        foreach ($rows as $index => $row) {
            if (!array_key_exists($row["village"], $siteVillages)) {
                $hasError = true;
                $rows[$index]["error"] = "Village does not exists";
                continue;
            }

            $villageId = $siteVillages[$row["village"]];

            if (isset($usedMemberIds[$villageId]) && in_array($row["hh_id"], $usedMemberIds[$villageId])) {
                $hasError = true;
                $rows[$index]["error"] = "HH ID already exists in the database";
                continue;
            }

            if (isset($usedMemberIdsSameFile[$villageId]) && in_array($row["hh_id"], $usedMemberIdsSameFile[$villageId])) {
                $hasError = true;
                $rows[$index]["error"] = "Duplicate HH ID in the same file";
                continue;
            }

            $hhId = $row["hh_id"];
            $memberId = $row["member_id"];
            $memberCount = intval(str_replace($hhId, "", $memberId));

            $maritalStatus = strtolower($row["marital_sts"]);
            $maritalStatus = str_replace(" ", "_", $maritalStatus);
            if ($maritalStatus == "widow/widower") {
                $maritalStatus = "widow_widower";
            }

            $disability = strtolower($row["disability"]);
            if ($disability === "Speech / hearing" || $disability === "speech/hearing") {
                $disability = "speech_hearing";
            }
            $disability = str_replace(" ", "_", $disability);

            $formattedRow = [
                "village_id" => $villageId,
                "hh_id" => $row["hh_id"],
                "member_id" => $memberId,
                "member_count" => $memberCount,
                "name" => $row["name"],
                "full_address" => $row["full_address"],
                "landmark" => $row["landmark"],
                "age" => $row["age"],
                "marital_status" => $maritalStatus,
                "gender" => $row["gender"],
                "income" => $row["income"],
                "caste_certificate" => ($row["caste_cf"] === "Yes") ? 1 : (($row["caste_cf"] === "No") ? 0 : -1),
                "type_of_house" => "",
                "disability" => $disability,
                "aadhaar_card" => ($row["aadhar_card"] === "Yes") ? 1 : (($row["aadhar_card"] === "No") ? 0 : -1),
                "bank_account" => ($row["bank_ac"] === "Yes") ? 1 : (($row["bank_ac"] === "No") ? 0 : -1),
                "election_card" => ($row["election_card"] === "Yes") ? 1 : (($row["election_card"] === "No") ? 0 : -1),
                "widow_status" => $maritalStatus,
                "status_of_women" => strtolower($row["status_of_women"]),
                "religion" => $row["religion"],
                "land_ownership" => ($row["land_ownership"] === "Yes") ? 1 : (($row["land_ownership"] === "No") ? 0 : -1),
                "education_status" => $row["education_sts"],
                "height_cm" => "",
                "weight_kg" => ""
            ];

            $formattedRows[] = $formattedRow;

            if (!isset($usedMemberIdsSameFile[$villageId])) {
                $usedMemberIdsSameFile[$villageId] = [];
            }
        }

        if ($hasError) {
            $header[] = "error";
            array_unshift($rows, $header);

            // Generate the CSV content
            $csvContent = '';
            foreach ($rows as $row) {
                $csvContent .= implode(',', array_values($row)) . "\n";
            }

            // Save the updated CSV content to a file or output it
            $fileName = time()."-error.csv";
            file_put_contents($fileName, $csvContent);

            $error = [
                "error" => "invalid_data",
                "file" => $fileName
            ];
            return [false, [], $error];
        }

        return [true, $formattedRows, null];
    }
}
