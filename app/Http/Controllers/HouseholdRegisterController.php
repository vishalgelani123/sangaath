<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Uservillage;
use App\Models\Household;
use App\Models\Beneficiary;

class HouseholdRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Inertia;
     */
    public function index(Request $request)
    {
        $allotedVillages = Uservillage::where("user_id", $request->user()->id)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();
        $last10Households = Household::whereIn("village_id", $villageIds)
            ->orderBy("created_at", "DESC")
            ->limit(10)
            ->with("village:id,name")
            ->get();

        $state = "";
        if (count($allotedVillages) > 0) {
            $state = ucwords($allotedVillages[0]->village_name->site->state);
        }

        return Inertia::render("HouseholdRegister", ["allocated_villages" => $allotedVillages, "households" => $last10Households, "state" => $state]);
    }

    /**
     * Store the household in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $villageId = $request->village_id;
        $name = $request->name;
        $mobileAadhaar = $request->mobile_aadhaar;
        $socialStatus = $request->social_status;
        $age = $request->age;
        $state = strtolower($request->state);

        $saveType = $request->save_type;
        $householdId = $request->household_id;

        if ($saveType == "new") {
            $hhId = $villageId.time();

            $household = new Household;
            $household->village_id = $villageId;
            $household->hh_id = $hhId;
            $household->name = $name;
            $household->qr_code = $mobileAadhaar.$villageId;
            $household->social_status = $socialStatus;
            $household->social_eco_status = $socialStatus;
            $household->age = $age;
            $household->state = $state;

            if (strlen($mobileAadhaar) == 10) {
                $household->mobile = $mobileAadhaar;
            }
            $household->save();

            $beneficiary = new Beneficiary;
            $beneficiary->village_id = $villageId;
            $beneficiary->hh_id = $hhId;
            $beneficiary->member_id = $mobileAadhaar."1";
            $beneficiary->member_count = 1;
            $beneficiary->name = $name;
            $beneficiary->age = $age;

            if (strlen($mobileAadhaar) == 12) {
                $beneficiary->aadhaar_number = $mobileAadhaar;
            }

            $beneficiary->save();
        }

        return response()->success([]);
    }

    /**
     * Check the provided HH ID
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkHHID(Request $request)
    {
        $hhId = $request->hh_id;

        $allotedVillages = Uservillage::where("user_id", $request->user()->id)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $household = Household::whereIn("village_id", $villageIds)
            ->where("hh_id", $hhId)
            ->first();

        if ($household != null) {
            return response()->success(["hh_id" => $hhId, "village_id" => $household->village_id, "id" => $household->id]);
        }

        return response()->failed("No household is associated with this ID");
    }

    /**
     * Check Card Distribution Status of the HH Id
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkCardDistribution(Request $request)
    {
        $hhId = $request->hh_id;

        $allotedVillages = Uservillage::where("user_id", $request->user()->id)
            ->has("village_name.site")
            ->with("village_name.site")
            ->get();

        $villageIds = $allotedVillages->pluck("village_id")
            ->toArray();

        $household = Household::whereIn("village_id", $villageIds)
            ->where("hh_id", $hhId)
            ->first();

        if ($household != null) {
            return response()->success(["id" => $household->id, "name" => $household->name, "card_distribution" => $household->card_disbursement_status]);
        }

        return response()->failed("No household is associated with this ID");
    }

    /**
     * Update Card Distribution Status for this HH Id
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateCardDistributionStatus(Request $request)
    {
        $hhRowId = $request->hh_row_id;

        $distributed = $request->distributed;
        Household::where("id", $hhRowId)
            ->update([
                "card_disbursement_status" => $distributed
            ]);

        return response()->success([]);
    }
}
