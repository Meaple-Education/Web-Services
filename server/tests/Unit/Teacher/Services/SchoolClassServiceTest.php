<?php

namespace Tests\Unit\Teacher\Services;

use App\Tution\RepositoriesImpl\SchoolClassRepositoryImpl;
use App\Tution\Teacher\ServicesImpl\SchoolClassServiceImpl;
use Illuminate\Http\Request;
use Tests\TestCase;

class SchoolClassServiceTest extends TestCase
{
    private $service;
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SchoolClassServiceImpl(new SchoolClassRepositoryImpl());
        $this->request = new Request();
        $this->prepSchoolClassTest();
        $this->request->setUserResolver(function () {
            return \App\Models\User::find(1);
        });
        $this->request->schoolID = 1;
    }

    public function test_get_classes()
    {
        $classes = $this->service->getClasses($this->request);

        unset($classes['data']['list'][0]['updated_at']);
        unset($classes['data']['list'][0]['created_at']);

        $this->assertEquals($classes, [
            'status' => 1,
            'code' => 200,
            'data' => [
                'list' => [
                    [
                        'id' => 1,
                        'name' => 'Class One',
                        'description' => 'test class',
                        'school_id' => 1,
                        'status' => 1,
                    ],
                ],
            ],
            'msg' => 'Success.',
        ]);
    }

    public function test_get_class()
    {
        $this->request->classID = 1;
        $classes = $this->service->getClass($this->request);

        unset($classes['data']['info']['updated_at']);
        unset($classes['data']['info']['created_at']);

        $this->assertEquals($classes, [
            'status' => 1,
            'code' => 200,
            'data' => [
                'info' => [
                    'id' => 1,
                    'name' => 'Class One',
                    'description' => 'test class',
                    'school_id' => 1,
                    'status' => 1,
                ],
            ],
            'msg' => 'Success.',
        ]);
    }

    public function test_create_class()
    {
        $this->request->merge([
            'name' => 'second class',
            'description' => 'description'
        ]);

        $createClass = $this->service->createClass($this->request);

        unset($createClass['data']['info']['updated_at']);
        unset($createClass['data']['info']['created_at']);

        $this->assertEquals($createClass, [
            'status' => 1,
            'code' => 201,
            'data' => [
                'info' => [
                    'id' => 2,
                    'name' => 'second class',
                    'description' => 'description',
                    'school_id' => 1,
                    'status' => 1,
                ],
            ],
            'msg' => 'Success.',
        ]);
    }

    public function test_update_class()
    {
        $this->request->merge([
            'name' => 'class update',
            'description' => 'description update'
        ]);
        $this->request->classID = 1;

        $updateClass = $this->service->updateClass($this->request);

        $this->assertEquals($updateClass, [
            'status' => 1,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ]);
    }

    public function test_update_class_status()
    {
        $this->request->merge([
            'status' => 0,
        ]);
        $this->request->classID = 1;

        $updateClass = $this->service->updateClassStatus($this->request);

        $this->assertEquals($updateClass, [
            'status' => 1,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ]);
    }
}
