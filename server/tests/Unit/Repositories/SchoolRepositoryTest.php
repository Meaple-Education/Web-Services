<?php

namespace Tests\Unit\Repositories;

use App\Models\School;
use App\Models\User;
use App\Tution\RepositoriesImpl\SchoolRepositoryImpl;
use Tests\TestCase;

class SchoolRepositoryTest extends TestCase
{
    private $repo;
    public function setUp(): void
    {
        parent::setUp();
        User::insert([
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
        $this->repo = new SchoolRepositoryImpl();
    }

    public function createSchool()
    {
        $input = [
            'name' => 'School',
            'logo' => 'Logo',
            'description' => 'Description',
            'address' => 'Address',
            'phone_numbers' => json_encode(['09123321123']),
            'user_id' => 1,
        ];

        return $this->repo->create($input);
    }

    public function test_create_school()
    {
        $input = [
            'name' => 'School',
            'logo' => 'Logo',
            'description' => 'Description',
            'address' => 'Address',
            'phone_numbers' => json_encode(['09123321123']),
            'user_id' => 1,
        ];

        $createSchool = $this->repo->create($input);

        $this->assertEquals(School::where('user_id', 1)->count(), 1);

        $createSchool['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Success.',
        ], $createSchool);
    }

    public function test_create_school_error()
    {
        $input = [
            'name' => 'School',
            'logo' => 'Logo',
            'description' => 'Description',
            'address' => 'Address',
            'phone_numbers' => json_encode(['09123321123']),
            'user_id' => 200,
        ];

        $createSchool = $this->repo->create($input);

        $this->assertEquals(School::where('user_id', 1)->count(), 0);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create school!',
        ], $createSchool);
    }

    public function test_update_school()
    {
        $this->createSchool();

        $input = [
            'name' => 'School',
            'logo' => 'Logo',
            'description' => 'Description',
            'address' => 'Address',
            'phone_numbers' => json_encode(['09123321123']),
        ];

        $updateSchool = $this->repo->update(1, $input);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateSchool);
    }

    public function test_update_school_error()
    {
        $this->createSchool();

        $input = [
            'name' => 'School',
            'logo' => 'Logo',
            'description' => 'Description',
            'address' => 'Address',
            'phone_numbers' => json_encode(['09123321123']),
        ];

        $updateSchool = $this->repo->update(12, $input);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update school info!',
        ], $updateSchool);
    }

    public function test_update_School_status()
    {
        $this->createSchool();

        $updateSchoolStatus = $this->repo->updateStatus(1, 1);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateSchoolStatus);
    }

    public function test_update_School_status_error()
    {
        $this->createSchool();

        $updateSchoolStatus = $this->repo->updateStatus(3, 1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update school status!',
        ], $updateSchoolStatus);
    }
}
