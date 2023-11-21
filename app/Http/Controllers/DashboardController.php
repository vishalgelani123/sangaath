<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

use App\Models\Uservillage;
use App\Models\User;
use App\Models\Site;
use App\Models\Household;
use App\Models\Beneficiary;
use App\Models\ConfirmApplication;
use App\Models\IncompleteForm;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if ($user->hasRole('admin')) {
            $stats = $this->getAdminStats();
            return Inertia::render("Dashboard/Admin", $stats);
        } else if ($user->hasRole('supervisor') || $user->hasRole("project_coordinator")) {
            $stats = $this->getSupervisorStats($user->id);
            return Inertia::render("Dashboard/Supervisor", $stats);
        } else if ($user->hasRole('facilitator')) {
            $stats = $this->getFacilitatorStats($user->id);
            return Inertia::render("Dashboard/Facilitator", $stats);
        } else if ($user->hasRole('sub_admin') || $user->hasRole('report_admin')) {
            $stats = $this->getSubAdminStats($user->id);
            return Inertia::render("Dashboard/Admin", $stats);
        }
    }

    /**
     * Get the facilitator dashboard stats
     *
     * @param int $userId
     * @return array
     */
    private function getFacilitatorStats($userId)
    {
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->get();
        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $allotedVillagesCount = $allotedVillages->count();

        $sites = Site::with("villages:id,site_id")
            ->get();
        $siteCount = IndianNumberComma($sites->count());
        $householdCount = IndianNumberComma(Household::whereIn("village_id", $villageIds)->count());
        $populationCount = IndianNumberComma(Beneficiary::whereIn("village_id", $villageIds)->count());

        $applicationCount = IndianNumberComma(ConfirmApplication::whereIn("village_id", $villageIds)->count() + IncompleteForm::whereIn("village_id", $villageIds)->count());


        $households = Household::select("id", "village_id", "hh_id", "name", "card_disbursement_status", "created_at")
            ->whereIn("village_id", $villageIds)
            ->orderBy("created_at", "DESC")
            ->limit(5)
            ->get()
            ->map(function ($household) {
                return $household->format();
            });

//        $applications = [
//            "Incomplete" => IncompleteForm::whereIn("village_id", $villageIds)->count(),
//            "Documentation" => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->count(),
//            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 0)->count(),
//            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->count(),
//            "Benefitted" => ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", "!=", -1)->count(),
//        ];

        $applications = [
            "Incomplete"       => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->count(),
            "Documentation"    => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->count(),
            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $villageIds)->where("liasoning_status", 1)->count(),
            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"       => ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->count(),
        ];
        $applicationStatus = [
            "Incomplete"    => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->count(),
            "Documentation" => ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->count(),
            "Verified"      => ConfirmApplication::whereIn("village_id", $villageIds)->where("liasoning_status", 1)->count(),
            "Govt"          => ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"    => ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->count(),
        ];
        // dd($applications);

        $users = User::select("id", "name", "email", "status", "site_id", "created_at")
            ->where("id", "!=", request()->user()->id)
            ->with("site", "villages")
            ->orderBy("name", "ASC")
            ->get()
            ->map(function ($user) {
                return $user->format();
            });

        return [
            "overview"          => [
                "alloted_villages" => $allotedVillagesCount,
                "households"       => $householdCount,
                "population"       => $populationCount,
                "applications"     => $applicationCount
            ],
            "households"        => $households,
            "applications"      => $applications,
            "applicationStatus" => $applicationStatus,
            "users"             => $users
        ];
    }

    /**
     * Get the supervisor dashboard stats
     *
     * @param int $userId
     * @return array
     */
    private function getSupervisorStats($userId)
    {

        $allotedVillages = Uservillage::where("user_id", $userId)
            ->with("village_name:id,name")
            ->get();

        $allotedVillageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $allotedVillagesCount = $allotedVillages->count();

        $householdCount = IndianNumberComma(Household::whereIn("village_id", $allotedVillageIds)->count());
        $populationCount = IndianNumberComma(Beneficiary::whereIn("village_id", $allotedVillageIds)->count());

        $applicationCount = IndianNumberComma(ConfirmApplication::whereIn("village_id", $allotedVillageIds)->count() + IncompleteForm::whereIn("village_id", $allotedVillageIds)->count());


        $followUpNumbers = [
            "village_names"      => [],
            "today_followups"    => [],
            "previous_followups" => [],
            "merged_data"        => []
        ];
        foreach ($allotedVillages as $village) {
            $todayFollowUpsCount = ConfirmApplication::where("village_id", $village->village_id)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", date("Y-m-d"))
                ->count();

            $previousFollowUpsCount = ConfirmApplication::where("village_id", $village->village_id)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", "<", date("Y-m-d"))
                ->count();

            array_push($followUpNumbers["village_names"], $village->village_name->name);

            // array_push($followUpNumbers["today_followups"], $todayFollowUpsCount);
            // array_push($followUpNumbers["previous_followups"], $previousFollowUpsCount);

            $followUpNumbers["today_followups"][$village->village_name->name] = $todayFollowUpsCount;
            $followUpNumbers["previous_followups"][$village->village_name->name] = $previousFollowUpsCount;
            $followUpNumbers["merged_data"][$village->village_name->name] = ($todayFollowUpsCount + $previousFollowUpsCount);
        }

        arsort($followUpNumbers["merged_data"]);
        $sortedData = [
            "village_names"      => array_keys($followUpNumbers["merged_data"]),
            "today_followups"    => [],
            "previous_followups" => []
        ];

        $sortedVillageNames = array_keys($followUpNumbers["merged_data"]);
        foreach ($sortedVillageNames as $villageName) {
            array_push($sortedData["today_followups"], $followUpNumbers["today_followups"][$villageName]);
            array_push($sortedData["previous_followups"], $followUpNumbers["previous_followups"][$villageName]);
        }

//        $applications = [
//            "Incomplete" => IncompleteForm::whereIn("village_id", $allotedVillageIds)->count(),
//            "Documentation" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
//            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->where("liasoning_status", 0)->count(),
//            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->count(),
//            "Benefitted" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", "!=", -1)->count(),
//        ];

        $applications = [
            "Incomplete"       => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
            "Documentation"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->count(),
            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("liasoning_status", 1)->count(),
            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"       => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", 1)->count(),
        ];

        $applicationStatus = [
            "Incomplete"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
            "Documentation" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->count(),
            "Verified"      => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("liasoning_status", 1)->count(),
            "Govt"          => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", 1)->count(),
        ];
//        dd(json_encode($allotedVillageIds), $applications);


        $users = User::select("id", "name", "email", "status", "site_id", "created_at")
            ->where("id", "!=", request()->user()->id)
            ->with("site", "villages")
            ->orderBy("name", "ASC")
            ->get()
            ->map(function ($user) {
                return $user->format();
            });

        return [
            "overview"          => [
                "alloted_villages" => $allotedVillagesCount,
                "households"       => $householdCount,
                "population"       => $populationCount,
                "applications"     => $applicationCount
            ],
            "followup"          => $sortedData,
            "applications"      => $applications,
            "users"             => $users,
            "applicationStatus" => $applicationStatus
        ];
    }

    /**
     * Get the admin dashboard stats
     *
     * @return array
     */
    private function getAdminStats()
    {
        $sites = Site::with("villages:id,site_id")
            ->get();
        $siteCount = IndianNumberComma($sites->count());
        $householdCount = IndianNumberComma(Household::count());
        $populationCount = IndianNumberComma(Beneficiary::count());

        $applicationCount = ConfirmApplication::count() + IncompleteForm::count();

        $followUpNumbers = [
            "site_names"         => [],
            "today_followups"    => [],
            "previous_followups" => [],
            "merged_data"        => []
        ];
        foreach ($sites as $site) {
            $villageIds = $site->villages->pluck("id")->toArray();
            $todayFollowUpsCount = ConfirmApplication::whereIn("village_id", $villageIds)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", date("Y-m-d"))
                ->count();

            $previousFollowUpsCount = ConfirmApplication::whereIn("village_id", $villageIds)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", "<", date("Y-m-d"))
                ->count();

            array_push($followUpNumbers["site_names"], $site->name);
            $followUpNumbers["today_followups"][$site->name] = $todayFollowUpsCount;
            $followUpNumbers["previous_followups"][$site->name] = $previousFollowUpsCount;
            $followUpNumbers["merged_data"][$site->name] = ($todayFollowUpsCount + $previousFollowUpsCount);
        }

        arsort($followUpNumbers["merged_data"]);
        $sortedData = [
            "site_names"         => array_keys($followUpNumbers["merged_data"]),
            "today_followups"    => [],
            "previous_followups" => []
        ];

        $sortedSiteNames = array_keys($followUpNumbers["merged_data"]);
        foreach ($sortedSiteNames as $siteName) {
            array_push($sortedData["today_followups"], $followUpNumbers["today_followups"][$siteName]);
            array_push($sortedData["previous_followups"], $followUpNumbers["previous_followups"][$siteName]);
        }

//        $applications = [
//            "Incomplete" => IncompleteForm::count(),
//            "Documentation" => ConfirmApplication::where("documentation_status", 0)->count(),
//            "Verified by F.S." => ConfirmApplication::where("documentation_status", 1)->where("liasoning_status", 0)->count(),
//            "Govt. Submission" => ConfirmApplication::where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->count(),
//            "Benefitted" => ConfirmApplication::where("benefit_status", 1)->count(),
//        ];

        $applications = [
            "Incomplete"       => ConfirmApplication::where("documentation_status", 0)->count(),
            "Documentation"    => ConfirmApplication::where("documentation_status", 1)->count(),
            "Verified by F.S." => ConfirmApplication::where("liasoning_status", 1)->count(),
            "Govt. Submission" => ConfirmApplication::where("govt_submission_status", 1)->count(),
            "Benefitted"       => ConfirmApplication::where("benefit_status", 1)->count(),
        ];
//        dd($applications);
        $applicationStatus = [
            "Incomplete"    => ConfirmApplication::where("documentation_status", 0)->count(),
            "Documentation" => ConfirmApplication::where("documentation_status", 1)->count(),
            "Verified"      => ConfirmApplication::where("liasoning_status", 1)->count(),
            "Govt"          => ConfirmApplication::where("govt_submission_status", 1)->count(),
            "Benefitted"    => ConfirmApplication::where("benefit_status", 1)->count(),
        ];


        $users = User::select("id", "name", "email", "status", "site_id", "created_at")
            ->where("id", "!=", request()->user()->id)
            ->with("site", "villages")
            ->orderBy("name", "ASC")
            ->get()
            ->map(function ($user) {
                return $user->format();
            });

        return [
            "overview"          => [
                "sites"        => $siteCount,
                "households"   => $householdCount,
                "population"   => $populationCount,
                "applications" => $applicationCount
            ],
            "followup"          => $sortedData,
            "applications"      => $applications,
            "applicationStatus" => $applicationStatus,
            "users"             => $users
        ];
    }

    private function getSubAdminStats($userId)
    {
        $allotedVillages = Uservillage::where("user_id", $userId)
            ->with("village_name:id,name")
            ->get();

        $allotedVillageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $user = User::find($userId);
        $siteIds = explode(',', $user->site_id);

        $sites = Site::with("villages:id,site_id")
            ->whereIn('id', $siteIds)
            ->get();
        $siteCount = IndianNumberComma($sites->count());


        $householdCount = IndianNumberComma(Household::whereIn("village_id", $allotedVillageIds)->count());
        $populationCount = IndianNumberComma(Beneficiary::whereIn("village_id", $allotedVillageIds)->count());

        $applicationCount = IndianNumberComma(ConfirmApplication::whereIn("village_id", $allotedVillageIds)->count() + IncompleteForm::whereIn("village_id", $allotedVillageIds)->count());


        $followUpNumbers = [
            "village_names"      => [],
            "today_followups"    => [],
            "previous_followups" => [],
            "merged_data"        => []
        ];

        foreach ($allotedVillages as $village) {

            $todayFollowUpsCount = ConfirmApplication::where("village_id", $village->village_id)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", date("Y-m-d"))
                ->count();

            $previousFollowUpsCount = ConfirmApplication::where("village_id", $village->village_id)
                ->where("documentation_status", 1)
                ->where("liasoning_status", 1)
                ->where("govt_submission_status", 1)
                ->where("benefit_status", 0)
                ->where("followup_date", "<", date("Y-m-d"))
                ->count();
            array_push($followUpNumbers["village_names"], $village->village_name->name);
            // array_push($followUpNumbers["today_followups"], $todayFollowUpsCount);
            // array_push($followUpNumbers["previous_followups"], $previousFollowUpsCount);

            $followUpNumbers["today_followups"][$village->village_name->name] = $todayFollowUpsCount;
            $followUpNumbers["previous_followups"][$village->village_name->name] = $previousFollowUpsCount;
            $followUpNumbers["merged_data"][$village->village_name->name] = ($todayFollowUpsCount + $previousFollowUpsCount);
        }

        arsort($followUpNumbers["merged_data"]);
        $sortedData = [
            "village_names"      => array_keys($followUpNumbers["merged_data"]),
            "today_followups"    => [],
            "previous_followups" => []
        ];

        $sortedVillageNames = array_keys($followUpNumbers["merged_data"]);
        foreach ($sortedVillageNames as $villageName) {
            array_push($sortedData["today_followups"], $followUpNumbers["today_followups"][$villageName]);
            array_push($sortedData["previous_followups"], $followUpNumbers["previous_followups"][$villageName]);
        }

//        $applications = [
//            "Incomplete" => IncompleteForm::whereIn("village_id", $allotedVillageIds)->count(),
//            "Documentation" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
//            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->where("liasoning_status", 0)->count(),
//            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->count(),
//            "Benefitted" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", "!=", -1)->count(),
//        ];

        $applications = [
            "Incomplete"       => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
            "Documentation"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->count(),
            "Verified by F.S." => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("liasoning_status", 1)->count(),
            "Govt. Submission" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"       => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", 1)->count(),
        ];

        $applicationStatus = [
            "Incomplete"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 0)->count(),
            "Documentation" => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("documentation_status", 1)->count(),
            "Verified"      => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("liasoning_status", 1)->count(),
            "Govt"          => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("govt_submission_status", 1)->count(),
            "Benefitted"    => ConfirmApplication::whereIn("village_id", $allotedVillageIds)->where("benefit_status", 1)->count(),
        ];


        $users = User::select("id", "name", "email", "status", "site_id", "created_at")
            ->where("id", "!=", request()->user()->id)
            ->with("site", "villages")
            ->orderBy("name", "ASC")
            ->get()
            ->map(function ($user) {
                return $user->format();
            });

        return [
            "overview"          => [
                "sites"        => $siteCount,
                "households"   => $householdCount,
                "population"   => $populationCount,
                "applications" => $applicationCount
            ],
            "followup"          => $sortedData,
            "applications"      => $applications,
            "applicationStatus" => $applicationStatus,
            "users"             => $users
        ];
    }

    /**
     * Get the daily report of a particular user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDailyReport(Request $request)
    {
        $userId = $request->user_id;

        $userDetails = User::select("id", "name")->where("id", $userId)->first();

        $userVillages = Uservillage::where("user_id", $userId)
            ->get();
        $villageIds = $userVillages->pluck("village_id")->toArray();

        $report = [
            "today"      => [],
            "cumulative" => []
        ];

        $report["user"] = $userDetails;
        $report["names"]["card_disbursed"] = "Card Disbursed";
        $report["names"]["incomplete_applications"] = "Incomplete Applications";
        $report["names"]["online_applications"] = "Online Applications";
        $report["names"]["documentation_stage"] = "Documentation stage";
        $report["names"]["liasoning_stage"] = "FS Verification Stage";
        $report["names"]["govt_submission_stage"] = "Govt. Submission";
        $report["names"]["benefit_received"] = "Benefit Received";
        $report["names"]["followup_pending"] = "Follow Up";

        /*   $report["cumulative"]["card_disbursed"] = Household::whereIn("village_id", $villageIds)->where("card_disbursement_status", 1)->count();
           $report["cumulative"]["incomplete_applications"] = IncompleteForm::whereIn("village_id", $villageIds)->count();
           $report["cumulative"]["online_applications"] = ConfirmApplication::whereIn("village_id", $villageIds)->count();
           $report["cumulative"]["documentation_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->count();
           $report["cumulative"]["liasoning_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 0)->count();
           $report["cumulative"]["govt_submission_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->count();
           $report["cumulative"]["benefit_received"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->count();
           $report["cumulative"]["followup_pending"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->where("benefit_status", 0)->where("followup_date", "<", date("Y-m-d"))->count();
       */

        /*        $report["today"]["card_disbursed"] = Household::whereIn("village_id", $villageIds)->where("card_disbursement_status", 1)->where("updated_at", Carbon::today())->count();
                $report["today"]["incomplete_applications"] = IncompleteForm::whereIn("village_id", $villageIds)->where("created_at", Carbon::today())->count();
                $report["today"]["online_applications"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("created_at", Carbon::today())->count();
                $report["today"]["documentation_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->where("created_at", Carbon::today())->count();
                $report["today"]["liasoning_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 0)->where("created_at", Carbon::today())->count();
                $report["today"]["govt_submission_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where("liasoning_status", 1)->where("govt_submission_status", 0)->where("created_at", Carbon::today())->count();
                $report["today"]["benefit_received"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->where("created_at", Carbon::today())->count();
                $report["today"]["followup_pending"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->where("benefit_status", 0)->where("followup_date", date("Y-m-d"))->where("created_at", Carbon::today())->count();
        */


        $applicationCount = IndianNumberComma(ConfirmApplication::whereIn("village_id", $villageIds)->count() + IncompleteForm::whereIn("village_id", $villageIds)->count());

        $report["cumulative"]["card_disbursed"] = Household::whereIn("village_id", $villageIds)->where("card_disbursement_status", 1)->count();
        $report["cumulative"]["incomplete_applications"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->count();
        $report["cumulative"]["online_applications"] = $applicationCount;
        $report["cumulative"]["documentation_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->count();
        $report["cumulative"]["liasoning_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("liasoning_status", 1)->count();
        $report["cumulative"]["govt_submission_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->count();
        $report["cumulative"]["benefit_received"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->count();
        $report["cumulative"]["followup_pending"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->where("benefit_status", 0)->where("followup_date", "<", date("Y-m-d"))->count();

        $todayDate = Carbon::today();
        $formattedDate = $todayDate->format('Y-m-d');
        $applicationCountToday = IndianNumberComma(ConfirmApplication::whereIn("village_id", $villageIds)->where('created_at', 'LIKE', "$formattedDate%")->count() + IncompleteForm::whereIn("village_id", $villageIds)->where('created_at', 'LIKE', "$formattedDate%")->count());
        $report["today"]["card_disbursed"] = Household::whereIn("village_id", $villageIds)->where("card_disbursement_status", 1)->where('updated_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["incomplete_applications"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 0)->where('created_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["online_applications"] = $applicationCountToday;
        $report["today"]["documentation_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("documentation_status", 1)->where('created_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["liasoning_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("liasoning_status", 1)->where('created_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["govt_submission_stage"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->where('created_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["benefit_received"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("benefit_status", 1)->where('created_at', 'LIKE', "$formattedDate%")->count();
        $report["today"]["followup_pending"] = ConfirmApplication::whereIn("village_id", $villageIds)->where("govt_submission_status", 1)->where("benefit_status", 0)->where("followup_date", 'LIKE', "$formattedDate%")->count();


        return response()->success(["report" => $report]);
    }
}
