<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Scheme;
use App\Models\SchemeDocument;
use App\Models\SchemeRule;
use App\Models\PreRequisite;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Inertia;
     */
    public function index()
    {
        $schemes = Scheme::with("documents", "rules")
                            ->get()
                            ->map(function($scheme) {
                                return $scheme->format();
                            });
        $preRequisites = PreRequisite::get()->keyBy("id");

        return Inertia::render("Scheme", ["all_schemes" => $schemes, "prerequisites" => $preRequisites, "rule_values" => $this->ruleValues()]);
    }

    /**
     * Save the schemes in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $category = $request->category;
        $department = $request->department;
        $name = $request->name;
        $type = $request->type;
        $followupDays = $request->followup_days;
        $selectedPreRequisites = json_decode($request->pre_requisites, true);
        $isActive = $request->is_active;

        $saveType = $request->save_type;
        $schemeId = $request->scheme_id;

        if ($saveType == "new") {
            $scheme = new Scheme;
            $scheme->category = $category;
            $scheme->department = $department;
            $scheme->name = $name;
            $scheme->type = $type;
            $scheme->followup_days = $followupDays;
            $scheme->is_active = $isActive;
            $scheme->save();

            $schemeId = $scheme->id;
        }else {
            Scheme::where("id", $schemeId)
                    ->update([
                        "category" => $category,
                        "department" => $department,
                        "name" => $name,
                        "type" => $type,
                        "followup_days" => $followupDays,
                        "is_active" => $isActive
                    ]);

            // Clearing existing documents
            SchemeDocument::where("scheme_id", $schemeId)
                            ->forceDelete();
        }

        foreach($selectedPreRequisites as $documentId) {
            $document = new SchemeDocument;
            $document->scheme_id = $schemeId;
            $document->prerequisite_id = $documentId; 
            $document->save();
        }

        return response()->success([]);
    }

    /**
     * Save the scheme rules in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveRules(Request $request)
    {
        $rules = json_decode($request->rules, true);
        $schemeId = $request->scheme_id;

        // Clearing existing rules
        SchemeRule::where("scheme_id", $schemeId)
                    ->forceDelete();

        foreach($rules as $rule) {
            $field = $rule["field"]["value"];
            $operator = $rule["operator"]["value"];
            $matchingValue = $rule["matching_value"]["value"];

            $rule = new SchemeRule;
            $rule->scheme_id = $schemeId;
            $rule->rule_name = $field;
            $rule->rule_value = $matchingValue;
            $rule->match_type = $operator;
            $rule->save();
        }

        return response()->success([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $schemeId = $request->scheme_id;
        Scheme::where("id", $schemeId)
                ->delete();

        return response()->success([]);
    }

    /**
     * Get the rule values
     */
    private function ruleValues()
    {
        $maritalStatus = [
            [
                "name" => "Currently Married",
                "value" => "currently_married"
            ],
            [
                "name" => "Never Married",
                "value" => "never_married"
            ],
            [
                "name" => "Divorced",
                "value" => "divorced"
            ],
            [
                "name" => "Separated",
                "value" => "separated"
            ],
            [
                "name" => "Widow/Widower",
                "value" => "widow_widower"
            ]
        ];

        $yesNo = [
            [
                "name" => "Yes",
                "value" => "yes"
            ],
            [
                "name" => "No",
                "value" => "no"
            ]
        ];

        $values = [
            "state" => [
                [
                    "name" => "Gujarat",
                    "value" => "gujarat"
                ],
                [
                    "name" => "Maharashtra",
                    "value" => "maharashtra"
                ],
                [
                    "name" => "Haryana",
                    "value" => "haryana"
                ],
                [
                    "name" => "Madhya Pradesh",
                    "value" => "madhya_pradesh"
                ],
                [
                    "name" => "Rajasthan",
                    "value" => "rajasthan"
                ]
            ],
            "social_status" => [
                [
                    "name" => "APL",
                    "value" => "apl"
                ],
                [
                    "name" => "BPL",
                    "value" => "bpl"
                ]
            ],
            "caste" => [
                [
                    "name" => "SC",
                    "value" => "sc"
                ],
                [
                    "name" => "ST",
                    "value" => "st"
                ],
                [
                    "name" => "OBC",
                    "value" => "obc"
                ],
                [
                    "name" => "General",
                    "value" => "general"
                ]
            ],
            "age" => "number",
            "gender" => [
                [
                    "name" => "Male",
                    "value" => "male"
                ],
                [
                    "name" => "Female",
                    "value" => "female"
                ]
            ],
            "marital_status" => $maritalStatus,
            "disability_status" => [
                [
                    "name" => "No Disability",
                    "value" => "no_disability"
                ],
                [
                    "name" => "Physical Disability",
                    "value" => "physical_disability"
                ],
                [
                    "name" => "Mental",
                    "value" => "mental"
                ],
                [
                    "name" => "Speech/hearing",
                    "value" => "speech_hearing"
                ]
            ],
            "type_of_house" => [
                [
                    "name" => "Kaccha",
                    "value" => "kaccha"
                ],
                [
                    "name" => "Semi Kaccha",
                    "value" => "semi_kaccha"
                ],
                [
                    "name" => "Pucca",
                    "value" => "pucca"
                ]
            ],
            "aadhaar_card" => $yesNo,
            "bank_account" => $yesNo,
            "election_card" => $yesNo,
            "widow_status" => $maritalStatus,
            "status_of_women" => $yesNo,
            "land_ownership" => $yesNo,
            "card_score" => [
                [
                    "name" => "0 - 20",
                    "value" => "0_20"
                ],
                [
                    "name" => "Above 20",
                    "value" => "above_20"
                ]
            ]
        ];

        return $values;
    }
}
