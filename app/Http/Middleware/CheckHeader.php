<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = $request->header('Accept');
        $applicationId = $request->header('application-id');
        $apiKey = $request->header('api-key');

        if ($acceptHeader != 'application/json') {
            return response()->json(['Failed header'], 400);
        }
        if ($applicationId != env("SANGAATH_APP_ID")) {
            return response()->json(['Failed application id'], 400);
        }
        if ($apiKey != env("SANGAATH_API_KEY")) {
            return response()->json(['Failed api key'], 400);
        }

        $date = Carbon::now()->addDays(1)->format('D, d M Y H:i:s');
        $request->headers->set('Accept', $acceptHeader);
        $request->headers->set('application_id', $applicationId);
        $request->headers->set('api_key', $apiKey);
        $request->headers->set('token_expires',$date);

        return $next($request);
    }
}
