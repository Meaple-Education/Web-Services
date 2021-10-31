<?php

namespace App\Tution\Teacher\ServicesImpl;

use Hash;
use Validator;

use App\Tution\Teacher\Services\UserService;
use App\Tution\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserServiceImpl implements UserService
{
    private $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(Request $request)
    {
        $input = $request->only('name', 'email', 'password');

        $createUser = $this->repo->create($input);

        $createUser['data'] = [];

        return $createUser;
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'otp');

        $userInfo = $this->repo->getByEmail($input['email']);

        if ((int)$userInfo->email_verified === 0) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Verify your email first!',
                'data' => [],
            ];
        }

        if ((int) $userInfo->status !== 1) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Your account is deactivated!',
                'data' => [],
            ];
        }

        if (!$userInfo->isOTPValid($input['otp'])) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Invalid OTP!',
                'data' => [],
            ];
        }

        $createSession = $this->repo->createSession($userInfo->id);

        if ($createSession['status']) {
            $createSession = [
                'status' => true,
                'code' => 200,
                'msg' => 'Login success!',
                'data' => [
                    'token' => $userInfo->createToken('app')->accessToken,
                    'sessionIdentifier' => $createSession['data']->identifier
                ],
            ];
        }

        return $createSession;
    }

    public function verify(Request $request)
    {
        $input = $request->only('code', 'email');

        $userInfo = $this->repo->getByEmail($input['email']);

        if ($userInfo->email_verified) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [],
                'msg' => 'Verification success.',
            ];
        }

        if (!Hash::check($userInfo->id . $userInfo->auth_code, $input['code'])) {
            return [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Invalid verification code!',
            ];
        }

        return $this->repo->verify($userInfo->id);
    }

    public function passwordVerify(Request $request)
    {
        $input = $request->only('password');

        $userInfo = $this->repo->getOne($request->user()->id);

        if (!Hash::check($input['password'], $userInfo->password)) {
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

    public function verifyOTP(string $key, string $code)
    {
    }
}
