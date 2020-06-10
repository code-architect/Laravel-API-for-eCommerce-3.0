<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;


class CustomThrottleRequest extends ThrottleRequests
{
    use ApiResponser;
    protected function buildResponse($key, $maxAttempts)
    {
        $response = $this->errorResponse('Too many Attempts', 429);

        $retryAfter = $this->limiter->availableIn($key);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );
    }
}
