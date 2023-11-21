<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Village;
use App\Models\Site;
use App\Models\ConfirmApplication;
use App\Models\IncompleteForm;
use App\Models\Household;
use App\Models\kycDocument;

class ChartController extends Controller
{
    /**
     * Get available sites and load village wise application data page
     *
     * @return \Inertia\Response
     */
    public function getVillageWiseApplications()
    {
        $sites = Site::get()
            ->map(function ($site) {
                return $site->format();
            });

        return Inertia::render("Charts/VillageWiseApplications", ["sites" => $sites]);
    }

    /**
     * Get Village Wise Applications Data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getVillageWiseApplicationsData(Request $request)
    {
        $siteId = $request->site_id;
        // $siteId = "all";

        if ($siteId == "all") {
            $villages = Village::select("id", "site_id")
                ->get();
        }else {
            $villages = Village::select("id", "site_id")
                ->where("site_id", $siteId)
                ->get();
        }
        $villageIds = $villages->pluck("id")->toArray();

        $confirmApplications = ConfirmApplication::select("village_id")
            ->whereIn("village_id", $villageIds)
            ->with("village:id,name")
            ->get()
            ->groupBy("village.name")
            ->toArray();

        $confirmApplicationsCount = array_map(function(array $forms) {
            return count($forms);
        }, $confirmApplications);

        $incompleteForms = IncompleteForm::select("village_id")
            ->whereIn("village_id", $villageIds)
            ->with("village:id,name")
            ->get()
            ->groupBy("village.name")
            ->toArray();

        $incompleteFormsCount = array_map(function(array $forms) {
            return count($forms);
        }, $incompleteForms);

        $mergedData = [];
        $allVillageIds = array_unique(array_merge(array_keys($confirmApplicationsCount), array_keys($incompleteFormsCount)));
        foreach($allVillageIds as $villageId) {
            $applicationCount = 0;

            if (array_key_exists($villageId, $confirmApplicationsCount)) {
                $applicationCount += $confirmApplicationsCount[$villageId];
            }

            if (array_key_exists($villageId, $incompleteFormsCount)) {
                $applicationCount += $incompleteFormsCount[$villageId];
            }

            $mergedData[$villageId] = $applicationCount;
        }
        arsort($mergedData);

        if ($siteId == "all") {
            // Picking up top 10 villages
            $mergedData = array_slice($mergedData, 0, 10);
        }

        $sortedData = [
            "village_names" => array_keys($mergedData),
            "confirm_applications" => [],
            "incomplete_forms" => []
        ];

        $sortedVillageNames = array_keys($mergedData);
        foreach($sortedVillageNames as $villageName) {
            if (array_key_exists($villageName, $confirmApplicationsCount)) {
                $sortedData["confirm_applications"][$villageName] = $confirmApplicationsCount[$villageName];
            }

            if (array_key_exists($villageName, $incompleteFormsCount)) {
                $sortedData["incomplete_forms"][$villageName] = $incompleteFormsCount[$villageName];
            }
        }


        return response()->success(["village_names" => $sortedData["village_names"], "confirm_applications" => $sortedData["confirm_applications"], "incomplete_forms" => $sortedData["incomplete_forms"]]);
    }

    /**
     * Get available sites and load scheme wise application data page
     *
     * @return \Inertia\Response
     */
    public function getSchemeWiseApplications()
    {
        $sites = Site::get()
            ->map(function ($site) {
                return $site->format();
            });

        return Inertia::render("Charts/SchemeWiseApplications", ["sites" => $sites]);
    }

    /**
     * Get Scheme Wise Applications Data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSchemeWiseApplicationsData(Request $request)
    {
        $siteId = $request->site_id;

        if ($siteId == "all") {
            $villages = Village::select("id", "site_id")
                ->get();
        }else {
            $villages = Village::select("id", "site_id")
                ->where("site_id", $siteId)
                ->get();
        }
        $villageIds = $villages->pluck("id")->toArray();

        $confirmApplications = ConfirmApplication::select("scheme_id", "village_id")
            ->whereIn("village_id", $villageIds)
            ->with([
                "scheme" => function ($query) {
                    $query->select("id", "name", "type");
                    $query->where("type", "scheme");
                }
            ])
            ->get()
            ->groupBy("scheme.name")
            ->toArray();

        $incompleteForms = IncompleteForm::select("scheme_id", "village_id")
            ->whereIn("village_id", $villageIds)
            ->with([
                "scheme" => function ($query) {
                    $query->select("id", "name", "type");
                    $query->where("type", "scheme");
                }
            ])
            ->get()
            ->groupBy("scheme.name")
            ->toArray();

        $applications = $confirmApplications;
        foreach($incompleteForms as $schemeName => $forms) {
            if (strlen($schemeName) == 0) {
                continue;
            }
            if (!array_key_exists($schemeName, $applications)) {
                $applications[$schemeName] = [];
            }

            array_push($applications[$schemeName], $forms);
        }
        unset($applications[""]);
        // sort($schemeNames);

        $applicationsCount = array_map(function (array $forms) {
            return count($forms);
        }, $applications);
        arsort($applicationsCount);

        $applicationList = array_map(function($schemeName, $count) {
            return [
                "scheme" => $schemeName,
                "count" => $count
            ];
        }, array_keys($applicationsCount), array_values($applicationsCount));

        $categories = array_map(function($value) {
            return $value + 1;
        }, array_keys(array_values($applicationsCount)));

        return response()->success(["categories" => $categories, "applications" => $applicationsCount, "application_list" => $applicationList]);
    }

    /**
     * Get available sites and load prd wise application data page
     *
     * @return \Inertia\Response
     */
    public function getPRDWiseApplications()
    {
        $sites = Site::get()
            ->map(function ($site) {
                return $site->format();
            });

        return Inertia::render("Charts/PRDWiseApplications", ["sites" => $sites]);
    }

    /**
     * Get PRD Wise Applications Data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPRDWiseApplicationsData(Request $request)
    {
        $siteId = $request->site_id;

        if ($siteId == "all") {
            $villages = Village::select("id", "site_id")
                ->get();
        }else {
            $villages = Village::select("id", "site_id")
                ->where("site_id", $siteId)
                ->get();
        }
        $villageIds = $villages->pluck("id")->toArray();

        $confirmApplications = ConfirmApplication::select("scheme_id", "village_id")
            ->whereIn("village_id", $villageIds)
            ->with([
                "scheme" => function ($query) {
                    $query->select("id", "name", "type");
                    $query->where("type", "prerequisite");
                }
            ])
            ->get()
            ->groupBy("scheme.name")
            ->toArray();

        $incompleteForms = IncompleteForm::select("scheme_id", "village_id")
            ->whereIn("village_id", $villageIds)
            ->with([
                "scheme" => function ($query) {
                    $query->select("id", "name", "type");
                    $query->where("type", "prerequisite");
                }
            ])
            ->get()
            ->groupBy("scheme.name")
            ->toArray();

        $applications = $confirmApplications;
        foreach($incompleteForms as $schemeName => $forms) {
            if (!array_key_exists($schemeName, $applications)) {
                $applications[$schemeName] = [];
            }

            array_push($applications[$schemeName], $forms);
        }
        unset($applications[""]);
        // sort($schemeNames);

        $applicationsCount = array_map(function (array $forms) {
            return count($forms);
        }, $applications);
        arsort($applicationsCount);

        $applicationList = array_map(function($schemeName, $count) {
            return [
                "scheme" => $schemeName,
                "count" => $count
            ];
        }, array_keys($applicationsCount), array_values($applicationsCount));

        $categories = array_map(function($value) {
            return $value + 1;
        }, array_keys(array_values($applicationsCount)));

        return response()->success(["categories" => $categories, "applications" => $applicationsCount, "application_list" => $applicationList]);
    }

    /**
     * Get available sites and load card disbursement page
     *
     * @return \Inertia\Response
     */
    public function getCardDisbursement()
    {
        $sites = Site::get()
            ->map(function ($site) {
                return $site->format();
            });

        return Inertia::render("Charts/CardDisbursement", ["sites" => $sites]);
    }

    /**
     * Get Card Disbursement Data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCardDisbursementData(Request $request)
    {
        $siteId = $request->site_id;

        if ($siteId == "all") {
            $villages = Village::select("id", "site_id")
                ->get();
        }else {
            $villages = Village::select("id", "site_id")
                ->where("site_id", $siteId)
                ->get();
        }
        $villageIds = $villages->pluck("id")->toArray();

        $disbursed = Household::select("village_id", "card_disbursement_status")
            ->where("card_disbursement_status", 1)
            ->whereIn("village_id", $villageIds)
            ->with("village:id,name")
            ->get()
            ->groupBy("village.name")
            ->toArray();

        $disbursedCount = array_map(function(array $forms) {
            return count($forms);
        }, $disbursed);

        $notDisbursed = Household::select("village_id", "card_disbursement_status")
            ->where("card_disbursement_status", 0)
            ->whereIn("village_id", $villageIds)
            ->with("village:id,name")
            ->get()
            ->groupBy("village.name")
            ->toArray();

        $notDisbursedCount = array_map(function(array $forms) {
            return count($forms);
        }, $notDisbursed);

        $mergedData = [];
        $allVillageIds = array_unique(array_merge(array_keys($disbursedCount), array_keys($notDisbursedCount)));
        foreach($allVillageIds as $villageId) {
            $applicationCount = 0;

            if (array_key_exists($villageId, $disbursedCount)) {
                $applicationCount += $disbursedCount[$villageId];
            }

            if (array_key_exists($villageId, $notDisbursedCount)) {
                $applicationCount += $notDisbursedCount[$villageId];
            }

            $mergedData[$villageId] = $applicationCount;
        }
        arsort($mergedData);

        if ($siteId == "all") {
            // Picking up top 10 villages
            $mergedData = array_slice($mergedData, 0, 10);
        }

        $sortedData = [
            "village_names" => array_keys($mergedData),
            "disbursed" => [],
            "not_disbursed" => []
        ];

        $sortedVillageNames = array_keys($mergedData);
        foreach($sortedVillageNames as $villageName) {
            if (array_key_exists($villageName, $disbursedCount)) {
                $sortedData["disbursed"][$villageName] = $disbursedCount[$villageName];
            }

            if (array_key_exists($villageName, $notDisbursedCount)) {
                $sortedData["not_disbursed"][$villageName] = $notDisbursedCount[$villageName];
            }
        }

        return response()->success(["village_names" => $sortedData["village_names"], "disbursed" => $sortedData["disbursed"], "not_disbursed" => $sortedData["not_disbursed"]]);
    }

    /**
     * Get available sites and load card disbursement page
     *
     * @return \Inertia\Response
     */
    public function getPreRequisiteDigitized()
    {
        $sites = Site::get()
            ->map(function ($site) {
                return $site->format();
            });

        return Inertia::render("Charts/PreRequisiteDigitized", ["sites" => $sites]);
    }

    /**
     * Get Pre-Requisite Digitzed Data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPreRequisiteDigitizedData(Request $request)
    {
        $siteId = $request->site_id;

        if ($siteId == "all") {
            $villages = Village::select("id", "site_id", "name")
                ->get();
        }else {
            $villages = Village::select("id", "site_id", "name")
                ->where("site_id", $siteId)
                ->get();
        }

        $villageNames = $villages->pluck("name", "id")->toArray();
        $villageIds = $villages->pluck("id")->toArray();

        $householdCount = Household::select("village_id")->whereIn("village_id", $villageIds)->get()->countBy("village_id")->toArray();

        $displayVillageNames = [];
        $villageReport = [];
        foreach($householdCount as $villageId => $count) {
            if ($count > 0) {
                $villageReport[$villageNames[$villageId]] = 0;
                $displayVillageNames[$villageId] = $villageNames[$villageId];
            }
        }
        ksort($displayVillageNames);

        $report = [
            "household" => $villageReport,
            "member" => $villageReport
        ];

        $kycDocuments = kycDocument::select("village_id", "hh_id", "member_id")
            ->whereIn("village_id", $villageIds)
            ->with("village")
            ->get();

        $hhIdsCounted = [];
        $memberIdsCounted = [];
        foreach($kycDocuments as $document) {
            if (!in_array($document->hh_id, $hhIdsCounted)) {
                $report["household"][$document->village->name]++;
                array_push($hhIdsCounted, $document->hh_id);
            }

            if (!in_array($document->member_id, $memberIdsCounted)) {
                $report["member"][$document->village->name]++;
                array_push($memberIdsCounted, $document->member_id);
            }
        }

        arsort($report["household"]);
        arsort($report["member"]);

        if ($siteId == "all") {
            $report["household"] = array_slice($report["household"], 0, 10);
            $report["member"] = array_slice($report["member"], 0, 10);
        }

        return response()->success(["village_names" => $displayVillageNames, "report" => $report]);
    }
}
