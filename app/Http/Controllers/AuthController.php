<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function loginProcess(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $rememberMe = true;
        if (Auth::attempt(["email" => $email, "password" => $password], $rememberMe)) {
            $status = User::select("email", "status")
                ->where("email", $email)
                ->first()
                ->status;

            if ($status == "active") {
                return ["status" => 1];
            }

            Auth::logout();
            return ["status" => -1, "error_msg" => "Your account is blocked by administrator."];
        }

        return ["status" => -1, "error_msg" => "Incorrect login details. Please try again"];
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect(url('/'));
    }
}
