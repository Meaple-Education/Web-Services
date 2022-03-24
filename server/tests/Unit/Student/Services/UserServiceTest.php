<?php

namespace Tests\Unit\Student\Services;

use Auth;

use App\Tution\RepositoriesImpl\StudentRepositoryImpl;
use App\Tution\Student\ServicesImpl\UserServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    private $service;
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new UserServiceImpl(new StudentRepositoryImpl());
        $this->request = new Request;
    }

    public function test_register()
    {
        $this->request->merge([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'admin123'
        ]);

        $register = $this->service->register($this->request);

        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Verification email is send to test@test.com. Please also check your spam folder.',
        ], $register);
        $this->assertEquals(count(\App\Models\Student::get()), 1);
    }

    public function test_register_error()
    {
        $register = $this->service->register($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create student!',
        ], $register);
        $this->assertEquals(count(\App\Models\Student::get()), 0);
    }

    public function test_login_email_not_verified()
    {
        $this->prepLoginTest();
        \App\Models\Student::where('id', 1)
            ->update([
                'email_verified' => 0,
            ]);

        $this->request->merge([
            'email' => 'test@gmail.com',
            'otp' => '',
        ]);

        $login = $this->service->login($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'msg' => 'Verify your email first!',
            'data' => [],
        ], $login);
    }

    public function test_login_deactivated()
    {
        $this->prepLoginTest();
        \App\Models\Student::where('id', 1)
            ->update([
                'status' => 0,
            ]);

        $this->request->merge([
            'email' => 'test@gmail.com',
            'otp' => '',
        ]);

        $login = $this->service->login($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'msg' => 'Your account is deactivated!',
            'data' => [],
        ], $login);
    }

    public function test_login_invalid_otp()
    {
        $this->prepLoginTest();

        $this->request->merge([
            'email' => 'test@gmail.com',
            'otp' => '123123',
        ]);

        $login = $this->service->login($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'msg' => 'Invalid OTP!',
            'data' => [],
        ], $login);
    }

    public function test_login()
    {
        $this->prepLoginTest();

        $this->request->merge([
            'email' => 'test@gmail.com',
            'otp' => \App\Models\Student::find(1)->currentOTP(),
        ]);

        $login = $this->service->login($this->request);

        $login['data'] = [];

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'msg' => 'Login success!',
            'data' => [],
        ], $login);
    }

    public function test_verify_already_verified()
    {
        $this->prepLoginTest();

        $this->request->merge([
            'email' => 'test@gmail.com',
            'code' => ''
        ]);

        $verify = $this->service->verify($this->request);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'msg' => 'Verification success.',
            'data' => [],
        ], $verify);
    }

    public function test_verify_invalid_code()
    {
        $this->prepLoginTest();
        \App\Models\Student::where('id', 1)
            ->update([
                'email_verified' => 0,
            ]);

        $this->request->merge([
            'email' => 'test@gmail.com',
            'code' => ''
        ]);

        $verify = $this->service->verify($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Invalid verification code!',
        ], $verify);
    }

    public function test_verify()
    {
        $this->prepLoginTest();
        \App\Models\Student::where('id', 1)
            ->update([
                'email_verified' => 0,
            ]);

        $this->request->merge([
            'email' => 'test@gmail.com',
            'code' => bcrypt('1XVOMEQ6DEFV3KSUN'),
        ]);

        $verify = $this->service->verify($this->request);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ], $verify);
    }

    public function test_password_verify_wrong_attempted()
    {
        $this->prepLoginTest();
        $this->request->merge([
            'password' => 'admin321',
        ]);

        $this->request->setUserResolver(function () {
            return \App\Models\Student::find(1);
        });

        $this->request->attributes->set('sessionInfo', \App\Models\StudentSession::first());

        $verify = $this->service->passwordVerify($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [
                'isExpire' => false,
            ],
            'msg' => 'Invalid password!',
        ], $verify);

        $this->assertEquals(\App\Models\StudentSession::find(1)->wrong_attempted, 1);
        \App\Models\StudentSession::where('id', 1)->update(['wrong_attempted' => 2]);

        $verify = $this->service->passwordVerify($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [
                'isExpire' => true,
            ],
            'msg' => 'Invalid password!',
        ], $verify);

        $this->assertEquals(\App\Models\StudentSession::find(1)->wrong_attempted, 3);
        $this->assertEquals(\App\Models\StudentSession::find(1)->is_valid, 0);
    }

    public function test_password_verify()
    {
        $this->prepLoginTest();
        $this->request->merge([
            'password' => 'admin123',
        ]);

        $this->request->setUserResolver(function () {
            return \App\Models\Student::find(1);
        });

        $this->request->attributes->set('sessionInfo', \App\Models\StudentSession::first());

        $verify = $this->service->passwordVerify($this->request);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.',
        ], $verify);
    }

    public function test_get_profile()
    {
        $this->prepLoginTest();

        $this->request->setUserResolver(function () {
            return \App\Models\Student::find(1);
        });

        $profile = $this->service->getProfile($this->request);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => 1,
                    'name' => 'test',
                    'email' => 'test@gmail.com',
                    'image' => '',
                    'phone' => '',
                    'lastLogin' => '',
                    'activatedAt' => '',
                ]
            ],
            'msg' => 'Success.',
        ], $profile);
    }
}
