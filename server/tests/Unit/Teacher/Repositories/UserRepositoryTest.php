<?php

namespace Tests\Unit\Teacher\Repositories;

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
    public function test_create_user()
    {
        $repo = new UserRepositoryImpl();

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

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

        $repo->create([
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        $user = \App\Models\User::get();

        $this->assertEquals(count($user), 0);
    }
}
