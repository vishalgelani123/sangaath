<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\PreRequisite;

class PreRequisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Inertia;
     */
    public function index()
    {
        $preRequisites = PreRequisite::get();

        return Inertia::render("PreRequisite", ["all_prerequisites" => $preRequisites]);
    }

    /**
     * Save the pre-requisite in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $name = $request->name;
        $saveType = $request->save_type;
        $preRequisiteId = $request->prerequisite_id;
        $isActive = $request->is_active;

        if ($saveType == "new") {
            $preRequisite = new PreRequisite;
            $preRequisite->name = $name;
            $preRequisite->is_active = $isActive;
            $preRequisite->save();
        }else {
            PreRequisite::where("id", $preRequisiteId)
                    ->update([
                        "name" => $name,
                        "is_active" => $isActive
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
        $preRequisiteId = $request->prerequisite_id;
        PreRequisite::where("id", $preRequisiteId)
                ->delete();

        return response()->success([]);
    }
}
