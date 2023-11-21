<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use App\Models\Uservillage;
use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\PreRequisite;
use App\Models\Scheme;
use App\Models\kycDocument;
use App\Models\ConfirmApplication;

class HouseholdController extends Controller
{
    /**
     * Get the household associated with this row id
     *
     * @param int $householdRowId
     * @return mixed
     */
    public function viewHousehold($householdRowId)
    {
        $userId = request()->user()->id;
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $household = Household::whereIn("village_id", $villageIds)
            ->with("village")
            ->where("id", $householdRowId)
            ->first();


        if ($household) {
            $beneficiaries = Beneficiary::where([
                "village_id" => $household->village_id,
                "hh_id" => $household->hh_id
            ])
                ->get()
                ->map(function ($beneficiary) {
                    return $beneficiary->checkIncompleteData();
                });

            return Inertia::render("Household", ["household" => $household, "beneficiaries" => $beneficiaries]);
        }

        return redirect(url('/dashboard'));
    }

    /**
     * Get the schemes for the member
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSchemes(Request $request)
    {
        $memberRowId = $request->member_row_id;
        $hhId = $request->hh_id;

        $household = Household::select("id", "social_status", "card_score", "caste", "state")
            ->where("id", $hhId)
            ->first();

        $member = Beneficiary::where("id", $memberRowId)
            ->first();

        $memberValueMap = [
            "age" => intval($member->age),
            "social_status" => $household->social_status,
            "card_score" => $household->card_score,
            "caste" => $household->caste,
            "state" => $household->state,
            "gender" => $household->gender,
            "marital_status" => $member->marital_status,
            "disability_status" => $member->disability,
            "type_of_house" => $member->type_of_house,
            "widow_status" => $member->widow_status,
            "aadhaar_card" => $member->aadhaar_card == 1 ? "yes" : "no",
            "bank_account" => $member->bank_account == 1 ? "yes" : "no",
            "election_card" => $member->election_card == 1 ? "yes" : "no",
            "land_ownership" => $member->land_ownership == 1 ? "yes" : "no"
        ];

        $schemes = Scheme::select("id", "name", "type", "is_active")
            ->where("is_active", 1)
            ->with("rules")
            ->orderBy("name", "ASC")
            ->get();

        $availableSchemes = [
            "eligible" => [],
            "pre_requisite" => [],
            "partial_match" => []
        ];

        foreach($schemes as $scheme) {
            $formattedScheme = $scheme->only(["id", "name", "type"]);

            if ($scheme->type == "prerequisite") {
                array_push($availableSchemes["pre_requisite"], $formattedScheme);
                continue;
            }

            $isEligible = true;
            $rules = $scheme->rules;
            foreach($rules as $rule) {
                $fieldName = $rule->rule_name;
                $fieldValue = $rule->rule_value;
                $operator = $rule->match_type;

                $correspondingMemberValue = $memberValueMap[$fieldName];

                if ($operator == "equal_to") {
                    if ($fieldValue != $correspondingMemberValue) {
                        $isEligible = false;
                        break;
                    }
                }else if ($operator == "greater_than") {
                    if (intval($fieldValue) <= $correspondingMemberValue) {
                        $isEligible = false;
                        break;
                    }
                }else if ($operator == "less_than") {
                    if (intval($fieldValue) > $correspondingMemberValue) {
                        $isEligible = false;
                        break;
                    }
                }
            }

            if ($isEligible) {
                array_push($availableSchemes["eligible"], $formattedScheme);
            }else {
                array_push($availableSchemes["partial_match"], $formattedScheme);
            }
        }

        return response()->success(["schemes" => $availableSchemes]);
    }

    /**
     * Get the details of a specific scheme
     *
     * @param int $schemeId
     * @param int $memberRowId
     * @return \Illuminate\Http\Response
     */
    public function getSchemeDetails($schemeId, $memberRowId)
    {
        $beneficiary = Beneficiary::where("id", $memberRowId)
            ->first();

        $villageId = $beneficiary->village_id;
        $hhId = $beneficiary->hh_id;
        $memberId = $beneficiary->member_id;
        $uploadedDocuments = kycDocument::where([
            "village_id" => $villageId,
            "hh_id" => $hhId,
            "member_id" => $memberId
        ])
            ->get()
            ->pluck("file_name", "prerequisite_id")
            ->toArray();

        $scheme = Scheme::select("id")
            ->where("id", $schemeId)
            ->with("documents.pre_requisite:id,name")
            ->first();

        $requiredDocuments = $scheme->documents->keyBy("prerequisite_id")->toArray();
        foreach($uploadedDocuments as $documentId => $fileName) {
            if (in_array($documentId, array_keys($requiredDocuments))) {
                // This document is already uploaded
                $url = url('/').Storage::url("kycs/".$fileName);
                $requiredDocuments[$documentId]["is_selected"] = true;
                $requiredDocuments[$documentId]["preview_url"] = $url;
            }
        }

        return response()->success(["documents" => $requiredDocuments]);
    }

    /**
     * Get Pre-Requisites for a member
     *
     * @param int $memberRowId
     * @return \Illuminate\Http\Response
     */
    public function getPreRequisites($memberRowId)
    {
        $preRequisite = PreRequisite::select("id", "name", "is_active")
            ->where("is_active", 1)
            ->get()
            ->keyBy("id")
            ->toArray();

        $beneficiary = Beneficiary::where("id", $memberRowId)
            ->first();

        $villageId = $beneficiary->village_id;
        $hhId = $beneficiary->hh_id;
        $memberId = $beneficiary->member_id;
        $uploadedDocuments = kycDocument::where([
            "village_id" => $villageId,
            "hh_id" => $hhId,
            "member_id" => $memberId
        ])
            ->get()
            ->pluck("file_name", "prerequisite_id")
            ->toArray();

        foreach($uploadedDocuments as $documentId => $fileName) {
            if (in_array($documentId, array_keys($preRequisite))) {
                $url = url('/')."/storage/app/public/kycs/".$fileName;

                $preRequisite[$documentId]["is_selected"] = true;
                $preRequisite[$documentId]["preview_url"] = $url;
            }
        }

        return response()->success(["pre_requisites" => $preRequisite]);
    }

    /**
     * Saves the pre-requisites files in storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function savePreRequisites(Request $request)
    {
        $memberRowId = $request->member_row_id;

        $selectedDocuments = json_decode($request->selected_documents, true);
        $uploadingDocuments = json_decode($request->uploading_documents, true);

        $beneficiary = Beneficiary::select("id", "village_id", "hh_id", "member_id")
            ->where("id", $memberRowId)
            ->first();

        kycDocument::where([
            "village_id" => $beneficiary->village_id,
            "hh_id" => $beneficiary->hh_id,
            "member_id" => $beneficiary->member_id
        ])
            ->whereNotIn("prerequisite_id", $selectedDocuments)
            ->delete();

        foreach($uploadingDocuments as $documentId) {
            $image = $request->file("document_".$documentId);

            if ($image) {
                $imageName = $beneficiary->member_id."-".$documentId."-".time().".".$image->extension();
                $image->move("storage/kycs", $imageName);


                kycDocument::where([
                    "village_id" => $beneficiary->village_id,
                    "hh_id" => $beneficiary->hh_id,
                    "member_id" => $beneficiary->member_id,
                    "prerequisite_id" => $documentId
                ])
                    ->delete();


                $document = new kycDocument;
                $document->village_id = $beneficiary->village_id;
                $document->hh_id = $beneficiary->hh_id;
                $document->member_id = $beneficiary->member_id;
                $document->prerequisite_id = $documentId;
                $document->file_name = $imageName;
                $document->save();
            }
        }

        return response()->success([]);
    }

    /**
     * Get the applications of the member
     *
     * @param int $memberRowId
     * @return \Illuminate\Http\Response
     */
    public function getApplications($memberRowId)
    {
        $beneficiary = Beneficiary::where("id", $memberRowId)
            ->first();

        $villageId = $beneficiary->village_id;
        $hhId = $beneficiary->hh_id;
        $memberId = $beneficiary->member_id;

        $applications = ConfirmApplication::where([
            "village_id" => $villageId,
            "hh_id" => $hhId,
            "member_id" => $memberId
        ])
            ->with("scheme:id,name,department")
            ->get()
            ->map(function($application) {
                return $application->format();
            });

        return response()->success(["applications" => $applications]);
    }

    /**
     * Save the member in the storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveMember(Request $request)
    {
        $hhId = $request->hh_id;
        $villageId = $request->village_id;
        $existingMemberCount = $request->existing_member_count;

        $name = $request->name;
        $age = $request->age;

        $memberId = $hhId.($existingMemberCount + 1);
        $memberCount = $existingMemberCount + 1;

        $beneficiary = new Beneficiary;
        $beneficiary->village_id = $villageId;
        $beneficiary->hh_id = $hhId;
        $beneficiary->member_id = $memberId;
        $beneficiary->member_count = $memberCount;
        $beneficiary->name = $name;
        $beneficiary->age = $age;
        $beneficiary->save();

        return response()->success([]);
    }

    /**
     * Save the member's pending details
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function savePending(Request $request)
    {
        $hhId = $request->hh_id;
        $memberId = $request->member_id;
        $villageId = $request->village_id;

        $gender = $request->gender;
        $maritalStatus = $request->marital_status;
        $disabilityStatus = $request->disability_status;
        $typeOfHouse = $request->type_of_house;
        $aadhaarCard = $request->aadhaar_card;
        $bankAccount = $request->bank_account;
        $electionCard = $request->election_card;
        $landOwnership = $request->land_ownership;
        $widowStatus = $request->widow_status;
        $cardScore = $request->card_score;
        $income = $request->income;

        Beneficiary::where([
            "hh_id" => $hhId,
            "member_id" => $memberId,
            "village_id" => $villageId
        ])
            ->update([
                "gender" => $gender,
                "marital_status" => $maritalStatus,
                "disability" => $disabilityStatus,
                "type_of_house" => $typeOfHouse,
                "aadhaar_card" => $aadhaarCard,
                "bank_account" => $bankAccount,
                "election_card" => $electionCard,
                "land_ownership" => $landOwnership,
                "widow_status" => $widowStatus,
                "income" => $income
            ]);

        Household::where([
            "hh_id" => $hhId,
            "village_id" => $villageId
        ])
            ->update([
                "card_score" => $cardScore
            ]);


        return response()->success([]);
    }
}
