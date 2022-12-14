<?php

namespace App\Http\Middleware;

use App\Utils\Toasts;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfirmSuccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $key) {
        $response = $next($request);

        if ($response instanceof RedirectResponse) {
            if ($response->getStatusCode() === Response::HTTP_FOUND) {
                Toasts::success('actions.' . $key);
            }
        }

        return $response;
    }
}
