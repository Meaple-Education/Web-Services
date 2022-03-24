<?php

namespace App\Http\Middleware\V1\Student;

use Auth;

use App\Models\StudentSession;
use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class VerifyToken
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
        if ((int) Auth::guard('student')->user()->status === 0) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'data' => [],
                'msg' => 'Account is deactivated!'
            ], 401);
        }

        $identifier = $request->header('sessionIdentifier');

        if (is_null($identifier) || $identifier === '') {
            return response()->json([
                'status' => false,
                'code' => 401,
                'data' => [],
                'msg' => 'Invalid request!',
            ], 401);
        }

        $session = StudentSession::where('identifier', $identifier)->first();

        if (empty($session) || (int) $session->is_valid !== 1) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'data' => [],
                'msg' => 'Invalid identifier!',
            ], 401);
        }

        if (
            !in_array($request->header('DeviceType'), [1, 2]) &&
            ((string) $session->ip !== (string) $_SERVER['REMOTE_ADDR'] ||
                (string) $session->browser !== (string) Agent::browser() ||
                (string) $session->os !== (string) Agent::platform())
        ) {
            $session->reject_ip = (string) $_SERVER['REMOTE_ADDR'];
            $session->reject_browser = (string) Agent::browser();
            $session->reject_os = (string) Agent::platform();
            $session->is_valid = 0;
            $session->save();
            return response()->json([
                'status' => false,
                'code' => 401,
                'data' => [],
                'msg' => 'Invalid request!',
            ], 401);
        }

        if ((int) $session->is_verify === 0 && request()->route()->getName() !== 'student.v1.auth.verifyPassword') {
            return response()->json([
                'status' => false,
                'code' => 403,
                'data' => [
                    'verificationRequired' => true,
                ],
                'msg' => 'Verify password first!',
            ], 403);
        }

        $session->last_login = gmdate('Y-m-d H:i:s');
        $session->save();

        Auth::guard('student')->user()->last_login = gmdate('Y-m-d H:i:s');
        Auth::guard('student')->user()->save();

        $request->attributes->set('sessionInfo', $session);

        return $next($request);
    }
}
