<?php

namespace Tests\Unit\Repositories;

use App\Models\SchoolClass;
use App\Tution\RepositoriesImpl\SchoolClassRepositoryImpl;
use Tests\TestCase;

class SchoolClassRepositoryTest extends TestCase
{
    private $repo;

    public function setUp(): void
    {
        parent::setUp();
        $this->prepSchoolTest();
        $this->repo = new SchoolClassRepositoryImpl();
    }


    public function createClass($input = [])
    {
        $input = array_merge([
            'name' => 'Class One',
            'description' => 'test class',
            'school_id' => 1,
        ], $input);

        return $this->repo->create($input);
    }

    public function test_get_class()
    {
        $this->createClass();

        $classes = $this->repo->get(1)->toArray();

        for ($i = 0; $i < count($classes); $i++) {
            unset($classes[$i]['updated_at']);
            unset($classes[$i]['created_at']);
        }

        $this->assertEquals($classes, [
            [
                'id' => 1,
                'name' => 'Class One',
                'description' => 'test class',
                'school_id' => 1,
                'status' => 1,
            ]
        ]);
    }

    public function test_create_class()
    {
        $createClass = $this->createClass();

        $this->assertEquals(SchoolClass::where('school_id', 1)->count(), 1);

        $createClass['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Success.',
        ], $createClass);
    }

    public function test_create_class_error()
    {
        $createClass = $this->createClass(['school_id' => '']);

        $this->assertEquals(SchoolClass::where('school_id', 1)->count(), 0);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create class!',
        ], $createClass);
    }

    public function test_update_class()
    {
        $this->createClass();

        $updateClass = $this->repo->update(1, [
            'name' => 'Class One updated',
            'description' => 'test class updated'
        ]);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateClass);

        $this->assertEquals(SchoolClass::where([
            'name' => 'Class One updated',
            'description' => 'test class updated'
        ])->count(), 1);
    }

    public function test_update_class_error()
    {
        $this->createClass();

        $updateClass = $this->repo->update(1, []);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update class!',
        ], $updateClass);


        $this->assertEquals(SchoolClass::where([
            'name' => 'Class One updated',
            'description' => 'test class updated'
        ])->count(), 0);
    }

    public function test_update_class_status()
    {
        $this->createClass();

        $updateClassStatus = $this->repo->updateStatus(1, ['status' => 0]);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateClassStatus);

        $this->assertEquals(SchoolClass::where([
            'id' => 1,
            'status' => 0
        ])->count(), 1);
    }

    public function test_update_class_status_error()
    {
        $this->createClass();

        $updateClassStatus = $this->repo->updateStatus(1, []);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update class status!',
        ], $updateClassStatus);
    }
}
