<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function ($values) {
            return response()->json(["status" => 1, "data" => $values]);
        });

        Response::macro('failed', function ($errorMessage) {
            return response()->json(["status" => -1, "error_msg" => $errorMessage]);
        });


        Response::macro('apiSuccess', function ($message, $data, $errorCode = null) {
            $jsonData = ['status' => 'success', 'Message' => $message , 'data'=>$data];
            if ($errorCode != null) {
                $jsonData["error_code"] = $errorCode;
            }
            return response()->json($jsonData, 200); 
        });

        Response::macro('apiFailed', function ($errorMessage, $errorCode) {
            return response()->json(['error' => $errorMessage], $errorCode); 
        });
    }
}
