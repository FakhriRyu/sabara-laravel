<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguageSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->selected_language_id === null) {
            return redirect('/pilih-bahasa');
        }
        return $next($request);
    }
}
