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
                    'token' => $userInfo->createToken('app')->accessToken->token,
                    'sessionIdentifier' => $createSession['data']->identifier
                ],
            ];
        }

        return $createSession;
    }

    public function verify(Request $request)
    {
        $input = $request->only('code', 'email');

        $validator = Validator::make($input, [
            'code' => 'required',
            'email' => 'required|email|exists:user,email',
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => $validator->errors()->all()[0]
            ];
        }

        $userInfo = $this->repo->getByEmail($input['email']);

        if ($userInfo->email_verified) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [],
                'msg' => 'Verification success!',
            ];
        }

        if (!Hash::check($userInfo->id . $userInfo->auth_code, $input['code'])) {
            return [
                'status' => false,
                'code' => '422',
                'data' => [],
                'msg' => 'Invalid verification code!',
            ];
        }

        return $this->repo->verify($userInfo->id);
    }

    public function passwordVerify(Request $request)
    {
        $input = $request->only('password');

        $validator = Validator::make($input, [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => $validator->errors()->all()[0],
            ];
        }

        $userInfo = $this->repo->getOne($request->user()->id);

        if (!Hash::check($input['password'], $userInfo->password)) {
            $wrongAttempted = $this->repo->wrongAttempted($request->attributes->get('sessionInfo')->id);
            if (!$wrongAttempted['status']) {
                return $wrongAttempted;
            }

            return [
                'status' => false,
                'code' => '422',
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
                'info' => $request->user(),
            ],
            'msg' => 'Success.'
        ];
    }

    public function verifyAccount(Request $request)
    {
        $input = $request->only('email', 'code');

        $validator = Validator::make($input, [
            'email' => 'required|email|exists:user,email',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => $validator->errors()->all()[0],
                'data' => [$input],
            ];
        }

        $user = $this->repo->getByEmail($input['email']);

        // if ($user->email_verified) {
        //     return [
        //         'status' => true,
        //         'code' => 200,
        //         'data' => [],
        //         'msg' => 'Email is already verified.'
        //     ];
        // }

        if (!Hash::check($user->id . $user->auth_code, $input['code'])) {
            return [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Invalid verification code!',
            ];
        }

        return $this->repo->verify($user->id);
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

    public function comeOnSampleTest(Request $request)
    {
        return 2;
    }
}
