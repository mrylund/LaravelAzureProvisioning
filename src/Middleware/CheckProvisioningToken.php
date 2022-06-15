<?php

namespace RobTrehy\LaravelAzureProvisioning\Middleware;

use Closure;

class CheckProvisioningToken
{
    public function handle($request, Closure $next)
    {
        if (!config('azureprovisioning.enableTokenMiddleware')) {
            return $next($request);
        }

        // Perform action
        $token = request()->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'No token provided'], 401);
        }

        if ($token !== env('PROVISIONING_TOKEN')) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        return $next($request);
    }
}
