<?php

namespace Tests\Feature\V1\Teacher;

use Tests\TestCase;

class SchoolClassControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->prepSchoolClassTest();
        $this->setupLoginHeader();
    }

    public function test_get_class_list()
    {
        $response = $this->get(route('teacher.v1.class.list', ['schoolID' => 1]), $this->header);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1,
            'code' => 200,
            'data' => [
                'list' => [
                    [
                        'id' => 1,
                        'name' => 'Class One',
                        'description' => 'test class',
                        'school_id' => 1,
                        'created_at' => '',
                        'updated_at' => '',
                    ],
                ],
            ],
            'msg' => 'Success.'
        ]);
    }

    public function test_get_class()
    {
        $response = $this->get(route('teacher.v1.class.info', ['schoolID' => 1, 'classID' => 1]), $this->header);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => 1,
                    'name' => 'Class One',
                    'description' => 'test class',
                    'school_id' => 1,
                    'created_at' => '',
                    'updated_at' => '',
                ],
            ],
            'msg' => 'Success.'
        ]);
    }

    public function test_get_class_error()
    {
        $response = $this->get(route('teacher.v1.class.info', ['schoolID' => 1, 'classID' => 99991]), $this->header);

        $response->assertStatus(404);
        $response->assertJson([
            'status' => false,
            'code' => 404,
            'data' => [
                'cause' => 'class_not_found'
            ],
            'msg' => 'Invalid class!',
        ]);
    }

    public function test_create_class()
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
                    'name' => 'Classname',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The description field is required.',
                ],
            ],
            [
                'code' => 201,
                'data' => [
                    'name' => 'Classname',
                    'description' => 'Classdesc',
                ],
                'response' => [
                    'status' => true,
                    'code' => 201,
                    'data' => [
                        'info' => [
                            'id' => 2,
                            'name' => 'Classname',
                            'description' => 'Classdesc',
                            'school_id' => 1,
                        ],
                    ],
                    'msg' => 'Success.',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.class.add', ['schoolID' => 1,]), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }

    public function test_update_class()
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
                    'name' => 'Classname',
                ],
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The description field is required.',
                ],
            ],
            [
                'code' => 200,
                'data' => [
                    'name' => 'Classname',
                    'description' => 'Classdesc',
                ],
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Success.',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.class.update', ['schoolID' => 1, 'classID' => 1]), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
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
                'response' => [
                    'status' => true,
                    'code' => 200,
                    'data' => [],
                    'msg' => 'Success.',
                ],
            ],
            [
                'code' => 422,
                'data' => [],
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
                'response' => [
                    'status' => false,
                    'code' => 422,
                    'data' => [],
                    'msg' => 'The selected status is invalid.',
                ],
            ],
        ];

        foreach ($cases as $case) {
            $response = $this->post(route('teacher.v1.class.update.status', ['schoolID' => 1, 'classID' => 1]), $case['data'], $this->header);

            if ($case['code'] !== $response->status()) {
                // print_r($case);
                print_r($response->getOriginalContent());
            }

            $response->assertStatus($case['code']);
            $response->assertJson($case['response']);
        }
    }
}
