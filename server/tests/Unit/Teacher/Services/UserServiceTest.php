<?php

namespace Tests\Unit\Teacher\Services;

use App\Tution\RepositoriesImpl\UserRepositoryImpl;
use App\Tution\Teacher\ServicesImpl\UserServiceImpl;
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
        $this->service = new UserServiceImpl(new UserRepositoryImpl());
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
        $this->assertEquals(count(\App\Models\User::get()), 1);
    }

    public function test_register_error()
    {
        $register = $this->service->register($this->request);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create user!',
        ], $register);
        $this->assertEquals(count(\App\Models\User::get()), 0);
    }

    public function prepLoginTest()
    {
        \App\Models\User::insert([
            "name" => "test",
            "password" => bcrypt('admin123'),
            "status" => 1,
            'email_verified' => 1,
            "email" => "test@gmail.com",
            "updated_at" => "2021-09-14 20:05:58",
            "created_at" => "2021-09-14 20:05:58",
            "auth_code" => "XVOMEQ6DEFV3KSUN",
            "auth_created" => "2021-09-14 20:05:58"
        ]);
    }

    public function test_login_email_not_verified()
    {
        $this->prepLoginTest();
        \App\Models\User::where('id', 1)
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
        \App\Models\User::where('id', 1)
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
            'otp' => \App\Models\User::find(1)->currentOTP(),
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
}
