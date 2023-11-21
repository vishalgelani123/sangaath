<?php

namespace App\Http\Controllers;

use App\Models\Uservillage;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Village;
use App\Models\Site;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Inertia;
     */
    public function index()
    {
        $villages = Village::with("site")
                        ->orderBy("created_at", "DESC")
                        ->get()
                        ->map(function ($village) {
                            return $village->format();
                        });

        $sites = Site::get()
                        ->map(function ($site) {
                            return $site->format();
                        });

        return Inertia::render("Village", ["all_villages" => $villages, "sites" => $sites]);
    }

    /**
     * Saves the village in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $name = $request->name;
        $siteId = $request->site_id;

        $saveType = $request->save_type;
        $villageId = $request->village_id;

        if ($saveType == "new") {
            $village = new Village;
            $village->site_id = $siteId;
            $village->name = $name;
            $village->save();
        }else {
            Village::where("id", $villageId)
                        ->update([
                            "name" => $name,
                            "site_id" => $siteId
                        ]);
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
        $villageId = $request->village_id;
        Village::where("id", $villageId)
                ->delete();
        Uservillage::where("village_id", $villageId)->delete();

        return response()->success([]);
    }
}
