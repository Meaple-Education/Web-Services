<?php

namespace App\Http\Middleware\V1\Teacher\School;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;

class ValidateSchoolID
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
        $school = School::find($request->schoolID);

        if (empty($school)) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'data' => [
                    'cause' => 'school_not_found'
                ],
                'msg' => 'Invalid school!',
            ], 404);
        }

        return $next($request);
    }
}
