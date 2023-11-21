<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Site;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $sites = Site::withCount("villages")
                        ->orderBy("created_at", "DESC")
                        ->get()
                        ->map(function ($site) {
                            return $site->format();
                        });

        return Inertia::render("Site", ["all_sites" => $sites]);
    }

    /**
     * Saves the site in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $name = $request->name;
        $state = $request->state;
        $saveType = $request->save_type;
        $siteId = $request->site_id;

        if ($saveType == "new") {
            $site = new Site;
            $site->name = $name;
            $site->state = $state;
            $site->save();
        }else {
            Site::where("id", $siteId)
                    ->update([
                        "name" => $name,
                        "state" => $state
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
        $siteId = $request->site_id;
        Site::where("id", $siteId)
                ->delete();

        return response()->success([]);
    }
}
