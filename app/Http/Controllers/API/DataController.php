<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Site;
use App\Models\Village;
use App\Models\Uservillage;
use App\Models\Scheme;
use App\Models\PreRequisite;

/**
 * @group Basic Data
 *
 * APIs to get basic data from the server
 */
class DataController extends Controller
{
    /**
     * Alloted Villages
     * 
     * Returns the villages alloted to the user
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Village List",
     *  "data": [
     *      [
     *          "id": "village_id",
     *          "Value": "village_name",
     *          "State": "state_name"
     *      ]
     *  ]
     * }
     * @response status=100 scenario="no villages" {"message": "No village allocated to the user"}
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getVillages()
    {
        $userId = request()->user()->id;

        $allotedVilages = Uservillage::where("user_id", $userId)
                                    ->has("village_name.site")
                                    ->with("village_name.site")
                                    ->get();

        if ($allotedVilages->count() > 0) {
            $data = [];

            foreach($allotedVilages as $village) {
                $stateName = $village->village_name->site->state;
                $stateName = str_replace("_", " ", $stateName);
                $stateName = ucwords($stateName);

                array_push($data, [
                    "id" => $village->village_id,
                    "Value" => $village->village_name->name,
                    "State" => $stateName
                ]);
            }

            return response()->apiSuccess("Village List", $data);
        }

        // No villages allocated
        return response()->apiFailed("No villages allocated", 100);
    }

    /**
     * Social Status
     * 
     * Returns the available social statuses
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Social Status List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "APL"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getSocialStatus()
    {
        $socialStatus = [
            ['id' => '1', 'value' => 'APL'],
            ['id' => '2', 'value' => 'APL - 1'],
            ['id' => '3', 'value' => 'APL - 2'],
            ['id' => '4', 'value' => 'BPL'],
            ['id' => '5', 'value' => 'BPL Antyodaya'],
        ];

        return response()->apiSuccess("Social Status List", $socialStatus);
    }

    /**
     * Household Income
     * 
     * Returns the available household incomes
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household Income List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "Less than 1,20,000"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getHouseholdIncomes()
    {
        $HouseholdIncomes = [
            ['id' => '1', 'value' => 'Less than 1,20,000'],
            ['id' => '2', 'value' => '1,20,000 – 4,00,000'],
            ['id' => '3', 'value' => 'More than 4,00,000']
        ];

        return response()->apiSuccess("Household Income List", $HouseholdIncomes);
    }

    /**
     * Castes
     * 
     * Returns the available castes
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Caste List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "ST"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getCastes()
    {
        $castes = [
            ['id' => '1', 'value' => 'ST'],
            ['id' => '2', 'value' => 'SC'],
            ['id' => '3', 'value' => 'obc'],
            ['id' => '4', 'value' => 'General'],
        ];

        return response()->apiSuccess("Caste List", $castes);
    }

    /**
     * Disability Status
     * 
     * Returns the available disability statuses
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Disability List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "No Disability"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getDisabilityStatus()
    {
        $disabilityStatus = [
            [
                "id" => "1",
                "value" => "No Disability"
            ],
            [
                "id" => "2",
                "value" => "Physical Disability"
            ],
            [
                "id" => "3",
                "value" => "Mental"
            ],
            [
                "id" => "4",
                "value" => "Speech/hearing"
            ]
        ];

        return response()->apiSuccess("Disability List", $disabilityStatus);
    }

    /**
     * House Type
     * 
     * Returns the available house types
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Household Type List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "Kaccha"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getHouseType()
    {
        $houseType = [
            [
                "id" => "1",
                "value" => "Kaccha"
            ],
            [
                "id" => "2",
                "value" => "Semi Kaccha"
            ],
            [
                "id" => "3",
                "value" => "Pucca"
            ]
        ];

        return response()->apiSuccess("House Type List", $houseType);
    }

    /**
     * Card Scores
     * 
     * Returns the available card scores
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Card Score List",
     *  "data": [
     *      [
     *          "id": "1",
     *          "value": "0 - 20"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getCardScores()
    {
        $cardScores = [
            [
                "id" => "1",
                "value" => "0 - 20"
            ],
            [
                "id" => "2",
                "value" => "Above 20"
            ]
        ];

        return response()->apiSuccess("Card Score List", $cardScores);
    }

    /**
     * Schemes
     * 
     * Returns the available schemes
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "scheme_details_list",
     *  "data": [
     *      [
     *          "id": 1,
     *          "scheme_name": "Indira Gandhi National Widow Pension Scheme",
     *          "category": "State Level",
     *          "department": "Department of social security",
     *          "req_kycs": "[1,2,3,4,8,9,12,14,38,39,40,41,42]",
     *          "rules": "[[\"social_status\",\"BPL\"],[\"age\",\"18\"],[\"gender\",\"Female\"],[\"marital_sts\",\"Widow\\/Widower\"],[\"aadhar_card\",\"Yes\"],[\"bank_ac\",\"Yes\"],[\"widow_sts\",\"Widow\\/Widower\"],[\"status_of_women\",\"No\"],[\"card_score\",\"0 - 20\"]]",
     *          "type": "Scheme",
     *          "status": "Active",
     *          "followup_days": "45",
     *          "updated_at": "2022-09-29T11:37:55.000000Z",
     *          "created_at": "2022-09-29T11:37:55.000000Z"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getSchemes()
    {
        $schemes = Scheme::with("documents", "rules")
                        ->get();

        $fieldNameModification = [
            "marital_status" => "marital_sts",
            "widow_status" => "widow_sts",
            "bank_account" => "bank_ac",
            "election_card" => "ele_card",
            "aadhaar_card" => "aadhar_card",
            "education_status" => "education_sts",
            "caste_certificate" => "caste_cf"
        ];

        $ruleValueModification = [
            "widow_widower" => "Widow/Widower",
            "0_20" => "0 - 20",
            "above_20" => "Above 20",
            "currently_married" => "Currently Married",
            "never_married" => "Never Married",
            "sc" => "SC",
            "st" => "ST",
            "obc" => "OBC",
            "semi_kaccha" => "Semi Kaccha",
            "no_disability" => "No Disability",
            "physical_disability" => "Physical Disability",
            "speech_hearing" => "Speech/hearing",
            "apl-1" => "APL - 1",
            "apl-2" => "APL - 2",
            "bpl" => "BPL",
            "apl" => "APL",
            "bpl_antyodaya" => "BPL Antyodaya"
        ];

        $formattedSchemes = [];
        foreach($schemes as $scheme) {
            $category = trim(ucfirst($scheme->category))." Level";
            $requestKycs = $scheme->documents->pluck("prerequisite_id")->toArray();

            $formattedRules = [];
            $rules = $scheme->rules;
            foreach($rules as $rule) {
                $fieldName = $rule->rule_name;
                $operator = $rule->match_type;
                if ($operator == "less_than" && $fieldName == "age") {
                    $fieldName = "uptoage";
                }

                if (array_key_exists($fieldName, $fieldNameModification)) {
                    $fieldName = $fieldNameModification[$fieldName];
                }

                $ruleValue = $rule->rule_value;
                if (array_key_exists($ruleValue, $ruleValueModification)) {
                    $ruleValue = $ruleValueModification[$ruleValue];   
                }
                $ruleValue = ucwords($ruleValue);

                array_push($formattedRules, [
                    $fieldName, $ruleValue
                ]);
            }

            array_push($formattedSchemes, [
                "id" => $scheme->id,
                "scheme_name" => $scheme->name,
                "category" => $category,
                "department" => $scheme->department,
                "req_kycs" => json_encode($requestKycs),
                "rules" => json_encode($formattedRules),
                "type" => $scheme->type == "scheme" ? "Scheme" : "KYC",
                "status" => $scheme->is_active == 1 ? "Active" : "Inactive",
                "followup_days" => $scheme->followup_days,
                "updated_at" => $scheme->updated_at,
                "created_at" => $scheme->created_at
            ]);
        }

        return response()->apiSuccess("scheme_details_list", $formattedSchemes);
    }

    /**
     * Pre-Requisites
     * 
     * Returns the list of available pre-requisites
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "KYC_list",
     *  "data": [
     *      [
     *          "id": 1,
     *          "kyc_name": "Ration Card - Front Side"
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getPreRequisites()
    {
        $preRequisites = PreRequisite::select("id", "name as kyc_name")->get();

        return response()->apiSuccess("KYC_list", $preRequisites);
    }
}
