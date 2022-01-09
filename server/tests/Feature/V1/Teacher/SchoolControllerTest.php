<?php

namespace Tests\Feature\V1\Teacher;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->prepSchoolTest();
        $this->setupLoginHeader();
    }

    public function test_get_school_list()
    {
        $response = $this->get(route('teacher.v1.school.list'), $this->header);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1,
            'code' => 200,
            'data' => [
                'list' => [
                    [
                        'id' => 1,
                        'logo' => '',
                        'name' => 'Test School 1',
                        'status' => 1,
                        'description' => 'Test School desc 1',
                        'address' => 'address 1',
                        'phone_numbers' => [
                            '09123456789',
                        ],
                        'user_id' => 1,
                        'deleted_at' => '',
                        'created_at' => '',
                        'updated_at' => '',
                    ],
                ],
            ],
            'msg' => 'Success'
        ]);
    }

    public function test_get_school()
    {
        $response = $this->get(route('teacher.v1.school.info', ['schoolID' => 1]), $this->header);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => 1,
                    'logo' => '',
                    'name' => 'Test School 1',
                    'status' => 1,
                    'description' => 'Test School desc 1',
                    'address' => 'address 1',
                    'phone_numbers' => [
                        '09123456789',
                    ],
                    'user_id' => 1,
                    'deleted_at' => '',
                    'created_at' => '',
                    'updated_at' => '',
                ],
            ],
            'msg' => 'Success'
        ]);
    }

    public function test_create_school()
    {
        $cases = [
            [
                'code' => 422,
                'data' => [],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The name field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The description field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The address field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                    'address' => 'School address',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The phone numbers field is required.',
                ],
            ],
            [
                'code' => 201,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                    'address' => 'School address',
                    'phone_numbers' => json_encode(['09401526924'])
                ],
                'response' => [
                    'status' => true,
                    'code' => 201,
                    'data' => [
                        'id' => 2,
                        'name' => 'School name',
                        'description' => 'School desc',
                        'address' => 'School address',
                        'phone_numbers' => ['09401526924'],
                        'user_id' => 1,
                    ],
                    'msg' => 'Success.',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.school.add'), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
                // print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_update_school()
    {
        $cases = [
            [
                'code' => 422,
                'data' => [],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The name field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The description field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The address field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                    'address' => 'School address',
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The phone numbers field is required.',
                ],
            ],
            [
                'code' => 200,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                    'address' => 'School address',
                    'phone_numbers' => json_encode(['09401526924'])
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Success',
                ],
            ],
            [
                'code' => 404,
                'data' => [
                    'name' => 'School name',
                    'description' => 'School desc',
                    'address' => 'School address',
                    'phone_numbers' => json_encode(['09401526924'])
                ],
                'schoolID' => 1123,
                'response' => [
                    'status' => false,
                    'code' => 404,
                    'data' => [
                        'cause' => 'school_not_found'
                    ],
                    'msg' => 'Invalid school!',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.school.update', ['schoolID' => $case['schoolID']]), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
                // print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_update_school_status()
    {
        $cases = [
            [
                'code' => 200,
                'data' => [
                    'status' => 1,
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Success',
                ],
            ],
            [
                'code' => 422,
                'data' => [],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The status field is required.',
                ],
            ],
            [
                'code' => 422,
                'data' => [
                    'status' => 3
                ],
                'schoolID' => 1,
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The selected status is invalid.',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.school.update.status', ['schoolID' => $case['schoolID']]), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
                // print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }
}
