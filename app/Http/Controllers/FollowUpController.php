<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Uservillage;
use App\Models\Village;
use App\Models\ConfirmApplication;

class FollowUpController extends Controller
{
    public function gettestbyadarsh()
    {
        echo "Test by adarsh";
    }


    /**
     * Get today's followups
     *
     * @return \Inertia\Response
     */
    public function getTodayFollowUps()
    {
        $user = request()->user();

        $query = ConfirmApplication::where("documentation_status", 1)
            ->where("liasoning_status", 1)
            ->where("govt_submission_status", 1)
            ->where("benefit_status", 0)
            ->where("followup_date", date("Y-m-d"));

        if (!$user->hasRole('admin')) {
            $userId = $user->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->with("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $query->whereIn("village_id", $villageIds);
        }else {
            $villageIds = Village::select("id")->get()->pluck("id")->toArray();
        }

        $query->with([
            "beneficiary" => function($query) use ($villageIds) {
                return $query->select("id", "member_id", "village_id", "name")
                    ->whereIntegerInRaw("village_id", $villageIds)
                    ->with("village:id,name");
            },
            "scheme"
        ]);

        $forms = $query->get()
            ->map(function ($application) {
                return $application->format();
            });

        return Inertia::render("Followup/Today", ["all_forms" => $forms]);
    }

    /**
     * Get previous pending followups
     *
     * @return \Inertia\Response
     */
    public function getPastFollowups()
    {
        $user = request()->user();

        $query = ConfirmApplication::where("documentation_status", 1)
            ->where("liasoning_status", 1)
            ->where("govt_submission_status", 1)
            ->where("benefit_status", 0)
            ->where("followup_date", "<", date("Y-m-d"));

        if (!$user->hasRole('admin')) {
            $userId = $user->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $query->whereIntegerInRaw("village_id", $villageIds);
        }else {
            $villageIds = Village::select("id")->get()->pluck("id")->toArray();
        }
        // echo implode(",", $villageIds);
        // dd($villageIds);

        $query->with("beneficiary.village:id,name", "scheme:id,name");
        $query->with(["beneficiary" => function ($query) use ($villageIds) {
            $query->whereIntegerInRaw("village_id", $villageIds);
            $query->select("id", "member_id", "village_id", "name");
        }]);

        // print_r($query->toSql());
        // dd($query->getBindings());

        $forms = $query->get()
            ->map(function ($application) {
                return $application->format();
            });

        return Inertia::render("Followup/Previous", ["all_forms" => $forms]);
    }

    /**
     * Get the received benefit list
     */
    public function getBenefitReceived(Request $request)
    {
        $user = request()->user();

        $query = ConfirmApplication::where("documentation_status", 1)
            ->where("liasoning_status", 1)
            ->where("govt_submission_status", 1)
            ->where("benefit_status", 1);

        if (!$user->hasRole('admin')) {
            $userId = $user->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $query->whereIntegerInRaw("village_id", $villageIds);
        }else {
            $villageIds = Village::select("id")->pluck("id")->toArray();
        }

        $query->with("beneficiary.village:id,name", "scheme:id,name");
        $query->with(["beneficiary" => function ($query) use ($villageIds) {
            $query->whereIntegerInRaw("village_id", $villageIds);
            $query->select("id", "member_id", "village_id", "name");
        }]);

        $search = $request->get("search");
        if ($search) {
            $query->where(function ($query) use ($search) {
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
                    ->orWhereRaw("DATE_FORMAT(govt_submission_date, '%d %b %Y') LIKE ?", ["%$search%"]);
            });
        }

        $take = 50;
        $query->take($take);

        if ($request->get('is_ajax')) {
            $skip = $request->get("skip");
            $query->skip($skip);
        }

        $forms = $query->get()
            ->map(function ($application) {
                return $application->format();
            });

        if ($request->get('is_ajax')) {
            return ["status" => 1, "rows" => $forms];
        }

        return Inertia::render("Followup/BenefitReceived", ["initial_forms" => $forms]);
    }

    /**
     * Get the received benefit list
     */
    public function getRejected(Request $request)
    {
        $user = request()->user();

        $query = ConfirmApplication::where("documentation_status", 1)
            ->where("liasoning_status", 1)
            ->where("govt_submission_status", 1)
            ->where("benefit_status", -1);

        if (!$user->hasRole('admin')) {
            $userId = $user->id;
            $allotedVillages = Uservillage::where("user_id", $userId)
                ->has("village_name.site")
                ->get();

            $villageIds = $allotedVillages->pluck("village_id")
                ->toArray();

            $query->whereIntegerInRaw("village_id", $villageIds);
        }else {
            $villageIds = Village::select("id")->pluck("id")->toArray();
        }

        $query->with("beneficiary.village:id,name", "scheme:id,name");
        $query->with(["beneficiary" => function ($query) use ($villageIds) {
            $query->whereIntegerInRaw("village_id", $villageIds);
            $query->select("id", "member_id", "village_id", "name");
        }]);

        $search = $request->get("search");
        if ($search) {
            $query->where(function ($query) use ($search) {
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
                    ->orWhereRaw("DATE_FORMAT(govt_submission_date, '%d %b %Y') LIKE ?", ["%$search%"]);
            });
        }

        $take = 50;
        $query->take($take);

        if ($request->get('is_ajax')) {
            $skip = $request->get("skip");
            $query->skip($skip);
        }

        $forms = $query->get()
            ->map(function ($application) {
                return $application->format();
            });

        if ($request->get('is_ajax')) {
            return ["status" => 1, "rows" => $forms];
        }

        return Inertia::render("Followup/Rejected", ["initial_forms" => $forms]);
    }

    /**
     * Update the followup status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $formId = $request->form_id;
        $hasBenefitted = $request->has_benefitted;
        $date = $request->date;
        $rejectReason = $request->reject_reason;
        $discrepancy = $request->discrepancy;

        ConfirmApplication::where("id", $formId)
            ->update([
                "benefit_status" => $hasBenefitted,
                "benefit_date" => $date,
                "reject_reason" => $rejectReason,
                "if_discrepancy" => $discrepancy
            ]);

        return response()->success([]);
    }
}
