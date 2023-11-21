<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Uservillage;
use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\kycDocument;
use App\Models\Village;

/**
 * @group Member
 *
 * APIs to manage household members
 */
class MemberController extends Controller
{
    /**
     * Members List
     * 
     * Returns the list of members of the particular hhId, if the input param is 0 all members are returned
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam hh_id integer required HH Id of Household. Example: 0
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household Member Details",
     *  "data": [
     *      "household_members": [
     *          {
     *              "village_id": 69,
     *              "member_id": 121400101,
     *              "member_name": "Manda hiraman raut",
     *              "member_number": 1,
     *              "household_number": "1214001"
     *          }
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getHouseholdMembers($hhId)
    {
        $userId = request()->user()->id;
        $allotedVillages = Uservillage::where("user_id", $userId)
                                        ->has("village_name.site")
                                        ->with("village_name.site")
                                        ->get();

        $villageIds = $allotedVillages->pluck("village_id")
                                    ->toArray();

        $query = Household::select("village_id", "hh_id")
                                ->whereIn("village_id", $villageIds);

        if ($hhId != 0) {
            $query->where("hh_id", $hhId)->orWhere("qr_code", $hhId);
        }
        $households = $query->get();

        if ($households->count() == 0) {
            return response()->apiSuccess("Wrong HouseHold Number or Data not found!", [], 105);
        }

        $householdIds = $households->pluck("hh_id")->toArray();

        $formattedMembers = [];
        $members = Beneficiary::select("village_id", "hh_id", "member_id", "name", "member_count")
                                ->whereIn("hh_id", $householdIds)
                                ->whereIn("village_id", $villageIds)
                                ->get();

        foreach($members as $member) {
            array_push($formattedMembers, [
                "village_id" => $member->village_id,
                "member_id" => intval($member->member_id),
                "member_name" => $member->name,
                "member_number" => $member->member_count,
                "household_number" => $member->hh_id
            ]);
        }

        $data = [
            "household_members" => $formattedMembers
        ];
        return response()->apiSuccess("Household Member Details", $data);
    }

    /**
     * Members Details
     * 
     * Returns the details of members of the particular memberId
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam member_id integer required Member Id of Household. Example: 0
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Member Kyc Details",
     *  "data": [
     *      [
     *          {
     *              "id": 26532,
     *              "village_id": 69,
     *              "hh_id": "1214001",
     *              "member_id": "121400101",
     *              "name": "Manda hiraman raut",
     *              "full_address": "Washala",
     *              "landmark": "",
     *              "age": "66",
     *              "marital_status": "widow_widower",
     *              "gender": "female",
     *              "income": "",
     *              "type_of_house": "",
     *              "disability": "no_disability",
     *              "status_of_women": "No",
     *              "religion": "",
     *              "land_ownership": "",
     *              "height_cm": "0",
     *              "weight_kg": "0",
     *              "created_at": "2022-09-29T11:37:55.000000Z",
     *              "updated_at": "2022-09-29T11:37:55.000000Z",
     *              "marital_sts": "widow_widower",
     *              "caste_cf": "Don't know",
     *              "aadhar_card": "Yes",
     *              "bank_ac": "Yes",
     *              "ele_card": "Yes",
     *              "widow_sts": "widow_widower",
     *              "education_sts": "-1",
     *              "caste": "OBC",
     *              "social_status": "bpl_antyodaya",
     *              "card_score": "",
     *              "state": "Maharashtra"
     *          }
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getMemberDetails(int $memberId, string $updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = Beneficiary::selectRaw("*, marital_status as marital_sts, caste_certificate as caste_cf, aadhaar_card as aadhar_card, bank_account as bank_ac, election_card as ele_card, widow_status as widow_sts, education_status as education_sts")
                            ->whereIn("village_id", $villageIds);

        if ($memberId != 0) {
            $query->where("member_id", $memberId);
        }

        if ($updateDate != "0") {
            $query->whereDate('updated_at','=', $updateDate);
        }

        $query->with([
            "household" => function ($query) use ($villageIds) {
                $query->select("village_id", "hh_id", "caste", "state", "card_score", "social_status");
                $query->whereIn("village_id", $villageIds);
            }
        ])->has("household");

        $members = $query->get();

        $formattedMembers = [];
        foreach($members as $member) {
            if (!$member->household) {
                continue;
            }

            $member->caste = $member->household->caste;
            $member->social_status = $member->household->social_status;
            $member->card_score = $member->household->card_score;
            $member->state = $member->household->state;

            $member->caste_cf = $member->caste_certificate == 1 ? "Yes" : ($member->caste_certificate == 0 ? "No" : "Don't know");
            $member->aadhar_card = $member->aadhaar_card == 1 ? "Yes" : ($member->aadhaar_card == 0 ? "No" : "Don't know");
            $member->bank_ac = $member->bank_account == 1 ? "Yes" : ($member->bank_account == 0 ? "No" : "Don't know");
            $member->ele_card = $member->election_card == 1 ? "Yes" : ($member->election_card == 0 ? "No" : "Don't know");
            $member->caste_cf = $member->caste_certificate == 1 ? "Yes" : ($member->caste_certificate == 0 ? "No" : "Don't know");
            $member->status_of_women = $member->status_of_women == 1 ? "Yes" : ($member->status_of_women == 0 ? "No" : "Don't know");
            $member->land_ownership = $member->land_ownership == 1 ? "Yes" : ($member->land_ownership == 0 ? "No" : "");

            $member->education_status = $member->education_status != -1 ? $member->education_status : "";
            $member->religion = $member->religion != -1 ? $member->religion : "";

            $memberArray = $member->toArray();
            unset($memberArray["household"]);
            unset($memberArray["member_count"]);
            unset($memberArray["caste_certificate"]);
            unset($memberArray["aadhaar_card"]);
            unset($memberArray["bank_account"]);
            unset($memberArray["election_card"]);
            unset($memberArray["education_status"]);
            unset($memberArray["widow_status"]);

            unset($memberArray["aadhaar_number"]);
            unset($memberArray["deleted_at"]);

            $cardScore = $memberArray["card_score"];
            if ($cardScore == "0_20") {
                $cardScore = "0 - 20";
            }else if ($cardScore == "above_20") {
                $cardScore = "Above 20";
            }
            $memberArray["card_score"] = $cardScore;
            $memberArray["state"] = ucfirst($memberArray["state"]);
            
            $caste = strtoupper($memberArray["caste"]);
            if ($caste == "GENERAL") {
                $caste = "General";
            }
            $memberArray["caste"] = $caste;

            $heightCM = $memberArray["height_cm"];
            if ($heightCM == null) {
                $heightCM = "0";
            }
            $memberArray["height_cm"] = $heightCM;

            $weightKGs = $memberArray["weight_kg"];
            if ($weightKGs == null) {
                $weightKGs = "0";
            }
            $memberArray["weight_kg"] = $weightKGs;

            array_push($formattedMembers, $memberArray);
        }

        return response()->apiSuccess("Member Kyc Details", [$formattedMembers]);
    }

    /**
     * Members KYC Details
     * 
     * Returns the member KYC documents
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam member_id integer required Member Id of Household. Example: 0
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Member Kyc Details",
     *  "data": [
     *      [
     *          {
     *              "id": 3,
     *              "name": "Another Test",
     *              "hh_id": "123456789014",
     *              "member_id": "1234567890141",
     *              "kyc_id": 1,
     *              "kyc_file_name": "1234567890141-1-1664673159.jpg",
     *              "kyc_remarks": "",
     *              "member_unique_id": null,
     *              "kyc_name": "Ration Card - Front Side",
     *              "updated_at": "2022-10-02T01:12:39.000000Z",
     *              "created_at": "2022-10-02T01:12:39.000000Z"
     *          }
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getMemberKYCs($memberId, $updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = kycDocument::whereIn("village_id", $villageIds);

        if ($memberId != 0) {
            $query->where("member_id", $memberId);
        }

        if ($updateDate != 0) {
            $query->whereDate('updated_at','=', $updateDate);
        }

        $query->with([
            "member" => function ($query) use ($villageIds) {
                $query->select("village_id", "member_id", "name");
                $query->whereIn("village_id", $villageIds);
            },
            "pre_requisite:id,name"
        ]);

        $documents = $query->get();

        $formattedDocuments = [];
        foreach($documents as $document) {
            array_push($formattedDocuments, [
                "id" => $document->id,
                "name" => $document->member->name,
                "hh_id" => $document->hh_id,
                "member_id" => $document->member_id,
                "kyc_id" => $document->prerequisite_id,
                "kyc_file_name" => $document->file_name,
                "kyc_remarks" => "",
                "member_unique_id" => $document->member->id,
                "kyc_name" => $document->pre_requisite->name,
                "updated_at" => $document->updated_at,
                "created_at" => $document->created_at
            ]);
        }

        return response()->apiSuccess("Member Kyc Details", [$formattedDocuments]);
    }

    /**
     * Register Member
     * 
     * Stores the newly created member in the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Member details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household new member added successfully",
     *  "data": [
     *      "member_count": 1
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function registerMember(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $members = $input->data;

        $modification = [
            "Currently Married" => "currently_married",
            "Never married" => "never_married",
            "Widow/Widower" => "widow_widower",
            "Divorced" => "divorced",
            "Separated" => "separated",
            "Semi Kaccha" => "semi_kaccha",
            "Kaccha" => "kaccha",
            "Pucca" => "pucca",
            "No Disability" => "no_disability",
            "Speech/hearing" => "speech_hearing",
            "Physical Disability" => "physical_disability",
            "Mental" => "mental",
            "Pregnant" => "pregnant"
        ];

        $insertedCount = 0;
        foreach($members as $member) {
            $hhId = $member->hh_id;
            $memberId = $member->member_id;
            $memberCount = intval(str_replace($hhId, "", $memberId));

            $household = Household::select("hh_id", "village_id")
                                        ->where("hh_id", $hhId)
                                        ->whereIn("village_id", $villageIds)
                                        ->with("village:id,name")
                                        ->first();

            if ($household) {
                $maritalStatus = $member->marital_sts;
                if (array_key_exists($maritalStatus, $modification)) {
                    $maritalStatus = $modification[$maritalStatus];
                }

                $widowStatus = $member->widow_sts;
                if (array_key_exists($widowStatus, $modification)) {
                    $widowStatus = $modification[$widowStatus];
                }

                $typeOfHouse = $member->type_of_house;
                if (array_key_exists($typeOfHouse, $modification)) {
                    $typeOfHouse = $modification[$typeOfHouse];
                }

                $disability = $member->disability;
                if (array_key_exists($disability, $modification)) {
                    $disability = $modification[$disability];
                }

                $statusOfWomen = $member->status_of_women;
                if (array_key_exists($statusOfWomen, $modification)) {
                    $statusOfWomen = $modification[$statusOfWomen];
                }

                $memberExists = Beneficiary::where([
                                    "village_id" => $household->village_id,
                                    "hh_id" => $hhId,
                                    "member_id" => $memberId
                                ])
                                ->exists();
                
                $villageName = $household->village->name;
                if (!$memberExists) {
                    $newMember = new Beneficiary;
                    $newMember->village_id = $household->village_id;
                    $newMember->hh_id = $hhId;
                    $newMember->member_id = $memberId;
                    $newMember->member_count = $memberCount;
                    $newMember->name = $member->name;
                    $newMember->full_address = $villageName;
                    $newMember->landmark = $villageName;
                    $newMember->age = $member->age;
                    $newMember->marital_status = $maritalStatus;
                    $newMember->gender = strtolower($member->gender);
                    $newMember->income = $member->income;
                    $newMember->caste_certificate = $member->caste_cf == "Yes" ? 1 : 0;
                    $newMember->type_of_house = $typeOfHouse;
                    $newMember->disability = $disability;
                    $newMember->aadhaar_card = $member->aadhar_card == "Yes" ? 1 : 0;
                    $newMember->bank_account = $member->bank_ac == "Yes" ? 1 : 0;
                    $newMember->election_card = $member->ele_card == "Yes" ? 1 : 0;
                    $newMember->widow_status = $widowStatus;
                    $newMember->status_of_women = $statusOfWomen;
                    $newMember->religion = $member->religion;
                    $newMember->land_ownership = $member->land_ownership == "Yes" ? 1 : 0;
                    $newMember->education_status = $member->education_sts;
                    $newMember->height_cm = $member->height_cm;
                    $newMember->weight_kg = $member->weight_kgs;
                    $newMember->save();
                    
                    $insertedCount++;
                }else {
                    Beneficiary::where([
                                    "village_id" => $household->village_id,
                                    "hh_id" => $hhId,
                                    "member_id" => $memberId
                                ])
                                ->update([
                                    "name" => $member->name,
                                    "full_address" => $villageName,
                                    "landmark" => $villageName,
                                    "age" => $member->age,
                                    "marital_status" => $maritalStatus,
                                    "gender" => strtolower($member->gender),
                                    "income" => $member->income,
                                    "caste_certificate" => $member->caste_cf == "Yes" ? 1 : 0,
                                    "type_of_house" => $typeOfHouse,
                                    "disability" => $disability,
                                    "aadhaar_card" => $member->aadhar_card == "Yes" ? 1 : 0,
                                    "bank_account" => $member->bank_ac == "Yes" ? 1 : 0,
                                    "election_card" => $member->ele_card == "Yes" ? 1 : 0,
                                    "widow_status" => $widowStatus,
                                    "status_of_women" => $statusOfWomen,
                                    "religion" => $member->religion,
                                    "land_ownership" => $member->land_ownership == "Yes" ? 1 : 0,
                                    "education_status" => $member->education_sts,
                                    "height_cm" => $member->height_cm,
                                    "weight_kg" => $member->weight_kgs
                                ]);
                }
            }
        }

        return response()->apiSuccess("Household new member added successfully", ["member_count" => $insertedCount]);
    }

    /**
     * Add Member KYC
     * 
     * Stores the member KYC document in the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Member KYC details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Member pre-requsite details updated successfully",
     *  "data": [
     *      "member_kyc_count": 1
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function saveMemberKYCs(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

		// Log::info($request->getContent());
        $input = json_decode($request->getContent());
        $documents = $input->data;

        $groupDocumentIds = [
            1, // Ration Card - Front Side
            2, // Ration Card - Back Side
            15, // Light Bill
            16 // Gas Bill
        ];

        $insertedCount = 0;
		// Log::info("Total Documents Count: ".count($documents));
        foreach($documents as $document) {
            $preRequisiteId = $document->Kyc_id;
            $memberId = $document->member_id;

            $checkMember = Beneficiary::select("village_id", "hh_id", "member_id")
                                        ->where("member_id", $memberId)
                                        ->whereIn("village_id", $villageIds)
                                        ->first();

            if (in_array($preRequisiteId, $groupDocumentIds)) {
                $householdMembers = Household::where([
                                        "village_id" => $checkMember->village_id,
                                        "hh_id" => $checkMember->hh_id,
                                        "member_id" => $checkMember->member_id
                                    ])
                                    ->with([
                                        "members" => function ($query) use ($villageIds) {
                                            $query->select("village_id", "member_id");
                                            $query->whereIn("village_id", $villageIds);
                                        }
                                    ]);
				// Log::info("HH Member count: ".count($householdMembers));

                foreach ($householdMembers as $member) {
                    $image ='data:image/jpg;base64,'.$document->kyc_file_input;
                    $imageData = substr($image, strpos($image, ',') + 1);
                    $imageData = base64_decode($imageData);

                    $imageName = $member->member_id."-".$preRequisiteId."-".time().".jpg";
                    Storage::disk('local')->put("public/kycs/".$imageName, $imageData);

                    $newDocument = new kycDocument;
                    $newDocument->village_id = $member->village_id;
                    $newDocument->hh_id = $checkMember->hh_id;
                    $newDocument->member_id = $member->member_id;
                    $newDocument->prerequisite_id = $preRequisiteId;
                    $newDocument->file_name = $imageName;
                    $newDocument->save();

                    $insertedCount++;
                }
            }else {
                $image ='data:image/jpg;base64,'.$document->kyc_file_input;
                $imageData = substr($image, strpos($image, ',') + 1);
                $imageData = base64_decode($imageData);

                $imageName = $checkMember->member_id."-".$preRequisiteId."-".time().".jpg";
                Storage::disk('local')->put("public/kycs/".$imageName, $imageData);

                $newDocument = new kycDocument;
                $newDocument->village_id = $checkMember->village_id;
                $newDocument->hh_id = $checkMember->hh_id;
                $newDocument->member_id = $checkMember->member_id;
                $newDocument->prerequisite_id = $preRequisiteId;
                $newDocument->file_name = $imageName;
                $newDocument->save();

                $insertedCount++;
            }
        }

		// Log::info("Member pre-requsite details updated successfully. Count: ".$insertedCount);
        return response()->apiSuccess("Member pre-requsite details updated successfully", ["member_kyc_count" => $insertedCount]);
    }

    /**
     * Delete Member KYC
     * 
     * Delete the member KYC document from the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Deleting KYC details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "KYC Detail has been deleted",
     *  "data": []
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function deleteMemberKYCs(Request $request)
    {
        $input = json_decode($request->getContent());
        
        $deleteValues = $input->data;
        foreach($deleteValues as $deleteDetails) {
            $kycId = $deleteDetails->kyc_id;

            kycDocument::where("id", $kycId)->delete();
        }

        return response()->apiSuccess("KYC Detail has been deleted", []);
    }

    /**
     * Get Deleted KYCs
     * 
     * Returns the deleted kyc documents of the member
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Deleted KYC Document Details",
     *  "data": [
     *      {
     *          "KYC_ID": 1
     *      }
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getDeletedKYCs($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = kycDocument::select("id as KYC_ID","village_id")
                            ->whereIn("village_id", $villageIds)
                            ->onlyTrashed();

        if ($updateDate != "0") {
            $query->whereDate('updated_at','>=',$updateDate);
        }

        $deleteDocuments = $query->get();

        $data = $deleteDocuments->pluck("KYC_ID")->toArray();
        $formattedData = array_map(function ($kycId) {
                            return [
                                "KYC_ID" => $kycId
                            ];
                        }, $data);

        return response()->apiSuccess("Deleted KYC Document Details", $formattedData);
    }
}
