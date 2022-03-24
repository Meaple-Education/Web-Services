<?php

namespace App\Tution\Student\ServicesImpl;

use Hash;

use App\Tution\Student\Services\UserService;
use App\Tution\Repositories\StudentRepository;
use Illuminate\Http\Request;

class UserServiceImpl implements UserService
{
    private $repo;

    public function __construct(StudentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(Request $request)
    {
        $input = $request->only('name', 'email', 'password');

        $createStudent = $this->repo->create($input);

        $createStudent['data'] = [];

        return $createStudent;
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'otp');

        $studentInfo = $this->repo->getByEmail($input['email']);

        if ((int)$studentInfo->email_verified === 0) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Verify your email first!',
                'data' => [],
            ];
        }

        if ((int) $studentInfo->status !== 1) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Your account is deactivated!',
                'data' => [],
            ];
        }

        if (!$studentInfo->isOTPValid($input['otp'])) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Invalid OTP!',
                'data' => [],
            ];
        }

        $createSession = $this->repo->createSession($studentInfo->id);

        if ($createSession['status']) {
            $createSession = [
                'status' => true,
                'code' => 200,
                'msg' => 'Login success!',
                'data' => [
                    'token' => $studentInfo->createToken('app')->accessToken,
                    'sessionIdentifier' => $createSession['data']->identifier
                ],
            ];
        }

        return $createSession;
    }

    public function verify(Request $request)
    {
        $input = $request->only('code', 'email');

        $studentInfo = $this->repo->getByEmail($input['email']);

        if ($studentInfo->email_verified) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [],
                'msg' => 'Verification success.',
            ];
        }

        if (!Hash::check($studentInfo->id . $studentInfo->auth_code, $input['code'])) {
            return [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Invalid verification code!',
            ];
        }

        return $this->repo->verify($studentInfo->id);
    }

    public function passwordVerify(Request $request)
    {
        $input = $request->only('password');

        $studentInfo = $this->repo->getOne($request->user()->id);

        if (!Hash::check($input['password'], $studentInfo->password)) {
            $wrongAttempted = $this->repo->wrongAttempted($request->attributes->get('sessionInfo')->id);

            if (!$wrongAttempted['status']) {
                // @codeCoverageIgnoreStart
                return $wrongAttempted;
                // @codeCoverageIgnoreEnd
            }

            return [
                'status' => false,
                'code' => 422,
                'data' => $wrongAttempted['data'],
                'msg' => 'Invalid password!',
            ];
        }

        return $this->repo->verifySession($request->attributes->get('sessionInfo')->id);
    }

    public function getProfile(Request $request)
    {
        return [
            'status' => true,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => (int) $request->user()->id,
                    'name' => (string) $request->user()->name,
                    'email' => (string) $request->user()->email,
                    'image' => (string) $request->user()->image,
                    'phone' => (string) $request->user()->phone,
                    'lastLogin' => (string) $request->user()->last_login,
                    'activatedAt' => (string) $request->user()->activated_at,
                ],
            ],
            'msg' => 'Success.'
        ];
    }

    public function updateProfileImage(Request $request)
    {
    }

    public function updateProfile(Request $request)
    {
    }
}
