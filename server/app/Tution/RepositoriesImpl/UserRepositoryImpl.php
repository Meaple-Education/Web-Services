<?php

namespace App\Tution\RepositoriesImpl;

use DB;

use App\Models\User;
use App\Models\UserSession;
use App\Tution\Repositories\UserRepository;
use Jenssegers\Agent\Agent;

class UserRepositoryImpl implements UserRepository
{
    function getOne(int $id)
    {
        return User::find($id);
    }

    function getByEmail(string $email)
    {
        return User::where('email', $email)
            ->first();
    }

    function get()
    {
        User::paginate(30);
    }

    function create($input)
    {
        $user = null;

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create user!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }

        DB::commit();

        return [
            'status' => true,
            'code' => 201,
            'data' => $user,
            'msg' => 'User created!',
        ];
    }

    function update($id, $input)
    {
    }

    function verify($id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $user->email_verified = true;
            $user->verified_at = gmdate("Y-m-d H:i:s");
            $user->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create user!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }

        DB::commit();

        return [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ];
    }

    function verifySession($id)
    {
        DB::beginTransaction();

        try {
            $userSession = UserSession::find($id);
            $userSession->is_verify = true;
            $userSession->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to verify user session!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }

        DB::commit();

        return [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ];
    }

    function wrongAttempted($id)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [
                'isExpire' => false,
            ],
            'msg' => 'Success',
        ];

        DB::beginTransaction();

        try {
            $userSession = UserSession::find($id);
            $userSession->wrong_attempted++;
            if ($userSession->wrong_attempted > 2) {
                $userSession->is_valid = 0;
                $res['data']['isExpire'] = true;
            }
            $userSession->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [
                    'isExpire' => false,
                ],
                'msg' => 'Failed to verify user session!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    function updateStatus($id, $status)
    {
    }

    function createSession($id)
    {
        $userSession = null;

        DB::beginTransaction();

        try {
            $agent = new Agent();
            $userSession = UserSession::create([
                'parent_id' => $id,
                'browser' => (string) $agent->browser(),
                'ip' => (string) $_SERVER['REMOTE_ADDR'],
                'os' => (string) $agent->platform(),
                'last_login' => gmdate("Y-m-d H:i:s")
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create user session!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }

        DB::commit();

        return [
            'status' => true,
            'code' => 201,
            'data' => $userSession,
            'msg' => 'User session created!',
        ];
    }

    function delte($id)
    {
    }
}
