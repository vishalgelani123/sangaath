<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Uservillage;
use App\Models\ConfirmApplication;

/**
 * @group Follow Up
 *
 * APIs to manage followup details of the users
 */
class FollowUpController extends Controller
{
    /**
     * Get Follow-Ups
     * 
     * Returns the list of pending followups
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required Example: 0
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Get Follow-up Details.",
     *  "data": [
     *      [
     *          {
     *              "Name": "Manda hiraman raut",
     *              "Villagename": "Washala",
     *              "ApplicationDetails": "121400101-1",
     *              "AppliedSchemeName": "Indira Gandhi National Widow Pension Scheme",
     *              "ApplicationDate": "2022-10-01",
     *              "FollowUpDays": 10,
     *              "FollowUpDate": "2022-10-112",    
     *              "hh_id": "1214001",
     *              "member_id": "12140011",
     *              "scheme_id": "1"
     *          }
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getFollowUps($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = ConfirmApplication::where([
                                        "documentation_status" => 1,
                                        "liasoning_status" => 1,
                                        "govt_submission_status" => 1,
                                        "benefit_status" => 0,
                                    ])
                                    ->whereIn("village_id", $villageIds);

        if ($updateDate != 0) {
            $query->whereDate('followup_date','=', $updateDate);
        }else {
            $query->where("followup_date", "<=", date("Y-m-d"));
        }

        $query->with([
            "beneficiary" => function ($query) use ($villageIds) {
                $query->select("village_id", "member_id", "name");
                $query->whereIn("village_id", $villageIds);
            },
            "village:id,name",
            "scheme:id,name,followup_days"
        ]);

        $applications = $query->get()
                            ->toArray();

        $formattedApplications = array_map(function ($application) {
            $registrationNum = $application["member_id"]."-".$application["scheme_id"];

            $data = [
                "Name" => $application["beneficiary"]["name"],
                "Villagename" => $application["village"]["name"],
                "ApplicationDetails" => $registrationNum,
                "AppliedSchemeName" => $application["scheme"]["name"],
                "ApplicationDate" => $application["govt_submission_date"],
                "FollowUpDays" => $application["scheme"]["followup_days"],
                "FollowUpDate" => $application["followup_date"],
                "hh_id" => $application["hh_id"],
                "member_id" => $application["member_id"],
                "scheme_id" => $application["scheme_id"]
            ];
            return $data;
        }, $applications);

        return response()->apiSuccess("Get Follow-up Details.", $formattedApplications);
    }

    /**
     * Update Follow-Up
     * 
     * Saves the follow-up details in the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Member details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "FollowUp Detail has been updated.",
     *  "data": []
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function updateFollowUp(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();
                                    
        $input = json_decode($request->getContent());
        $followUps = $input->data;

        foreach($followUps as $followUpDetail) {
            $registrationNum = $followUpDetail->application_details;
            $splitRegistrationNum = explode("-", $registrationNum);

            $memberId = $splitRegistrationNum[0];
            $schemeId = $splitRegistrationNum[1];

            $image ='data:image/jpg;base64,'.$followUpDetail->benefit_image;
            $imageData = substr($image, strpos($image, ',') + 1);
            $imageData = base64_decode($imageData);

            $imageName = $memberId."-".$schemeId."-".time().".jpg";
            Storage::disk('local')->put("public/beneficiaries/".$imageName, $imageData);

            ConfirmApplication::where([
                                    "member_id" => $memberId,
                                    "scheme_id" => $schemeId
                                ])
                                ->whereIn("village_id", $villageIds)
                                ->update([
                                    "benefit_status" => $followUpDetail->benefitReceived == "Yes" ? 1 : 0,
                                    "reject_reason" => $followUpDetail->Reason,
                                    "if_discrepancy" => $followUpDetail->Discrepancy,
                                    "benefit_date" => $followUpDetail->Date,
                                    "beneficiary_image" => $imageName
                                ]);
        }

        return response()->apiSuccess("FollowUp Detail has been updated.", []);
    }
}
