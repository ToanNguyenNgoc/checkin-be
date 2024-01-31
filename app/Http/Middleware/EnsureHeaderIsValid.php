<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\InvalidHeaderException;

class EnsureHeaderIsValid
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
        return $next($request);
        // if ($this->validateHeader($request)) {
        //     return $next($request);
        // }

        // throw new InvalidHeaderException;
    }

    protected function validateHeader($request)
    {
        if ($request->hasHeader('Accept')) {
            if ($request->expectsJson()) {
                if ($request->hasHeader('User-Agent')
                    && $request->hasHeader('App-Key')
                ) {
                    // if (\in_array($request->header('User-Agent'), ['PDA', 'WebPortal', 'MobileApp'])) {
                    //     if ($request->accepts(['application/json'])) {
                    //         $tmpAppKey = $request->header('App-Key');
                    //         $appKey = "base64:{$tmpAppKey}=";

                    //         if ($appKey === config('app.key')) {
                    //             return true;
                    //         }
                    //     }
                    // }
                    if ($request->accepts(['application/json'])) {
                        $tmpAppKey = $request->header('App-Key');
                        $appKey = "base64:{$tmpAppKey}=";

                        if ($appKey === config('app.key')) {
                            return true;
                        }
                    }
                }

                return false;
            }
        }

        abort(404);
    }
}
