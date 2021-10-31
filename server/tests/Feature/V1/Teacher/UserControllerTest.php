<?php

namespace Tests\Feature\V1\Teacher;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        \App\Models\User::insert([
            'name' => 'test',
            'password' => bcrypt('admin123'),
            'status' => 1,
            'email_verified' => 1,
            'email' => 'test@gmail.com',
            'updated_at' => '2021-09-14 20:05:58',
            'created_at' => '2021-09-14 20:05:58',
            'auth_code' => 'XVOMEQ6DEFV3KSUN',
            'auth_created' => '2021-09-14 20:05:58',
        ]);

        $cases = [
            [
                'input' => [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The name field is required.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => '',
                    'password' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email field is required.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => 'saipone',
                    'password' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email must be a valid email address.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => 'test@gmail.com',
                    'password' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email has already been taken.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => 'saipone@meaple-education.com',
                    'password' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The password field is required.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => 'saipone@meaple-education.com',
                    'password' => '123',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The password must be at least 8 characters.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'name' => 'test',
                    'email' => 'saipone@meaple-education.com',
                    'password' => '12345678',
                ],
                'response' => [
                    'status' => true,
                    'code' => 201,
                    'data' => [],
                    'msg' => 'Verification email is send to saipone@meaple-education.com. Please also check your spam folder.',
                ],
                'code' => 201,
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.auth.register'), $case['input']);
            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_login()
    {
        $this->prepLoginTest();
        $cases = [
            [
                'input' => [
                    'email' => '',
                    'otp' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email field is required.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'email' => 'sad',
                    'otp' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email must be a valid email address.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'email' => 'sad@awe.ca',
                    'otp' => '',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The selected email is invalid.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'email' => 'test@gmail.com',
                    'otp' => '123',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The otp must be at least 6 characters.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'email' => 'test@gmail.com',
                    'otp' => \App\Models\User::find(1)->currentOTP(),
                ],
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Success.',
                ],
                'code' => 200,
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.auth.login'), $case['input']);

            $response->assertStatus($case['code']);

            if ($case['code'] !== 200) {
                $response->assertJson($case['response']);
            } else {
                $response->assertJsonStructure([
                    'status',
                    'code',
                    'data' => [
                        'token',
                        'sessionIdentifier',
                    ],
                    'msg',
                ]);
            }
        }
    }

    public function test_password_verify()
    {
        $this->prepLoginTest();

        $token = \App\Models\User::find(1)->createToken('phpunit')->accessToken;
        $sesionIdentifier = \App\Models\UserSession::find(1)->identifier;

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'sessionIdentifier' => $sesionIdentifier,
        ];

        $cases = [
            [
                'input' => [],
                'header' => [],
                'response' => [
                    'message' => 'Unauthenticated.',
                ],
                'code' => 401,
            ],
            [
                'input' => [],
                'header' => $header,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The password field is required.'
                ],
                'code' => 422,
            ],
            [
                'input' => [],
                'header' => [
                    'Authorization' => $header['Authorization'],
                ],
                'response' => [
                    'status' => false,
                    'code' => 401,
                    'data' => [],
                    'msg' => 'Invalid request!'
                ],
                'code' => 401,
            ],
            [
                'input' => [],
                'header' => [
                    'Authorization' => $header['Authorization'],
                    'sessionIdentifier' => 'awdawdawdaw',
                ],
                'response' => [
                    'status' => false,
                    'code' => 401,
                    'data' => [],
                    'msg' => 'Invalid identifier!'
                ],
                'code' => 401,
            ],
            [
                'input' => [],
                'header' => [
                    'Authorization' => $header['Authorization'],
                    'sessionIdentifier' => \App\Models\UserSession::find(2)->identifier,
                ],
                'response' => [
                    'status' => false,
                    'code' => 401,
                    'data' => [],
                    'msg' => 'Invalid identifier!'
                ],
                'code' => 401,
            ],
            [
                'input' => [
                    'password' => 'admin123',
                ],
                'header' => $header,
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Verification success.'
                ],
                'code' => 200,
            ],
        ];

        foreach ($cases as $case) {
            $requestHeader = array_merge($case['header'], $this->header);
            $response = $this->post(route('teacher.v1.auth.verifyPassword'), $case['input'], $requestHeader);
            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_get_profile()
    {
        $this->prepLoginTest();

        $token = \App\Models\User::find(1)->createToken('phpunit')->accessToken;
        $sesionIdentifier = \App\Models\UserSession::find(1)->identifier;

        $header = [
            'Authorization' => 'Bearer ' . $token,
            'sessionIdentifier' => $sesionIdentifier,
        ];

        $cases = [
            [
                'header' => [
                    'Authorization' => $header['Authorization'],
                    'sessionIdentifier' => \App\Models\UserSession::find(3)->identifier,
                ],
                'response' => [
                    'status' => false,
                    'code' => 403,
                    'data' => [],
                    'msg' => 'Verify password first!'
                ],
                'code' => 403,
            ],
            [
                'header' => $header,
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [
                        "info" => [
                            "id" => 1,
                            "name" => "test",
                            "email" => "test@gmail.com",
                            "image" => "",
                            "phone" => "",
                            "activatedAt" => "",
                        ]
                    ],
                    'msg' => 'Success.'
                ],
                'code' => 200,
            ],
        ];


        foreach ($cases as $case) {
            $requestHeader = array_merge($case['header'], $this->header);
            $response = $this->get(route('teacher.v1.auth.profile'), $requestHeader);

            if ($case['code'] !== $response->status()) {
                print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_verify_account()
    {
        $this->prepLoginTest();

        $cases = [
            [
                'input' => [],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The code field is required.'
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'code' => '123',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email field is required.'
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'code' => '123',
                    'email' => '123',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The email must be a valid email address.'
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'code' => '123',
                    'email' => '123@awef.awef',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The selected email is invalid.',
                ],
                'code' => 422,
            ],
            [
                'input' => [
                    'email' => 'test@gmail.com',
                    'code' => bcrypt('1XVOMEQ6DEFV3KSUN'),
                ],
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Verification success.'
                ],
                'code' => 200,
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.auth.verifyAccount'), $case['input'], $this->header);

            if ($case['code'] !== $response->status()) {
                print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }
}
