<?php

namespace Tests\Unit\Teacher\Services;

use App\Models\School;
use App\Tution\RepositoriesImpl\SchoolRepositoryImpl;
use App\Tution\Teacher\ServicesImpl\SchoolServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SchoolServiceTest extends TestCase
{
    use RefreshDatabase;
    private $service;
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SchoolServiceImpl(new SchoolRepositoryImpl());
        $this->request = new Request();
        $this->prepSchoolTest();
        $this->request->setUserResolver(function () {
            return \App\Models\User::find(1);
        });
    }

    public function test_get_schools()
    {

        $schools = $this->service->getSchools($this->request);

        $this->assertEquals($schools, [
            'status' => true,
            'code' => 200,
            'data' => [
                'list' => [
                    [
                        'id' => 1,
                        'logo' => null,
                        'name' => 'Test School 1',
                        'status' => '1',
                        'description' => 'Test School desc 1',
                        'address' => 'address 1',
                        'phone_numbers' => ['09123456789'],
                        'user_id' => '1',
                        'deleted_at' => null,
                        'created_at' => null,
                        'updated_at' => null,
                    ],
                ]
            ],
            'msg' => 'Success',
        ]);
    }

    public function test_get_school()
    {
        $this->request->schoolID = 1;

        $school = $this->service->getSchool($this->request);

        $this->assertEquals($school, [
            'status' => true,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => 1,
                    'logo' => null,
                    'name' => 'Test School 1',
                    'status' => '1',
                    'description' => 'Test School desc 1',
                    'address' => 'address 1',
                    'phone_numbers' => ['09123456789'],
                    'user_id' => '1',
                    'deleted_at' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ],

            ],
            'msg' => 'Success',
        ]);
    }

    public function test_create_school()
    {
        $this->request->merge([
            'name' => 'School test 2',
            'description' => 'desc 2',
            'address' => 'address 2',
            'phone_numbers' => json_encode(['123']),
        ]);

        $createSchool = $this->service->createSchool($this->request);
        unset($createSchool['data']['created_at']);
        unset($createSchool['data']['updated_at']);

        $this->assertEquals($createSchool, [
            'status' => true,
            'code' => 201,
            'data' => [
                'name' => 'School test 2',
                'description' => 'desc 2',
                'address' => 'address 2',
                'phone_numbers' => ["123"],
                'user_id' => 1,
                'id' => 2,
            ],
            'msg' => 'Success.',
        ]);

        $this->assertEquals(School::where('id', $createSchool['data']['id'])->count(), 1);
    }

    public function test_create_school_error()
    {
        $this->request->merge([
            'description' => 'desc 2',
            'address' => 'address 2',
            'phone_numbers' => json_encode(['123']),
        ]);

        $createSchool = $this->service->createSchool($this->request);

        $this->assertEquals($createSchool, [
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create school!',
        ]);
    }

    public function test_update_school()
    {
        $this->request->schoolID = 1;

        $this->request->merge([
            'name' => 'Test School 1 ed',
            'description' => 'Test School desc 1 ed',
            'address' => 'address 1 ed',
            'phone_numbers' => json_encode(['09123456780']),
        ]);

        $updateSchool = $this->service->updateSchool($this->request);

        $this->assertEquals($updateSchool, [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success'
        ]);
        $data = School::find(1);

        $this->assertEquals([
            'name' => $data->name,
            'description' => $data->description,
            'address' => $data->address,
            'phone_numbers' => $data->phone_numbers,
        ], [
            'name' => 'Test School 1 ed',
            'description' => 'Test School desc 1 ed',
            'address' => 'address 1 ed',
            'phone_numbers' => json_encode(['09123456780'])
        ]);
    }

    public function test_update_school_error()
    {
        $this->request->schoolID = 1;

        $this->request->merge([
            'name' => 'Test School 1 ed',
            'description' => 'Test School desc 1 ed',
            'address' => 'address 1 ed',
        ]);

        $updateSchool = $this->service->updateSchool($this->request);

        $this->assertEquals($updateSchool, [
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update school info!'
        ]);
    }

    public function test_update_school_status()
    {
        $this->request->schoolID = 1;

        $this->request->merge([
            'status' => 0,
        ]);

        $updateSchoolStatus = $this->service->updateSchoolStatus($this->request);

        $this->assertEquals($updateSchoolStatus, [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success'
        ]);

        $data = School::find(1);

        $this->assertEquals([
            'status' => $data->status,
        ], [
            'status' => 0,
        ]);
    }

    // public function test_delete_school()
    // {
    //     $this->request->schoolID = 1;

    //     $deleteSchoolStatus = $this->service->deleteSchool($this->request);

    //     print_r($deleteSchoolStatus);
    // }
}
