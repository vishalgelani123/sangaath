<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

/**
 * @group Auth
 *
 * APIs for auth management
 */
class AuthController extends Controller
{
    /**
     * Account login
     * 
     * Login into the facilitator account to access data
     * 
     * @header application-id ****
     * @header api-key ****
     * 
     * @bodyParam email string required Email address of the user. Example: washala@df.org
     * @bodyParam password string required Password of the user. Example: ******
     * 
     * @response scenario=success {
     *  "access_token": "auth_access_token",
     *  "application_id": "sangaath_application_id",
     *  "employee_id": "user_id",
     *  "api_key": "sangaath_api_key",
     *  "token_expires": "token_expiry_date"
     * }
     * @response status=401 scenario="incorrect login credentials" {"message": "User is unauthorized"}
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(["email" => $email, "password" => $password])) {
            $user = request()->user();

            if ($user->hasRole('facilitator')) {
                $data['access_token'] =  $user->createToken('Sangaath Password Grant Client')->accessToken;
                $data['application_id'] = $request->header('application_id');
                $data['employee_id'] = $user->id;
                $data['api_key'] = $request->header('api_key');
                $data['token_expires'] =  $request->header('token_expires');

                return response()->apiSuccess("User is active", $data);
            }

            Auth::logout();
            return response()->apiFailed("User(Supervisor) Permission is Unauthorized", 401);
        }else {
            return response()->apiFailed("User is unauthorized", 401);
        }
    }

    /**
     * User Profile
     * 
     * Returns the user profile
     * 
     * @header Authorization Bearer access_token
     * 
     * @response scenario=success {
     *  "employee_id": "user_id",
     *  "Employee_name": "name",
     *  "email_id": "email_id",
     *  "department_id": "department_id",
     *  "location": "location",
     *  "role": "role"
     * }
     * @response status=401 scenario="unauthenticated" {"message": "User is unauthenticated"}
     * 
     * @authenticated
     */
    public function getProfile()
    {
        $user = request()->user();

        $data = [
            "employee_id" => $user->id,
            "Employee_name" => $user->name,
            "email_id" => $user->email,
            "department_id" => "1",
            "location" => "1",
            "role" => "Facilitator"
        ];

        return response()->apiSuccess("User Profile", [$data]);
    }
}
