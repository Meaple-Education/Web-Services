<?php

namespace Tests\Unit\Teacher\Services;

use App\Tution\RepositoriesImpl\UserRepositoryImpl;
use App\Tution\Teacher\ServicesImpl\UserServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $repo = new UserRepositoryImpl();

        $repo->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'admin123',
        ]);

        // $user = \App\Models\User::get();

        $request = new Request();
        $request->query->add([
            'name' => 'adsawd',
            'email' => 'adsawd',
            'password' => 'adsawd',
        ]);
        $service = new UserServiceImpl(new UserRepositoryImpl());

        $this->assertEquals(2, $service->comeOnSampleTest($request));
    }
}
