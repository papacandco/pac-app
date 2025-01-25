<?php

namespace Tests\Feature;

use App\Models\Newsletter;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Support\Str;
use Tests\TestCase;

class NewletterControllerTest extends TestCase
{
    use InteractsWithSession;

    /**
     * The test email
     *
     * @var string
     */
    private $email;

    /**
     * On test setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (is_null($this->email)) {
            $this->email = 'guy@mail.com';
        }
    }

    /**
     * Test add email to newsletter
     *
     * @return void
     */
    public function test_create_a_newsletter_entry()
    {
        $field_name = Str::random(6);

        $response = $this
            ->withSession(['newsletter_email_field' => $field_name])
            ->post(route('support.newsletter'), [
                $field_name => $this->email,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_new_letter_on_dashboard()
    {
        $this->markTestSkipped('working progress');

        $response = $this
            ->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->get(route('admin.newsletter.index'));

        $response->assertSee($this->email);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_newsletter_email()
    {
        $this->markTestSkipped('working progress');

        $newsletter = Newsletter::first();

        if (is_null($newsletter)) {
            $newsletter = Newsletter::create([
                'email' => 'clc' . uniqid() . '@email.com',
            ]);
        }

        $response = $this
            ->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->post(route('admin.newsletter.delete', ['newsletter' => $newsletter->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
