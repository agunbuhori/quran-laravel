<?php

namespace App\Http\Middleware;

use App\Enums\Lang;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('Content-Language') && !Lang::tryFrom($request->header('Content-Language'))) {
            return responder()->error(Response::HTTP_BAD_REQUEST, "language is not valid")->respond(Response::HTTP_BAD_REQUEST);
        }

        app()->setLocale($request->header('Content-Language', Lang::EN->value));
        
        return $next($request);
    }
}
