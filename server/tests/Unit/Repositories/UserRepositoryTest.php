<?php

namespace Tests\Unit\Repositories;

use App\Tution\RepositoriesImpl\UserRepositoryImpl;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_one_user()
    {
        $repo = new UserRepositoryImpl();

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $user = $repo->getOne(1);

        $this->assertNotEmpty($user);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_by_user_email()
    {
        $repo = new UserRepositoryImpl();

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $user = $repo->getByEmail("test@email.com");

        $this->assertNotEmpty($user);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_users()
    {
        \App\Models\User::insert([
            "name" => "test",
            "password" => bcrypt('admin123'),
            "email" => "test@gmail.com",
            "updated_at" => "2021-09-14 20:05:58",
            "created_at" => "2021-09-14 20:05:58",
            "auth_code" => "XVOMEQ6DEFV3KSUN",
            "auth_created" => "2021-09-14 20:05:58"
        ]);

        $repo = new UserRepositoryImpl();

        $users = $repo->get();

        $this->assertNotEmpty($users);
        $this->assertEquals(count($users), 1);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $repo = new UserRepositoryImpl();

        $createUser = $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $createUser['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Verification email is send to test@email.com. Please also check your spam folder.',
        ], $createUser);

        $user = \App\Models\User::get();

        $this->assertEquals(count($user), 1);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_user_exception()
    {
        $repo = new UserRepositoryImpl();

        $failedCreate = $repo->create([
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create user!',
        ], $failedCreate);

        $user = \App\Models\User::get();
        $this->assertEquals(count($user), 0);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_verify()
    {
        \App\Models\User::insert([
            "name" => "Sai",
            "password" => bcrypt('admin123'),
            "email" => "saiponethaaung@gmail.com",
            "updated_at" => "2021-09-14 20:05:58",
            "created_at" => "2021-09-14 20:05:58",
            "auth_code" => "XVOMEQ6DEFV3KSUN",
            "auth_created" => "2021-09-14 20:05:58"
        ]);
        $repo = new UserRepositoryImpl();

        $verifyUser = $repo->verify(1);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Verification success.'
        ], $verifyUser);

        $user = \App\Models\User::find(1);
        $this->assertNotEmpty($user);
        $this->assertEquals($user->email_verified, true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_verify_exception()
    {
        $repo = new UserRepositoryImpl();

        $verifyUser = $repo->verify(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to verify user!',
        ], $verifyUser);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_user_session()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $createSession = $repo->createSession(1);
        $this->assertEquals(count(\App\Models\UserSession::where('parent_id', 1)->get()), 1);

        $createSession['data'] = [];
        $this->assertEquals([
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'User session created!',
        ], $createSession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_user_session_exception()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $createSession = $repo->createSession(1);
        $this->assertEquals(count(\App\Models\UserSession::where('parent_id', 1)->get()), 0);

        $createSession['data'] = [];
        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to create user session!',
        ], $createSession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_delete_user()
    {
        $repo = new UserRepositoryImpl();

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $deleteUser = $repo->delete(1);
        $this->assertEmpty(\App\Models\User::find(1));

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'User deleted!',
        ], $deleteUser);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_verify_session()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
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
        $this->assertEquals(\App\Models\UserSession::find(1)->is_verify, 1);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_verify_session_exception()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $verifySession  = $repo->verifySession(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to verify user session!',
        ], $verifySession);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
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
            'msg' => 'Success',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted_expired()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);
        $repo->createSession(1);

        \App\Models\UserSession::where('id', 1)
            ->update([
                'wrong_attempted' => 2,
            ]);
        $wrongAttempted = $repo->wrongAttempted(1);

        $session = \App\Models\UserSession::find(1);

        $this->assertEquals($session->is_valid, 0);
        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [
                'isExpire' => true,
            ],
            'msg' => 'Success',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_session_wrong_attempted_exception()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $wrongAttempted = $repo->wrongAttempted(1);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [
                'isExpire' => false,
            ],
            'msg' => 'Failed to verify user session!',
        ], $wrongAttempted);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_status()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $updateStatus = $repo->updateStatus(1, 0);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success',
        ], $updateStatus);
        $this->assertEquals(\App\Models\User::find(1)->status, 0);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_status_exception()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $updateStatus = $repo->updateStatus(1, 0);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update user status!',
        ], $updateStatus);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $updateValue = [
            'name' => 'User Test',
            'phone' => '321321123',
            'image' => ''
        ];

        $updateStatus = $repo->update(1, $updateValue);

        $this->assertEquals([
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success',
        ], $updateStatus);
        $user = \App\Models\User::find(1);
        $this->assertEquals([
            'name' => $user->name,
            'phone' => $user->phone,
            'image' => $user->image,
        ], $updateValue);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update_exception()
    {
        $repo = new UserRepositoryImpl();

        $_SERVER['REMOTE_ADDR'] = '0.0.0.0';

        $updateStatus = $repo->update(1, []);

        $this->assertEquals([
            'status' => false,
            'code' => 422,
            'data' => [],
            'msg' => 'Failed to update user info!',
        ], $updateStatus);
    }
}
