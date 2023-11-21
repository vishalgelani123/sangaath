<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\DataExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PreRequisiteController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\HouseholdRegisterController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\UpdateStatusController;
use App\Http\Controllers\GovtSubmissionController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect(url('/login'));
});

Route::post('/login', [AuthController::class, 'loginProcess']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/docs', function() {
        $user = request()->user();
        if ($user->hasRole("admin")) {
            return response()->view("scribe/index");
        }

        return response()->json([
            'message' => 'Page not found.'
        ], 404);
    });

    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class, 'dashboard'])->name("home");
        Route::post('/daily-report', [DashboardController::class, 'getDailyReport']);
    });

    Route::get('/profile', [ProfileController::class, 'index']);

    Route::prefix('sites')->group(function() {
        Route::get('/', [SitesController::class, 'index']);
        Route::post('/save', [SitesController::class, 'save']);
        Route::post('/delete', [SitesController::class, 'destroy']);
    });

    Route::prefix('villages')->group(function() {
        Route::get('/', [VillageController::class, 'index']);
        Route::post('/save', [VillageController::class, 'save']);
        Route::post('/delete', [VillageController::class, 'destroy']);
    });

    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/save', [UserController::class, 'save']);
        Route::post('/delete', [UserController::class, 'destroy']);
    });

    Route::prefix('pre-requisites')->group(function() {
        Route::get('/', [PreRequisiteController::class, 'index']);
        Route::post('/save', [PreRequisiteController::class, 'save']);
        Route::post('/delete', [PreRequisiteController::class, 'destroy']);
    });

    Route::prefix('schemes')->group(function() {
        Route::get('/', [SchemeController::class, 'index']);
        Route::post('/save', [SchemeController::class, 'save']);
        Route::post('/delete', [SchemeController::class, 'destroy']);

        Route::post('/rules', [SchemeController::class, 'saveRules']);
    });

    Route::prefix('bulk-upload')->group(function() {
        Route::get('/', [BulkUploadController::class, 'index'])->name("bulk_upload");
        Route::post('/upload', [BulkUploadController::class, 'upload']);
    });

    Route::prefix('data-export')->group(function() {
        Route::get('/', [DataExportController::class, 'index'])->name("data_export");
        Route::post('/export', [DataExportController::class, 'export']);
    });

    Route::prefix('household-register')->group(function() {
        Route::get('/', [HouseholdRegisterController::class, 'index'])->name("household_register");
        Route::post('/save', [HouseholdRegisterController::class, 'save']);

        Route::post('/check-hhid', [HouseholdRegisterController::class, 'checkHHID']);
        Route::post('/card-distribution', [HouseholdRegisterController::class, 'checkCardDistribution']);
        Route::post('/card-distribution/update', [HouseholdRegisterController::class, 'updateCardDistributionStatus']);
    });

    Route::prefix('household')->group(function() {
        Route::post('/schemes', [HouseholdController::class, 'getSchemes']);
        Route::get('/scheme/{id}/{member_id}', [HouseholdController::class, 'getSchemeDetails']);

        Route::get('/prerequisites/{member_row_id}', [HouseholdController::class, 'getPreRequisites']);
        Route::post('/save-prerequisites', [HouseholdController::class, 'savePreRequisites']);

        Route::get('/applications/{member_row_id}', [HouseholdController::class, 'getApplications']);

        Route::post('/save-pending', [HouseholdController::class, 'savePending']);
        Route::post('/save-member', [HouseholdController::class, 'saveMember']);

        Route::get('/{id}', [HouseholdController::class, 'viewHousehold']);
    });

    Route::prefix('application')->group(function() {
        Route::post('/save-incomplete', [ApplicationController::class, 'saveIncomplete']);
        Route::post('/skip-apply', [ApplicationController::class, 'skipApply']);
    });

    Route::prefix('documentation')->group(function() {
        Route::get('/incomplete', [DocumentationController::class, 'getIncomplete'])->name("documentation");
        Route::post('/incomplete/delete', [DocumentationController::class, 'deleteIncompleteForm']);

        Route::get('/pending', [DocumentationController::class, 'getPending'])->name("documentation");
        Route::get('/pending/details/{form_id}', [DocumentationController::class, 'downloadPendingDetails']);
        Route::get('/pending/documents/{form_id}', [DocumentationController::class, 'downloadPendingDocuments']);
        Route::post('/pending/delete', [DocumentationController::class, 'deletePendingForm']);

        Route::get('/complete', [DocumentationController::class, 'getComplete'])->name("documentation");
        Route::post('/complete/delete', [DocumentationController::class, 'deleteCompleteForm']);
    });

    Route::prefix('update-status')->group(function() {
        Route::get('/', [UpdateStatusController::class, 'index'])->name("update_status");
        Route::post('/save', [UpdateStatusController::class, 'save']);
    });

    Route::prefix('govt-submission')->group(function() {
        Route::get('/', [GovtSubmissionController::class, 'index'])->name("govt_submission");
        Route::get('/report/{form_ids}', [GovtSubmissionController::class, 'generateReport']);
        Route::post('/update-status', [GovtSubmissionController::class, 'updateStatus']);
    });


    Route::prefix('test')->group(function() {
        Route::get('/adarsh', [FollowUpController::class, 'gettestbyadarsh'])->name("followup");

    });

    Route::prefix('followup')->group(function() {
        Route::get('/today', [FollowUpController::class, 'getTodayFollowups'])->name("followup");
        Route::get('/previous', [FollowUpController::class, 'getPastFollowups'])->name("followup");
        Route::get('/benefit-received', [FollowUpController::class, 'getBenefitReceived'])->name("followup");
        Route::get('/rejected', [FollowUpController::class, 'getRejected'])->name("followup");

        Route::post('/update-status', [FollowUpController::class, 'updateStatus']);
    });

    Route::prefix('charts')->group(function() {
        Route::get('/village-wise-applications', [ChartController::class, 'getVillageWiseApplications'])->name("charts");
        Route::post('/village-wise-applications', [ChartController::class, 'getVillageWiseApplicationsData']);

        Route::get('/scheme-wise-applications', [ChartController::class, 'getSchemeWiseApplications'])->name("charts");
        Route::post('/scheme-wise-applications', [ChartController::class, 'getSchemeWiseApplicationsData']);

        Route::get('/prd-wise-applications', [ChartController::class, 'getPRDWiseApplications'])->name("charts");
        Route::post('/prd-wise-applications', [ChartController::class, 'getPRDWiseApplicationsData']);

        Route::get('/card-disbursement', [ChartController::class, 'getCardDisbursement'])->name("charts");
        Route::post('/card-disbursement', [ChartController::class, 'getCardDisbursementData']);

        Route::get('/prerequisite-digitized', [ChartController::class, 'getPreRequisiteDigitized'])->name("charts");
        Route::post('/prerequisite-digitized', [ChartController::class, 'getPreRequisiteDigitizedData']);
    });

    // Route::

    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});
