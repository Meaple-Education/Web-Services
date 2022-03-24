<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $header = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->header['Accept'] = 'application/json';
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->header = [];
    }

    public function prepLoginTest()
    {
        $this->teacherLogin();
        $this->studentLogin();
    }

    public function teacherLogin()
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

        \App\Models\User::insert([
            'name' => 'test2',
            'password' => bcrypt('admin123'),
            'status' => 0,
            'email_verified' => 1,
            'email' => 'test2@gmail.com',
            'updated_at' => '2021-09-14 20:05:58',
            'created_at' => '2021-09-14 20:05:58',
            'auth_code' => 'XVOMEQ6DEFV3KSUS',
            'auth_created' => '2021-09-14 20:05:58',
        ]);

        \App\Models\UserSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => true,
            'is_valid' => true,
            'last_login' => '2021-09-14 20:05:58',
        ]);

        \App\Models\UserSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier2',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => true,
            'is_valid' => false,
            'last_login' => '2021-09-14 20:05:58',
        ]);

        \App\Models\UserSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier3',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => false,
            'is_valid' => true,
            'last_login' => '2021-09-14 20:05:58',
        ]);
    }

    public function studentLogin()
    {
        \App\Models\Student::insert([
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

        \App\Models\Student::insert([
            'name' => 'test2',
            'password' => bcrypt('admin123'),
            'status' => 0,
            'email_verified' => 1,
            'email' => 'test2@gmail.com',
            'updated_at' => '2021-09-14 20:05:58',
            'created_at' => '2021-09-14 20:05:58',
            'auth_code' => 'XVOMEQ6DEFV3KSUS',
            'auth_created' => '2021-09-14 20:05:58',
        ]);

        \App\Models\StudentSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => true,
            'is_valid' => true,
            'last_login' => '2021-09-14 20:05:58',
        ]);

        \App\Models\StudentSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier2',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => true,
            'is_valid' => false,
            'last_login' => '2021-09-14 20:05:58',
        ]);

        \App\Models\StudentSession::insert([
            'parent_id' => 1,
            'identifier' => 'identifier3',
            'ip' => '0.0.0.0',
            'browser' => '',
            'os' => '',
            'is_verify' => false,
            'is_valid' => true,
            'last_login' => '2021-09-14 20:05:58',
        ]);
    }

    public function prepSchoolTest()
    {
        $this->prepLoginTest();

        \App\Models\School::insert([
            'name' => 'Test School 1',
            'status' => 1,
            'description' => 'Test School desc 1',
            'address' => 'address 1',
            'phone_numbers' => json_encode(['09123456789']),
            'user_id' => 1,
        ]);
    }

    public function prepSchoolClassTest()
    {
        $this->prepSchoolTest();

        \App\Models\SchoolClass::insert([
            'name' => 'Class One',
            'description' => 'test class',
            'school_id' => 1,
        ]);
    }

    public function setupLoginHeader()
    {
        $token = \App\Models\User::find(1)->createToken('phpunit')->accessToken;
        $sesionIdentifier = \App\Models\UserSession::find(1)->identifier;

        $this->header = array_merge([
            'Authorization' => 'Bearer ' . $token,
            'sessionIdentifier' => $sesionIdentifier,
        ], $this->header);
    }
}
