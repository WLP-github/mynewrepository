<?php

namespace FDA\Http\Middleware;

use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!$request->user()->isUser()) {
                return redirect()->route('admin.index');
            }
        }
        return $next($request);
    }
}
