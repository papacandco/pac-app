<?php

namespace Tests\Feature;

use App\Models\Configuration;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use InteractsWithSession;

    private $configuration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configuration = Configuration::first();

        if (is_null($this->configuration)) {
            $this->configuration = factory(Configuration::class)->create();
        }
    }

    protected function tearDown(): void
    {
        if (! is_null($this->configuration)) {
            $this->configuration->delete();
        }
    }

    public function test_login_admin_success()
    {
        $this->markTestSkipped('working progress');

        $response = $this->post(route('admin.login'), [
            'email' => $this->configuration->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('admin.index'));
    }

    public function test_login_admin_fail()
    {
        $this->markTestSkipped('working progress');

        $email = $this->configuration->email;

        $this->configuration->name = 'clc admin';
        $this->configuration->email = 'test@gmail.com';
        $this->configuration->password = bcrypt('other_password');
        $this->configuration->alert = 0;
        $this->configuration->touch();

        $response = $this->post(route('admin.login'), [
            'email' => $email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.login'));
    }
}
