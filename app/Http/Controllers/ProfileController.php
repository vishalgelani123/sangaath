<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Loads the user profile page
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::where("id", $userId)
                    ->get();
    }
}
