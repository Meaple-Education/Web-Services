<?php

namespace App\Tution\RepositoriesImpl;

use DB;

use App\Models\Student;
use App\Models\StudentSession;
use App\Tution\Repositories\StudentRepository;
use Jenssegers\Agent\Agent;

class StudentRepositoryImpl implements StudentRepository
{
    function getOne(int $id)
    {
        return Student::find($id);
    }

    function getByEmail(string $email)
    {
        return Student::where('email', $email)
            ->first();
    }

    function get()
    {
        return Student::paginate(30);
    }

    function create($input)
    {
        $student = null;

        DB::beginTransaction();

        try {
            $student = Student::create([
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
                'msg' => 'Failed to create student!',
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
            'data' => $student,
            'msg' => 'Verification email is send to ' . $student->email . '. Please also check your spam folder.',
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
            $student = $this->getOne($id);
            $student->name = (string) $input['name'];
            $student->phone = (string) $input['phone'];
            $student->image = (string) $input['image'];
            $student->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update student info!',
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
            $student = Student::find($id);
            $student->email_verified = true;
            $student->activated_at = gmdate("Y-m-d H:i:s");
            $student->save();
            $student->sendOTPCode();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to verify student!',
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
            $studentSession = StudentSession::find($id);
            $studentSession->is_verify = true;
            $studentSession->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to verify student session!',
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
            $studentSession = StudentSession::find($id);
            $studentSession->wrong_attempted++;
            if ($studentSession->wrong_attempted > 2) {
                $studentSession->is_valid = 0;
                $res['data']['isExpire'] = true;
            }
            $studentSession->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [
                    'isExpire' => false,
                ],
                'msg' => 'Failed to verify student session!',
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
            $student = $this->getOne($id);
            $student->status = $status;
            $student->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update student status!',
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
        $studentSession = null;

        DB::beginTransaction();

        try {
            $agent = new Agent();

            $studentSession = StudentSession::create([
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
                'msg' => 'Failed to create student session!',
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
            'data' => $studentSession,
            'msg' => 'Student session created!',
        ];
    }

    function delete($id)
    {
        DB::beginTransaction();

        try {
            Student::where('id', $id)->delete();
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to delete student!',
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
            'msg' => 'Student deleted!',
        ];
    }
}
