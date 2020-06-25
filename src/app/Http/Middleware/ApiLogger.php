<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        Log::create([
            'user' => $request->user()->email,
            'action' => $request->getPathInfo(),
            'method' => $request->getMethod(),
            'request_payload' => json_encode($request->all()),
        ]);
    }
}
