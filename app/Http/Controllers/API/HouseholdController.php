<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Uservillage;
use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\PreRequisite;
use App\Models\kycDocument;
use App\Models\Village;

/**
 * @group Household
 *
 * APIs to manage household head details
 */
class HouseholdController extends Controller
{
    /**
     * Household List
     *
     * Returns the list of households of the villages alloted to this user
     *
     * @header Authorization Bearer access_token
     *
     * @urlParam hh_row_id integer required Row Id of Household. Example: 0
     * @urlParam update_date string required
     *
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Village Household Details",
     *  "data": [
     *      {
     *          "villagehhid": 5687,
     *          "village_id": 69,
     *          "hh_id": "1214001",
     *          "hhname": "Manda Hiraman Raut",
     *          "qrcode": "",
     *          "social_status": "BPL Antyodaya",
     *          "card_disbursement_sts": 0,
     *          "social_eco_status": "BPL Antyodaya",
     *          "card_score": "",
     *          "hh_income": "Less than 30000",
     *          "caste": "OBC",
     *          "state": "Maharashtra",
     *          "age": "66",
     *          "created_at": "2022-09-29T11:37:55.000000Z",
     *          "updated_at": "2022-09-29T11:37:55.000000Z",
     *          "import_code": "",
     *          "tag": ""
     *      }
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     *
     * @authenticated
     */
    public function getHouseholds(int $hhRowId, string $updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
            ->get();
        $villageIds = $userVillages->pluck("village_id")
            ->toArray();

        $query = Household::select("id as villagehhid", "village_id", "hh_id", "name as hhname", "qr_code as qrcode", "social_status", "card_disbursement_status as card_disbursement_sts", "social_eco_status", "card_score", "hh_income", "caste", "state", "age", "created_at", "updated_at")
            ->whereIn("village_id", $villageIds);

        if ($hhRowId != 0) {
            $query->where("id", $hhRowId);
        }

        if ($updateDate != "0") {
            $query->whereDate('updated_at', '=', $updateDate);
        }

        $households = $query->get()->toArray();

        $households = array_map(function ($household) {
            $household["import_code"] = "";
            $household["tag"] = "";

            $cardScore = $household["card_score"];
            if ($cardScore == "0_20") {
                $cardScore = "0 - 20";
            } else if ($cardScore == "above_20") {
                $cardScore = "Above 20";
            }
            $household["card_score"] = $cardScore;
            $household["state"] = ucfirst($household["state"]);
            $caste = strtoupper($household["caste"]);
            if ($caste == "GENERAL") {
                $caste = "General";
            }
            $household["caste"] = $caste;

            $socialStatus = strtoupper($household["social_status"]);
            if ($socialStatus == "APL-1") {
                $socialStatus = "APL - 1";
            } else if ($socialStatus == "APL-2") {
                $socialStatus = "APL - 2";
            } else if ($socialStatus == "BPL_ANTYODAYA") {
                $socialStatus = "BPL Antyodaya";
            }
            $household["social_status"] = $socialStatus;

            $socialEcoStatus = strtoupper($household["social_eco_status"]);
            if ($socialEcoStatus == "APL-1") {
                $socialEcoStatus = "APL - 1";
            } else if ($socialEcoStatus == "APL-2") {
                $socialEcoStatus = "APL - 2";
            } else if ($socialEcoStatus == "BPL_ANTYODAYA") {
                $socialEcoStatus = "BPL Antyodaya";
            }
            $household["social_eco_status"] = $socialEcoStatus;

            return $household;
        }, $households);

        return response()->apiSuccess("Village Household Details", [$households]);
    }

    /**
     * Household Details
     *
     * Returns the details of a particular household, based upon the input parameter.
     *
     * @header Authorization Bearer access_token
     *
     * @urlParam hh_id string required Household Id. Example: 1214001
     *
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household Details",
     *  "data": [
     *      {
     *          "villagehhid": 5687,
     *          "village_id": 69,
     *          "hh_id": "1214001",
     *          "hhname": "Manda Hiraman Raut",
     *          "qrcode": "",
     *          "social_status": "BPL Antyodaya",
     *          "card_disbursement_sts": 0,
     *          "social_eco_status": "BPL Antyodaya",
     *          "card_score": "",
     *          "hh_income": "Less than 30000",
     *          "caste": "OBC",
     *          "state": "Maharashtra",
     *          "age": "66",
     *          "created_at": "2022-09-29T11:37:55.000000Z",
     *          "updated_at": "2022-09-29T11:37:55.000000Z",
     *          "import_code": "",
     *          "tag": ""
     *      }
     *  ]
     * }
     * @response status=105 scenario="household not found" {"message": "Wrong HouseHold Number or Data not found!"}
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     *
     * @authenticated
     */
    public function getHouseholdDetails(int $hhId)
    {
        $household = Household::select("village_id", "hh_id", "name as hhname", "qr_code as qrcode", "social_status", "card_disbursement_status as card_disbursement_sts", "social_eco_status", "card_score", "hh_income", "caste", "state")
            ->where("hh_id", $hhId)
            ->orWhere("qr_code", $hhId)
            ->first();

        if ($household != null) {
            $village = $household->village;
            $household->villnm = $village->name;

            $household = $household->toArray();
            unset($household["village"]);

            $household["import_code"] = "";
            $household["tag"] = "";

            $cardScore = $household["card_score"];
            if ($cardScore == "0_20") {
                $cardScore = "0 - 20";
            } else if ($cardScore == "above_20") {
                $cardScore = "Above 20";
            }
            $household["card_score"] = $cardScore;
            $household["state"] = ucfirst($household["state"]);

            $caste = strtoupper($household["caste"]);
            if ($caste == "GENERAL") {
                $caste = "General";
            }
            $household["caste"] = $caste;

            $socialStatus = strtoupper($household["social_status"]);
            if ($socialStatus == "APL-1") {
                $socialStatus = "APL - 1";
            } else if ($socialStatus == "APL-2") {
                $socialStatus = "APL - 2";
            } else if ($socialStatus == "BPL_ANTYODAYA") {
                $socialStatus = "BPL Antyodaya";
            }
            $household["social_status"] = $socialStatus;

            $socialEcoStatus = strtoupper($household["social_eco_status"]);
            if ($socialEcoStatus == "APL-1") {
                $socialEcoStatus = "APL - 1";
            } else if ($socialEcoStatus == "APL-2") {
                $socialEcoStatus = "APL - 2";
            } else if ($socialEcoStatus == "BPL_ANTYODAYA") {
                $socialEcoStatus = "BPL Antyodaya";
            }
            $household["social_eco_status"] = $socialEcoStatus;

            return response()->apiSuccess("Household Details", [$household]);
        }

        return response()->apiSuccess("Wrong HouseHold Number or Data not found!", [], 105);
    }

    /**
     * Register Household
     *
     * Stores the newly created household in the storage
     *
     * @header Authorization Bearer access_token
     *
     * @bodyParam data json required Household details. Example: {}
     *
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household registration done successfully",
     *  "data": [
     *      "household_count": 1
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     *
     * @authenticated
     */
    public function registerHousehold(Request $request)
    {
        $input = json_decode($request->getContent());
        $households = $input->data->sync_household_list;

        $villages = Village::select("id", "name")
            ->get()
            ->pluck("name", "id")
            ->toArray();

        $modification = [
            "bpl antyodaya" => "bpl_antyodaya",
            "apl - 1" => "apl-1",
            "apl - 2" => "apl - 2",
            "0 - 20" => "0_20",
            "Above 20" => "above_20"
        ];

        $insertedCount = 0;
        foreach ($households as $household) {
            $householdExists = Household::where([
                "hh_id" => $household->hh_id,
                "village_id" => $household->village_id
            ])
                ->exists();

            $socialStatus = $household->social_status;
            if (array_key_exists($socialStatus, $modification)) {
                $socialStatus = $modification[$socialStatus];
            }

            $socialEcoStatus = $household->social_eco_status;
            if (array_key_exists($socialEcoStatus, $modification)) {
                $socialEcoStatus = $modification[$socialEcoStatus];
            }

            $cardScore = $household->card_score;
            if (array_key_exists($cardScore, $modification)) {
                $cardScore = $modification[$cardScore];
            }

            $state = strtolower(str_replace(" ", "_", $household->state));

            $villageName = "";
            if (array_key_exists($household->village_id, $villages)) {
                $villageName = $villages[$household->village_id];
            }
            $memberId = $household->hh_id . "1";

            if (!$householdExists) {
                $newHousehold = new Household;
                $newHousehold->village_id = $household->village_id;
                $newHousehold->hh_id = $household->hh_id;
                $newHousehold->name = str($household->name);
                $newHousehold->qr_code = $household->qrcode;
                $newHousehold->mobile = $household->mobile;

                $newHousehold->social_status = str($socialStatus);
                $newHousehold->social_eco_status = str($socialEcoStatus);
                $newHousehold->card_disbursement_status = $household->card_disbursement_sts;
                $newHousehold->hh_income = str($household->hh_income);

                $newHousehold->card_score = str($cardScore);
                $newHousehold->caste = strtolower($household->caste);

                $newHousehold->state = str($state);
                $newHousehold->age = $household->age;
                $newHousehold->save();

                $newMember = new Beneficiary;
                $newMember->village_id = $household->village_id;
                $newMember->hh_id = $household->hh_id;
                $newMember->member_id = $memberId;
                $newMember->member_count = 1;
                $newMember->name = $household->name;
                $newMember->full_address = $villageName;
                $newMember->landmark = $villageName;
                $newMember->save();

                $insertedCount++;
            } else {
                Household::where([
                    "village_id" => $household->village_id,
                    "hh_id" => $household->hh_id
                ])->update([
                    "name" => $household->name,
                    "social_status" => $socialStatus,
                    "social_eco_status" => $socialEcoStatus,
                    "hh_income" => $household->hh_income,
                    "card_disbursement_status" => $household->card_disbursement_sts,
                    "mobile" => $household->mobile,
                    "card_score" => $cardScore,
                    "caste" => strtolower($household->caste)
                ]);

                Beneficiary::where([
                    "village_id" => $household->village_id,
                    "hh_id" => $household->hh_id,
                    "member_id" => $memberId
                ])->update([
                    "name" => $household->name,
                    "full_address" => $villageName,
                    "landmark" => $villageName
                ]);
            }
        }

        return response()->apiSuccess("Household registration done successfully", ["household_count" => $insertedCount]);
    }
}
