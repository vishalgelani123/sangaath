<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\DataExport;
use App\Models\Scheme;
use App\Models\Site;
use App\Models\Village;
use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\ConfirmApplication;

class DataExportController extends Controller
{
    public function index()
    {
        $dataExports = DataExport::has("site")->with("site")->orderBy('id', 'desc')->get()->map(function ($export) {
            return $export->format();
        });

        $sites = Site::select("id", "name")->get();
        $villages = Village::select("id", "site_id", "name")->get()->groupBy("site_id");

        return Inertia::render('DataExport', ["data_exports" => $dataExports, "sites" => $sites, "villages" => $villages]);
    }

    public function export(Request $request)
    {
        $siteId = $request->site_id;
        // $villageId = $request->village_id;

        $site = Site::find($siteId);
        $siteName = $site->name;

        $schemes = Scheme::pluck("name", "id");


        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $householdHeaders = DB::getSchemaBuilder()->getColumnListing('households');
        $householdHeaders = array_diff($householdHeaders, ['id', 'village_id', 'deleted_at', 'created_at', 'updated_at']);
        $householdHeaders[] = 'village';
        $householdCSVData = implode(',', $householdHeaders) . "\n";

        $beneficiariesHeaders = DB::getSchemaBuilder()->getColumnListing('beneficiaries');
        $beneficiariesHeaders = array_diff($beneficiariesHeaders, ['id', 'village_id', 'deleted_at', 'created_at', 'updated_at']);
        $beneficiariesHeaders[] = 'village';
        $beneficiariesCSVData = implode(',', $beneficiariesHeaders) . "\n";

        $applicationHeaders = [
            "hh_id",
            "member_id",
            "beneficiary_name",
            "scheme_name",
            "village",
            "helpdesk_user",
            "eleigible_sts",
            "s1_helpdesk",
            "s1_date",
            "s2_liasoning_officer",
            "s2_date",
            "s3_govt_dept",
            "s3_date",
            "benefit_status",
            "beneficiaries_img",
            "benefit_date",
            "if_descripency",
            "reject_reason",
            "created_at",
            "updated_at"
        ];
        $applicationCSVData = implode(',', $applicationHeaders) . "\n";

        $siteVillages = Village::where("site_id", $siteId)->get();
        foreach ($siteVillages as $village) {
            $villageId = $village->id;
            $villageName = $village->name;

            // Exporting Household Start

            if ($request->include_date == 'yes') {
                $households = Household::where('village_id', $villageId)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('created_at', [$startDate, $endDate])
                            ->orWhereNull('created_at');
                    })
                    ->get();
            } else {
                $households = Household::where('village_id', $villageId)->whereBetween('created_at', [$startDate, $endDate])->get();
            }

            $households = $households->map(function ($household) use ($villageName) {
                $household->village = $villageName;

                $household->hh_id = '"' . $household->hh_id . '"';
                $household->hh_income = '"' . $household->hh_income . '"';

                unset($household->id);
                unset($household->village_id);
                unset($household->deleted_at);
                unset($household->created_at);
                unset($household->updated_at);
                return $household;
            });

            $householdCSVData .= $households->map(function ($household) use ($householdHeaders) {
                return implode(',', array_intersect_key($household->toArray(), array_flip($householdHeaders)));
            })->implode("\n");
            if ($households->count() > 0) {
                $householdCSVData .= "\n";
            }
            // Exporting Household End


            // Exporting Beneficiary Start
//            $beneficiaries = Beneficiary::where('village_id', $villageId)->whereBetween('created_at', [$startDate, $endDate])->get();
            $beneficiaries = Beneficiary::where('village_id', $villageId)->get();
            $mappedBeneficiaries = [];

            $beneficiaries = $beneficiaries->map(function ($beneficiary) use ($villageName, &$mappedBeneficiaries) {
                $beneficiary->village = $villageName;

                $aadhaarNumber = $beneficiary->aadhaar_number;
                if ($aadhaarNumber == "NULL") {
                    $aadhaarNumber = "";
                }

                $mappedBeneficiaries[$beneficiary->member_id] = $beneficiary->name;

                $beneficiary->aadhaar_number = $aadhaarNumber;
                $beneficiary->hh_id = '"' . $beneficiary->hh_id . '"';
                $beneficiary->member_id = '"' . $beneficiary->member_id . '"';

                $beneficiary->income = '"' . $beneficiary->income . '"';
                $beneficiary->aadhaar_card = $this->changeBinaryToYesNo($beneficiary->aadhaar_card);
                $beneficiary->bank_account = $this->changeBinaryToYesNo($beneficiary->bank_account);
                $beneficiary->election_card = $this->changeBinaryToYesNo($beneficiary->election_card);
                $beneficiary->widow_status = $this->changeBinaryToYesNo($beneficiary->widow_status);
                $beneficiary->caste_certificate = $this->changeBinaryToYesNo($beneficiary->caste_certificate);
                $beneficiary->religion = $this->changeBinaryToYesNo($beneficiary->religion);
                $beneficiary->land_ownership = $this->changeBinaryToYesNo($beneficiary->land_ownership);
                $beneficiary->education_status = $this->changeBinaryToYesNo($beneficiary->education_status);

                $mappedBeneficiaries[$beneficiary->member_id] = $beneficiary->name;
                unset($beneficiary->id);
                unset($beneficiary->village_id);
                unset($beneficiary->deleted_at);
                unset($beneficiary->created_at);
                unset($beneficiary->updated_at);
                return $beneficiary;
            });

            $beneficiariesCSVData .= $beneficiaries->map(function ($beneficiary) use ($beneficiariesHeaders) {
                return implode(',', array_intersect_key($beneficiary->toArray(), array_flip($beneficiariesHeaders)));
            })->implode("\n");
            if ($beneficiaries->count() > 0) {
                $beneficiariesCSVData .= "\n";
            }
            // Exporting Beneficiary End


            // Exporting Confirm Applications Start
            $applications = ConfirmApplication::where('village_id', $villageId)->whereBetween('created_at', [$startDate, $endDate])->get();
            $formattedApplications = [];
            $schemeError = 0;
            $memberIdError = 0;
            $memberIds = [];
            foreach ($applications as $application) {
                dd($mappedBeneficiaries);
                if (isset($mappedBeneficiaries[$application->member_id]) && isset($schemes[$application->scheme_id])) {
                    $beneficiaryName = $mappedBeneficiaries[$application->member_id];
                    $schemeName = $schemes[$application->scheme_id];
                    $cleanedSchemeName = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $schemeName);

                    $documentationStatus = $application["documentation_status"];
                    $documentationDate = $application["documentation_date"];


                    $liasoningStatus = $application["liasoning_status"];
                    $liasoningDate = $application["liasoning_date"];

                    $govtSubmissionStatus = $application["govt_submission_status"];
                    $govtSubmissionDate = $application["govt_submission_date"];

                    $benefitStatus = $application["benefit_status"];

                    if ($documentationDate == "") {
                        $documentationDate = $application["created_at"];
                    }

                    $CreatedDate = $application["created_at"];


                    $application->hh_id = '"' . $application->hh_id . '"';
                    $application->member_id = '"' . $application->member_id . '"';

                    $formattedApplications[] = [
                        "hh_id"                => $application->hh_id ? $application->hh_id : "",
                        "member_id"            => $application->member_id ? $application->member_id : "",
                        "beneficiary_name"     => $beneficiaryName ? $beneficiaryName : "",
                        "scheme_name"          => $cleanedSchemeName ? $cleanedSchemeName : "",
                        "village"              => $villageName ? $villageName : "",
                        "helpdesk_user"        => "",
                        "eleigible_sts"        => "",
                        "s1_helpdesk"          => ($documentationStatus == "1") ? "Documentation_Complete" : "pending",
                        "s1_date"              => $documentationDate ? $documentationDate : "",
                        "s2_liasoning_officer" => ($liasoningStatus == "1") ? "completed" : "pending",
                        "s2_date"              => $liasoningDate ? $liasoningDate : "",
                        "s3_govt_dept"         => ($govtSubmissionStatus == "1") ? "Submitted" : "pending",
                        "s3_date"              => $govtSubmissionDate ? $govtSubmissionDate : "",
                        "benefit_status"       => ($benefitStatus == "1") ? "Yes" : (($benefitStatus == "0") ? "No" : ""),
                        "beneficiaries_img"    => "",
                        "benefit_date"         => $application["benefit_date"] ? $application["benefit_date"] : "",
                        "if_descripency"       => $application["if_discrepancy"] ? $application["if_discrepancy"] : "",
                        "reject_reason"        => $application["reject_reason"] ? $application["reject_reason"] : "",
                        "created_at"           => $CreatedDate ? $CreatedDate : "",
                        "updated_at"           => $CreatedDate ? $CreatedDate : ""
                    ];
                    dd($formattedApplications);
                }
            }
            dd('end');

            $applicationCSVData .= implode("\n", array_map(function ($application) use ($applicationHeaders) {
                return implode(',', array_intersect_key($application, array_flip($applicationHeaders)));
            }, $formattedApplications));
            if ($applications->count() > 0) {
                $applicationCSVData .= "\n";
            }
            // Exporting Confirm Applications End
        }

        Storage::put('households.csv', $householdCSVData);
        Storage::put('beneficiaries.csv', $beneficiariesCSVData);
        Storage::put('confirm_applications.csv', $applicationCSVData);


        $filesToZip = [storage_path("app/households.csv"), storage_path("app/beneficiaries.csv"), storage_path("app/confirm_applications.csv")];
        $zipFileName = str_replace(" ", "_", $siteName) . '.zip';
        $zipFilePath = public_path('zips/' . $zipFileName);
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($filesToZip as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        $newExport = new DataExport;
        $newExport->site_id = $siteId;
        $newExport->village_id = 1;
        $newExport->start_date = $startDate;
        $newExport->end_date = $endDate;
        $newExport->save();

        return ["status" => 1, "download_link" => url('zips/' . $zipFileName)];
    }

    private function changeBinaryToYesNo($response)
    {
        if ($response == "1") {
            return "Yes";
        } elseif ($response == "0") {
            return "No";
        } elseif ($response == "-1") {
            return "";
        }

        return $response;
    }
}
