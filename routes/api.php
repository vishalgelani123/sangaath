<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DataController;
use App\Http\Controllers\API\HouseholdController;
use App\Http\Controllers\API\DocumentationController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\FollowUpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('test', function() {
// 	dd(bcrypt("1901@dfw"));
// });

Route::middleware('header.check')->post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/profile', [AuthController::class, 'getProfile']);

    Route::prefix('data')->group(function() {
        Route::get('/villages', [DataController::class, 'getVillages']);
        Route::get('/social-status', [DataController::class, 'getSocialStatus']);
        Route::get('/household-incomes', [DataController::class, 'getHouseholdIncomes']);
        Route::get('/castes', [DataController::class, 'getCastes']);
        Route::get('/disability-status', [DataController::class, 'getDisabilityStatus']);
        Route::get('/house-types', [DataController::class, 'getHouseType']);
        Route::get('/card-score', [DataController::class, 'getCardScores']);
        Route::get('/schemes', [DataController::class, 'getSchemes']);
        Route::get('/kycs', [DataController::class, 'getPreRequisites']);
    });

    Route::prefix('household')->group(function() {
        Route::get('/list/{hh_row_id}/{update_date}', [HouseholdController::class, 'getHouseholds']);
        Route::get('/details/{hh_id}', [HouseholdController::class, 'getHouseholdDetails']);

        Route::post('/register', [HouseholdController::class, 'registerHousehold']);
    });

    Route::prefix('member')->group(function() {
        Route::get('/list/{hh_id}', [MemberController::class, 'getHouseholdMembers']);
        Route::get('/details/{member_id}/{update_date}', [MemberController::class, 'getMemberDetails']);
        Route::get('/kycs/{member_id}/{update_date}', [MemberController::class, 'getMemberKYCs']);

        Route::post('/register', [MemberController::class, 'registerMember']);
        Route::post('/kycs-save', [MemberController::class, 'saveMemberKYCS']);
        Route::post('/kycs-delete', [MemberController::class, 'deleteMemberKYCs']);

        Route::get('/kycs-deleted/{update_date}', [MemberController::class, 'getDeletedKYCs']);
    });

    Route::prefix('documentation')->group(function() {
        Route::get('/pending/{update_date}', [DocumentationController::class, 'getPendingApplications']);
        Route::get('/incomplete/{update_date}', [DocumentationController::class, 'getIncompleteApplications']);
        Route::get('/complete/{update_date}', [DocumentationController::class, 'getCompleteApplications']);

        Route::post('/incomplete-save', [DocumentationController::class, 'saveIncompleteApplications']);
        Route::post('/pending-save', [DocumentationController::class, 'savePendingApplications']);

        Route::post('/pending-delete', [DocumentationController::class, 'deletePendingApplications']);
        Route::post('/incomplete-delete', [DocumentationController::class, 'deleteIncompleteApplications']);
        Route::post('/complete-delete', [DocumentationController::class, 'deleteCompleteApplications']);

        Route::get('/pending-deleted/{update_date}', [DocumentationController::class, 'getDeletedPendingApplications']);
        Route::get('/incomplete-deleted/{update_date}', [DocumentationController::class, 'getDeletedIncompleteApplications']);
        Route::get('/complete-deleted/{update_date}', [DocumentationController::class, 'getDeletedCompleteApplications']);
    });

    Route::prefix('followup')->group(function() {
        Route::get('/list/{update_date}', [FollowUpController::class, 'getFollowUps']);

        Route::post('/update', [FollowUpController::class, 'updateFollowUp']);
    });
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
