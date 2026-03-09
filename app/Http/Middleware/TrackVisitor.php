<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is('admin*')) { // لا نسجل زيارات لوحة التحكم
            Visitor::create([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page'       => $request->path(),
            ]);
        }
        return $next($request);
    }
}
