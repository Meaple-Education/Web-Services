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
        return User::paginate(30);
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
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return [
            'status' => true,
            'code' => 201,
            'data' => $user,
            'msg' => 'Verification email is send to ' . $user->email . '. Please also check your spam folder.',
        ];
    }

    function update($id, $input)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ];

        DB::beginTransaction();

        try {
            $user = $this->getOne($id);
            $user->name = (string) $input['name'];
            $user->phone = (string) $input['phone'];
            $user->image = (string) $input['image'];
            $user->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update user info!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    function verify($id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $user->email_verified = true;
            $user->activated_at = gmdate("Y-m-d H:i:s");
            $user->save();
            $user->sendOTPCode();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to verify user!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
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
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
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
            'msg' => 'Success.',
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
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    function updateStatus($id, $status)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ];

        DB::beginTransaction();

        try {
            $user = $this->getOne($id);
            $user->status = $status;
            $user->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update user status!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    function createSession($id)
    {
        $userSession = null;

        DB::beginTransaction();

        try {
            $agent = new Agent();

            $userSession = UserSession::create([
                'parent_id' => $id,
                'identifier' => $this->getOne($id)->getIdentifier(),
                'browser' => (string) $agent->browser(),
                'ip' => (string) $_SERVER['REMOTE_ADDR'],
                'os' => (string) $agent->platform(),
                'last_login' => gmdate("Y-m-d H:i:s")
            ]);
        } catch (\Throwable | \Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create user session!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
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

    function delete($id)
    {
        DB::beginTransaction();

        try {
            User::where('id', $id)->delete();
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to delete user!',
            ];

            if (config('app.debug')) {
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
            }

            return $res;
        }
        // @codeCoverageIgnoreEnd

        DB::commit();

        return [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'User deleted!',
        ];
    }
}
