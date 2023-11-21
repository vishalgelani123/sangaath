<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

use App\Models\Uservillage;
use App\Models\ConfirmApplication;

class GovtSubmissionController extends Controller
{
    /**
     * Get the applications whose documentation and liasoning is done
     */
    public function index(Request $request)
    {
        $userId = request()->user()->id;
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->has("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $formsQuery = ConfirmApplication::where("documentation_status", 1)
            ->where("liasoning_status", 1)
            ->where("govt_submission_status", 0)
            ->whereIntegerInRaw("village_id", $villageIds)
            ->with("beneficiary.village:id,name", "scheme:id,name");

        $formsQuery->with(["beneficiary" => function ($query) use ($villageIds) {
            $query->whereIntegerInRaw("village_id", $villageIds);
            $query->select("id", "member_id", "village_id", "name");
        }]);

        $search = $request->get("search");
        if ($search) {
            $formsQuery->where(function ($query) use ($search) {
                $query->whereHas('beneficiary', function ($query) use ($search) {
                    $query->select("id", "member_id", "village_id", "name");
                    $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('member_id', 'LIKE', "%$search%");
                })
                    ->orWhereHas('beneficiary.village', function ($query) use ($search) {
                        $query->select("id", "name");
                        $query->where('name', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('scheme', function ($query) use ($search) {
                        $query->select("id", "name");
                        $query->where('name', 'LIKE', "%$search%");
                    })
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%$search%"])
                    ->orWhereRaw("DATE_FORMAT(documentation_date, '%d %b %Y') LIKE ?", ["%$search%"])
                    ->orWhereRaw("DATE_FORMAT(liasoning_date, '%d %b %Y') LIKE ?", ["%$search%"]);
            });
        }

        $take = 50;
        $formsQuery->take($take);

        if ($request->get('is_ajax')) {
            $skip = $request->get("skip");
            $formsQuery->skip($skip);
        }

        $forms = $formsQuery->get()
            ->map(function ($application) {
                return $application->format();
            });

        if ($request->get('is_ajax')) {
            return ["status" => 1, "rows" => $forms];
        }

        return Inertia::render("GovtSubmission", ["initial_forms" => $forms]);
    }

    /**
     * Generate the Govt. Submission reports for the form id
     *
     * @param string $formIds
     * @return \Illuminate\Http\Response
     */
    public function generateReport($formIds)
    {
        $splitIds = explode(",", $formIds);

        $userId = request()->user()->id;
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $tr= "";
        $count = 1;
        foreach($splitIds as $formId) {
            $form = ConfirmApplication::where("id", $formId)
                ->whereIn("village_id", $villageIds)
                ->with([
                    "beneficiary" => function($query) use ($villageIds) {
                        return $query->select("id", "member_id", "village_id", "name")
                            ->whereIn("village_id", $villageIds)
                            ->with("village:id,name");
                    },
                    "scheme"
                ])
                ->first();

            $applicationNumber = $form->beneficiary->member_id.'-'.$form->scheme_id;
            $tr .=  "<tr><td>$count</td><td>".$form->beneficiary->name."</td><td>$applicationNumber</td><td>".$form->scheme->name."</td><td>".$form->scheme->department."</td><td><span class='dot'></span></td><td></td><td></td><td></td></tr>";
            $count++;
        }

        $today = \Carbon\Carbon::now()->format('d/m/Y');
        $headers = array(
            "Content-type"=>"text/html",
            "Content-Disposition"=>"attachment;Filename=Govt_Submission_Report.doc",
            "header('Cache-Control: private, max-age=0, must-revalidate')"
        );
        $content = '<html>
            <head><meta charset="utf-8"></head>
            <body>
                <table style="width:100%" border="1">
                <thead>
                <tr align="center">
                <td colspan="8"><img src="http://app.deepakfoundation.org/logo/df_logo2.png" height="60" width="60">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="http://app.deepakfoundation.org/logo/sangath_logo.png" height="70" width="70"></td>
                </tr>
                <tr align="center">
                  <td colspan="8">Deepak Foundation - Sangath Project <p style="font-size: 14px;color: green">Supported By - Deepak Phenolics Limited</p></td>
                </tr>
                </thead>
                <tbody>
                <tr align="center">
                  <td colspan="8">*********************************************************************</td>
                </tr>
                <tr align="center">
                  <td colspan="8"><p style="font-size: 20px;">Application Submission(Govt.) Report</p></td>
                </tr>
                <tr align="center">
                  <td colspan="8">**********************************************************************</td>
                </tr>
                <tr align="center">
                  <td colspan="4">Date of Report : '.$today.'</td>
                  <td colspan="4">No .of Application : '.count($splitIds).'</td>
                </tr>
                <tr align="center">
                  <td colspan="8"></td>
                </tr>
                <tr align="center">
                  <td colspan="8"><p style="font-size: 25px;">Applications Details</p></td>
                </tr>
                <tr>
                  <td>Sr. No.</td>
                  <td>Name of Applicant</td>
                  <td>Reg.No</td>
                  <td>Scheme Name (Applied For)</td>
                  <td>Dept. Name</td>
                  <td>Status</td>
                  <td>Remarks</td>
                  <td>Signature & Date</td>
                </tr>
                <tr align="center">
                  <td colspan="8"></td>
                </tr>
                  '.$tr.'
                <tr>
                  <td colspan="8"></td>
                </tr>
                <tr align="center">
                  <td colspan="4"><strong>Signature of Team (Who Submitted)</strong></td>
                  <td colspan="4"><strong>Signature of Supervisor</strong></td>
                </tr>
                <tr>
                 <td colspan="8"></td>
                </tr>
                <tr align="center">
                 <td colspan="8"></td>
                </tr>
                <tr align="center">
                  <td colspan="8"></td>
                </tr>
                <tr align="center">
                  <td colspan="8">Implementing Agency - Deepak Foundation
                  </td>
                </tr>
                <tr align="center">
                  <td colspan="8"></td>
                </tr>
                </tbody>
                </table>
            </body>
            </html>';
        return Response::make($content, 200, $headers);
    }

    /**
     * Update the form status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $formIds = $request->form_ids;
        $updateType = $request->update_type;
        $date = $request->date;

        $splitIds = explode(",", $formIds);
        if ($updateType == "submitted") {
            foreach($splitIds as $formId) {
                $application = ConfirmApplication::where("id", $formId)
                    ->with("scheme")
                    ->first();
                $followUpDays = intval($application->scheme->followup_days);
                $followUpDate = \Carbon\Carbon::parse($date)->addDays($followUpDays)->format("Y-m-d");

                ConfirmApplication::where("id", $formId)
                    ->update([
                        "govt_submission_status" => 1,
                        "govt_submission_date" => $date,
                        "followup_date" => $followUpDate,
                        "benefit_status" => 0
                    ]);
            }
        }else {
            ConfirmApplication::whereIn("id", $splitIds)
                ->update([
                    "govt_submission_status" => -1,
                    "govt_submission_date" => $date
                ]);
        }

        return response()->success([]);
    }
}
