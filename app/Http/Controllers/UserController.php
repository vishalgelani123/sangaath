<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Site;
use App\Models\Village;
use App\Models\Uservillage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Inertia;
     */
    public function index()
    {
        $users = User::select("id", "name", "email", "status", "site_id", "created_at")
            ->where("id", "!=", request()->user()->id)
            ->with("site", "villages")
            ->get()
            ->map(function ($user) {
                return $user->format();
            });
        // dd($users);

        $sites = Site::get()->map(function ($site) {
            return $site->format();
        });
        $villages = Village::get()
            ->groupBy("site_id");

        return Inertia::render("User", ["all_users" => $users, "sites" => $sites, "villages" => $villages]);
    }

    /**
     * Saves the user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {

        $name = $request->name;
        $role = $request->role;
        $email = $request->email;
        $password = $request->password;
        $status = $request->status;

        $site = $request->site;
        $villages = $request->allocated_villages;

        $saveType = $request->save_type;
        $userId = $request->user_id;

        $doesEmailExists = User::where("id", "!=", $userId)
            ->where("email", $email)
            ->exists();
        if ($doesEmailExists) {
            return response()->failed(["This email is already registered"]);
        }
        if ($saveType == "new") {

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->site_id = $site;
            $user->status = $status;
            $user->save();

            $user->assignRole($role);

            $userId = $user->id;
        } else {
            User::where("id", $userId)
                ->update([
                    'name' => $name,
                    'email' => $email,
                    'site_id' => $site,
                    'status' => $status
                ]);

            if (strlen($password) >= 8) {
                User::where("id", $userId)
                    ->update([
                        'password' => bcrypt($password)
                    ]);
            }

            $clearUserVillages = Uservillage::where("user_id", $userId)->delete();
        }

        if ($villages != null) {
            $villages = json_decode($villages, true);
        }
        foreach ($villages as $village) {
            $userVillage = new Uservillage;
            $userVillage->user_id = $userId;
            $userVillage->village_id = $village;
            $userVillage->save();
        }

        return response()->success([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Illuminate\Http\Request $request)
    {
        $userId = $request->user_id;
        User::where("id", $userId)
            ->delete();
        Uservillage::where("user_id", $userId)->delete();

        return response()->success([]);
    }
}
