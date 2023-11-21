<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\ConfirmApplication;
use App\Models\Uservillage;

class UpdateStatusController extends Controller
{
    /**
     * Get the applications whose documentation is done
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
                                ->where("liasoning_status", 0)
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
                ->orWhereRaw("DATE_FORMAT(documentation_date, '%d %b %Y') LIKE ?", ["%$search%"]);
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

        return Inertia::render("UpdateStatus", ["initial_forms" => $forms]);
    }

    /**
     * Updates the form status and sets a manual date
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $formId = $request->form_id;
        $date = $request->date;

        ConfirmApplication::where("id", $formId)
                            ->update([
                                "liasoning_status" => 1,
                                "liasoning_date" => $date
                            ]);

        return response()->success([]);
    }
}
