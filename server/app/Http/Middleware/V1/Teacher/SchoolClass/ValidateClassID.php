<?php

namespace App\Http\Middleware\V1\Teacher\SchoolClass;

use App\Models\SchoolClass;
use Closure;
use Illuminate\Http\Request;

class ValidateClassID
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
        $school = SchoolClass::find($request->classID);

        if (empty($school)) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'data' => [
                    'cause' => 'class_not_found'
                ],
                'msg' => 'Invalid class!',
            ], 404);
        }

        return $next($request);
    }
}
