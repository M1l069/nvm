<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!request()->user() || (request()->user()->role !== UserRole::Admin && request()->user()->role !== UserRole::Teacher)) {
            return redirect()->back(fallback: route('home'))
                ->with('error', 'Túto akciu môže vykonať iba administrátor alebo učiteľ !');
        }
        return $next($request);
    }
}
