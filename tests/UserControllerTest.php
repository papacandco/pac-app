<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use InteractsWithSession;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_user_on_dashboard()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->get(route('admin.user.index'));

        $response->assertStatus(200);
        $response->assertSee($user->email);
        $user->delete();
    }
}
