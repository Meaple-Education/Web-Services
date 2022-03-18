<?php

namespace App\Http\Middleware\V1\Teacher\School;

use Closure;
use Illuminate\Http\Request;

class DeleteSchoolValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
