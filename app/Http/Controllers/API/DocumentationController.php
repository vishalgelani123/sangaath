<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\Uservillage;
use App\Models\IncompleteForm;
use App\Models\ConfirmApplication;
use App\Models\Beneficiary;

/**
 * @group Applications
 *
 * APIs to manage applications of the users
 */
class DocumentationController extends Controller
{
    /**
     * Pending Applications
     * 
     * Returns the list of pending applications
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required Example: 0
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Pending Application Details",
     *  "data": [
     *      [
     *          {
     *              "Name": "Manda hiraman raut",
     *              "Villagename": "Washala",
     *              "ApplicationDetails": "121400101-1",
     *              "AppliedFor": "Indira Gandhi National Widow Pension Scheme",
     *              "AppliedDate": "2022-10-01",
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
    public function getPendingApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = ConfirmApplication::where("documentation_status", 0)
                                                ->whereIn("village_id", $villageIds);

        if ($updateDate != 0) {
            $query->whereDate('updated_at','=', $updateDate);
        }

        $query->with([
            "beneficiary" => function ($query) use ($villageIds) {
                $query->select("village_id", "member_id", "name");
                $query->whereIn("village_id", $villageIds);
            },
            "village:id,name",
            "scheme:id,name"
        ]);

        $pendingApplications = $query->get()
                            ->toArray();

        $formattedApplications = array_map(function ($application) {
                                    $registrationNum = $application["member_id"]."-".$application["scheme_id"];

                                    $data = [
                                        "Name" => $application["beneficiary"]["name"],
                                        "Villagename" => $application["village"]["name"],
                                        "ApplicationDetails" => $registrationNum,
                                        "AppliedFor" => $application["scheme"]["name"],
                                        "AppliedDate" => $application["created_at"],
                                        "hh_id" => $application["hh_id"],
                                        "member_id" => $application["member_id"],
                                        "scheme_id" => $application["scheme_id"]
                                    ];
                                    return $data;
                                }, $pendingApplications);

        
        return response()->apiSuccess("Pending Application Details", $formattedApplications);
    }
    
    /**
     * Incomplete Applications
     * 
     * Returns the list of incomplete applications
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required Example: 0
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Incomplete Application Details",
     *  "data": [
     *      [
     *          {
     *              "Name": "Manda hiraman raut",
     *              "Villagename": "Washala",
     *              "TempID": 1,
     *              "ApplicationDetails": "121400101-1",
     *              "AppliedFor": "Indira Gandhi National Widow Pension Scheme",
     *              "hh_id": "1214001",
     *              "member_id": "12140011",
     *              "scheme_id": "1",
     *              "created_at": "2022-09-29T11:37:55.000000Z",
     *              "updated_at": "2022-09-29T11:37:55.000000Z",
     *          }
     *      ]
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getIncompleteApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = IncompleteForm::where("status", "incomplete")
                                                ->whereIn("village_id", $villageIds);

        if ($updateDate != 0) {
            $query->whereDate('updated_at','=', $updateDate);
        }

        $query->with([
            "beneficiary" => function ($query) use ($villageIds) {
                $query->select("village_id", "member_id", "name");
                $query->whereIn("village_id", $villageIds);
            },
            "village:id,name",
            "scheme:id,name"
        ]);

        $incompleteApplications = $query->get()
                            ->toArray();

        $formattedApplications = array_map(function ($application) {

                                    $data = [
                                        "Name" => $application["beneficiary"]["name"],
                                        "Villagename" => $application["village"]["name"],
                                        "TempID" => $application["id"],
                                        "AppliedFor" => $application["scheme"]["name"],
                                        "hh_id" => $application["hh_id"],
                                        "member_id" => $application["member_id"],
                                        "scheme_id" => $application["scheme_id"],
                                        "created_at" => $application["created_at"],
                                        "updated_at" => $application["updated_at"]
                                    ];
                                    return $data;
                                }, $incompleteApplications);

        return response()->apiSuccess("Incomplete Application Details", $formattedApplications);
    }

    /**
     * Complete Applications
     * 
     * Returns the list of complete applications
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required Example: 0
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Complete Application Details",
     *  "data": [
     *      [
     *          {
     *              "Name": "Manda hiraman raut",
     *              "Villagename": "Washala",
     *              "TempID": 1,
     *              "ApplicationDetails": "121400101-1",
     *              "AppliedFor": "Indira Gandhi National Widow Pension Scheme",
     *              "AppliedDate": "2022-10-01",
     *              "Document_status": "Documentation_Complete",
     *              "Document_completed_Date": "2022-10-01",
     *              "Date of verify by FS": "2022-10-03",
     *              "Date of Submitted to Govt": "2022-10-05",
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
    public function getCompleteApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = ConfirmApplication::where("documentation_status", 1)
                                                ->whereIn("village_id", $villageIds);

        if ($updateDate != 0) {
            $query->whereDate('updated_at','=', $updateDate);
        }

        $query->with([
            "beneficiary" => function ($query) use ($villageIds) {
                $query->select("village_id", "member_id", "name");
                $query->whereIn("village_id", $villageIds);
            },
            "village:id,name",
            "scheme:id,name"
        ]);

        $completeApplications = $query->get()
                            ->toArray();

        $formattedApplications = array_map(function ($application) {
                                    $registrationNum = $application["member_id"]."-".$application["scheme_id"];

                                    $data = [
                                        "Name" => $application["beneficiary"]["name"],
                                        "Villagename" => $application["village"]["name"],
                                        "ApplicationDetails" => $registrationNum,
                                        "AppliedFor" => $application["scheme"]["name"],
                                        "AppliedDate" => $application["created_at"],
                                        "Document_status" => "Documentation_Complete",
                                        "Document_completed_Date" => $application["documentation_date"],
                                        "Date of verify by FS" => $application["liasoning_date"],
                                        "Date of Submitted to Govt" => $application["govt_submission_date"],
                                        "hh_id" => $application["hh_id"],
                                        "member_id" => $application["member_id"],
                                        "scheme_id" => $application["scheme_id"]
                                    ];
                                    return $data;
                                }, $completeApplications);

        return response()->apiSuccess("complete Application Details", $formattedApplications);
    }

    /**
     * Save Incomplete Application
     * 
     * Stores the incomplete application in the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Member details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Incomplete Application Details",
     *  "data": [
     *      "Incomplete_application_count": 1
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function saveIncompleteApplications(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $applications = $input->data;

        $insertedCount = 0;
        foreach($applications as $application) {
            $applicantId = $application->applicant_id;

            $beneficiary = Beneficiary::select("village_id", "hh_id", "member_id")
                                        ->where("member_id", $applicantId)
                                        ->whereIn("village_id", $villageIds)
                                        ->first();

            if ($beneficiary) {
                $newApplication = new IncompleteForm;
                $newApplication->helpdesk_user = $userId;
                $newApplication->village_id = $beneficiary->village_id;
                $newApplication->hh_id = $beneficiary->hh_id;
                $newApplication->member_id = $beneficiary->member_id;
                $newApplication->scheme_id = $application->scheme_id;
                $newApplication->status = $application->status;
                $newApplication->save();

                $insertedCount++;
            }
        }

        return response()->apiSuccess("Incomplete Application Details", ["Incomplete_application_count" => $insertedCount]);
    }

    /**
     * Save Pending Application
     * 
     * Stores the pending application in the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Member details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Pending Application Details",
     *  "data": [
     *      "Pending_application_count": 1
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function savePendingApplications(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $applications = $input->data;

        $insertedCount = 0;
        foreach($applications as $application) {
            $applicantId = $application->applicant_id;

            $beneficiary = Beneficiary::select("village_id", "hh_id", "member_id")
                                        ->where("member_id", $applicantId)
                                        ->whereIn("village_id", $villageIds)
                                        ->first();

            if ($beneficiary) {
                $newApplication = new ConfirmApplication;
                $newApplication->helpdesk_user = $application->helpdesk_user;
                $newApplication->village_id = $beneficiary->village_id;
                $newApplication->hh_id = $beneficiary->hh_id;
                $newApplication->member_id = $beneficiary->member_id;
                $newApplication->scheme_id = $application->scheme_id;
                $newApplication->eligible_status = "eligible";
                $newApplication->save();

                $insertedCount++;
            }
        }

        return response()->apiSuccess("Pending Application Details", ["Pending_application_count" => $insertedCount]);
    }

    /**
     * Delete Pending Application
     * 
     * Delete the pending application from the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Deleting KYC details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "PendingApplication has been deleted",
     *  "data": []
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function deletePendingApplications(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $deleteValues = $input->data;

        foreach($deleteValues as $deleteDetails) {
            $registrationNum = $deleteDetails->application_details;
            $splitRegistrationNum = explode("-", $registrationNum);

            $memberId = $splitRegistrationNum[0];
            $schemeId = $splitRegistrationNum[1];

            ConfirmApplication::where("member_id", $memberId)
                            ->where("scheme_id", $schemeId)
                            ->where("documentation_status", 0)
                            ->whereIn("village_id", $villageIds)
                            ->delete();
        }

        return response()->apiSuccess("PendingApplication has been deleted.", []);
    }

    /**
     * Delete Incomplete Application
     * 
     * Delete the incomplete application from the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Deleting KYC details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Incomplete has been deleted.",
     *  "data": []
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function deleteIncompleteApplications(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $deleteValues = $input->data;

        foreach($deleteValues as $deleteDetails) {
            $tempId = $deleteDetails->TempID;
            
            IncompleteForm::where("id", $tempId)
                            ->whereIn("village_id", $villageIds)
                            ->delete();
        }

        return response()->apiSuccess("Incomplete has been deleted.", []);
    }

    /**
     * Delete Complete Application
     * 
     * Delete the complete application from the storage
     * 
     * @header Authorization Bearer access_token
     * 
     * @bodyParam data json required Deleting KYC details. Example: {}
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "CompleteApplication has been deleted.",
     *  "data": []
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function deleteCompleteApplications(Request $request)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $input = json_decode($request->getContent());
        $deleteValues = $input->data;

        foreach($deleteValues as $deleteDetails) {
            $registrationNum = $deleteDetails->application_details;
            $splitRegistrationNum = explode("-", $registrationNum);

            $memberId = $splitRegistrationNum[0];
            $schemeId = $splitRegistrationNum[1];

            ConfirmApplication::where("member_id", $memberId)
                            ->where("scheme_id", $schemeId)
                            ->where("documentation_status", 1)
                            ->whereIn("village_id", $villageIds)
                            ->delete();
        }

        return response()->apiSuccess("CompletedApplication has been deleted.", []);
    }

    /**
     * Get Deleted Pending Applications
     * 
     * Returns the deleted pending applications of the member
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Deleted pending Application Details",
     *  "data": [
     *      {
     *          "application_details": 1
     *      }
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getDeletedPendingApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = ConfirmApplication::select("member_id","village_id","scheme_id","documentation_status")
                            ->where("documentation_status", 0)
                            ->whereIn("village_id", $villageIds)
                            ->onlyTrashed();

        if ($updateDate != "0") {
            $query->whereDate('updated_at','>=',$updateDate);
        }

        $deletedApplications = $query->get();

        $data = $deletedApplications->toArray();
        $formattedData = array_map(function ($application) {
                            $registrationNum = $application->member_id."-".$application->scheme_id;

                            return [
                                "application_details" => $registrationNum
                            ];
                        }, $data);

        return response()->apiSuccess("Deleted pending Application Details", $formattedData);
    }

    /**
     * Get Deleted Incomplete Applications
     * 
     * Returns the deleted incomplete applications of the member
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Deleted Incomplete Application Details",
     *  "data": [
     *      {
     *          "TempID": 1
     *      }
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getDeletedIncompleteApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = IncompleteForm::select("id as TempID","village_id","status")
                            ->where("status", "incomplete")
                            ->whereIn("village_id", $villageIds)
                            ->onlyTrashed();

        if ($updateDate != "0") {
            $query->whereDate('updated_at','>=',$updateDate);
        }

        $deletedApplications = $query->get();

        $data = $deletedApplications->pluck("TempID")->toArray();
        $formattedData = array_map(function ($tempId) {
                            return [
                                "TempID" => $tempId
                            ];
                        }, $data);

        return response()->apiSuccess("Deleted Incomplete Application Details", $formattedData);
    }

    /**
     * Get Deleted Complete Applications
     * 
     * Returns the deleted complete applications of the member
     * 
     * @header Authorization Bearer access_token
     * 
     * @urlParam update_date string required
     * 
     * @response scenario=success {
     *  "status": "success",
     *  "Message": "Deleted complete Application Details",
     *  "data": [
     *      {
     *          "application_details": 1
     *      }
     *  ]
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getDeletedCompleteApplications($updateDate)
    {
        $userId = request()->user()->id;

        $userVillages = Uservillage::where("user_id", $userId)
                                    ->get();
        $villageIds = $userVillages->pluck("village_id")
                                    ->toArray();

        $query = ConfirmApplication::select("member_id","village_id","scheme_id","documentation_status")
                            ->where("documentation_status", 1)
                            ->whereIn("village_id", $villageIds)
                            ->onlyTrashed();

        if ($updateDate != "0") {
            $query->whereDate('updated_at','>=',$updateDate);
        }

        $deletedApplications = $query->get();

        $data = $deletedApplications->toArray();
        $formattedData = array_map(function ($application) {
                            $registrationNum = $application->member_id."-".$application->scheme_id;

                            return [
                                "application_details" => $registrationNum
                            ];
                        }, $data);

        return response()->apiSuccess("Deleted complete Application Details", $formattedData);
    }
}
