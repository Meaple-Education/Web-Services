<?php

namespace Tests\Unit\Repositories;

use App\Tution\RepositoriesImpl\StudentRepositoryImpl;
use Tests\TestCase;

class StudentRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_one_student()
    {
        $repo = new StudentRepositoryImpl();

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $student = $repo->getOne(1);

        $this->assertNotEmpty($student);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_by_student_email()
    {
        $repo = new StudentRepositoryImpl();

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $student = $repo->getByEmail("test@email.com");

        $this->assertNotEmpty($student);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_students()
    {
        \App\Models\Student::insert([
            "name" => "test",
            "password" => bcrypt('admin123'),
            "email" => "test@gmail.com",
            "updated_at" => "2021-09-14 20:05:58",
            "created_at" => "2021-09-14 20:05:58",
            "auth_code" => "XVOMEQ6DEFV3KSUN",
            "auth_created" => "2021-09-14 20:05:58"
        ]);

        $repo = new StudentRepositoryImpl();

        $students = $repo->get();

        $this->assertNotEmpty($students);
        $this->assertEquals(count($students), 1);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_student()
    {
        $repo = new StudentRepositoryImpl();

        $createStudent = $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $createStudent['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Verification email is send to test@email.com. Please also check your spam folder.',
        ], $createStudent);

        $student = \App\Models\Student::get();

        $this->assertEquals(count($student), 1);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_student_exception()
    {
        $repo = new StudentRepositoryImpl();

        $failedCreate = $repo->create([
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create student!',
        ], $failedCreate);

        $student = \App\Models\Student::get();
        $this->assertEquals(count($student), 0);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_student_verify()
    {
        \App\Models\Student::insert([
            "name" => "Sai",
            "password" => bcrypt('admin123'),
            "email" => "saiponethaaung@gmail.com",
            "updated_at" => "2021-09-14 20:05:58",
            "created_at" => "2021-09-14 20:05:58",
            "auth_code" => "XVOMEQ6DEFV3KSUN",
            "auth_created" => "2021-09-14 20:05:58"
        ]);

        $repo = new StudentRepositoryImpl();

        $verifyStudent = $repo->verify(1);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ], $verifyStudent);

        $student = \App\Models\Student::find(1);
        $this->assertNotEmpty($student);
        $this->assertEquals($student->email_verified, true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_student_verify_exception()
    {
        $repo = new StudentRepositoryImpl();

        $verifyStudent = $repo->verify(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to verify student!',
        ], $verifyStudent);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_student_session()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $createSession = $repo->createSession(1);

        $this->assertEquals(count(\App\Models\StudentSession::where('parent_id', 1)->get()), 1);

        $createSession['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Student session created!',
        ], $createSession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_student_session_exception()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $createSession = $repo->createSession(1);
        $this->assertEquals(count(\App\Models\StudentSession::where('parent_id', 1)->get()), 0);

        $createSession['data'] = [];
        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create student session!',
        ], $createSession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_delete_student()
    {
        $repo = new StudentRepositoryImpl();

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $deleteStudent = $repo->delete(1);
        $this->assertEmpty(\App\Models\Student::find(1));

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Student deleted!',
        ], $deleteStudent);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_verify_session()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);
        $repo->createSession(1);

        $verifySession  = $repo->verifySession(1);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ], $verifySession);
        $this->assertEquals(\App\Models\StudentSession::find(1)->is_verify, 1);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_verify_session_exception()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $verifySession  = $repo->verifySession(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to verify student session!',
        ], $verifySession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);
        $repo->createSession(1);

        $wrongAttempted = $repo->wrongAttempted(1);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [
                'isExpire' => false,
            ],
            'msg' => 'Success.',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted_expired()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);
        $repo->createSession(1);

        \App\Models\StudentSession::where('id', 1)
            ->update([
                'wrong_attempted' => 2,
            ]);

        $wrongAttempted = $repo->wrongAttempted(1);

        $session = \App\Models\StudentSession::find(1);

        $this->assertEquals($session->is_valid, 0);
        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [
                'isExpire' => true,
            ],
            'msg' => 'Success.',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted_exception()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $wrongAttempted = $repo->wrongAttempted(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [
                'isExpire' => false,
            ],
            'msg' => 'Failed to verify student session!',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_status()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $updateStatus = $repo->updateStatus(1, 0);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateStatus);
        $this->assertEquals(\App\Models\Student::find(1)->status, 0);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_status_exception()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $updateStatus = $repo->updateStatus(1, 0);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update student status!',
        ], $updateStatus);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $updateValue = [
            'name' => 'Student Test',
            'phone' => '321321123',
            'image' => ''
        ];

        $updateStatus = $repo->update(1, $updateValue);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ], $updateStatus);
        $student = \App\Models\Student::find(1);
        $this->assertEquals([
            'name' => $student->name,
            'phone' => $student->phone,
            'image' => $student->image,
        ], $updateValue);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_exception()
    {
        $repo = new StudentRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $updateStatus = $repo->update(1, []);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update student info!',
        ], $updateStatus);
    }
}
