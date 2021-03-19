<?php

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Login test
     *
     * @return void
     */
    public function test_login(): void
    {
        $this->userService->saveUserData([
            'name' => 'John Doe',
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $apiToken = $this->userService->issueApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'Password1234'
        ]);

        $this->assertNotEmpty($apiToken);

        $this->expectException(InvalidArgumentException::class);

        $apiToken = $this->userService->issueApiToken([
            'email' => 'asa0abbad+test@gmail.com',
            'password' => 'wrongpassword'
        ]);

        $apiToken = $this->userService->issueApiToken([
            'password' => 'wrongpassword'
        ]);
    }
}
