<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\VisitorLog;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') &&
            !$request->is('admin*') &&
            !$request->is('livewire*') &&
            !$request->ajax()) {

            $sessionId = $request->cookie('visitor_session_id');

            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                Cookie::queue('visitor_session_id', $sessionId, 60 * 24 * 365); // 1 year
            }

            try {
                VisitorLog::create([
                    'session_id' => $sessionId,
                    'path' => $request->path(),
                    'user_agent' => Str::limit($request->userAgent(), 255),
                ]);
            } catch (\Exception $e) {
                // Ignore errors
            }
        }

        return $next($request);
    }
}
