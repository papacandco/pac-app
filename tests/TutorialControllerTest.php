<?php

namespace Tests\Feature;

use App\Models\Technologie;
use App\Models\Tutorial;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TutorialControllerTest extends TestCase
{
    use InteractsWithSession;

    /**
     * Factory
     *
     * @var Faker
     */
    private $faker;

    /**
     * The technologie instance
     *
     * @var Technologie
     */
    private $technologie;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = $this->getFaker();

        $this->technologie = Technologie::first();

        if (is_null($this->technologie)) {
            $this->technologie = factory(Technologie::class)->create();
        }
    }

    /**
     * Test create tutorial.
     *
     * @return void
     */
    public function test_create_tutorial_on_dashboard()
    {
        $this->markTestSkipped('working progress');

        $response = $this->post(route('admin.tutorial.create'), [
            'title' => $this->faker->text(30),
            'content' => $this->faker->text(1000),
            'slug' => $this->faker->slug,
            'color' => $this->faker->hexColor,
            'video' => 'https://www.youtube.com/embed/1sqg63imHx0',
            'description' => $this->faker->text,
            'cover' => UploadedFile::fake()->create('javascript.png'),
            'technologie_id' => $this->technologie->id,
            'published' => 1,
            'published_at' => now(),
        ]);

        $response->assertStatus(302);
    }

    /**
     * Test show tutorial.
     *
     * @return void
     */
    public function test_show_tutorial_on_dashboard()
    {
        $this->markTestSkipped('working progress');

        $tutorial = Tutorial::first();

        if (is_null($tutorial)) {
            $tutorial = factory(Tutorial::class)->create([
                'technologie_id' => $this->technologie->id,
            ]);
        }

        $response = $this
            ->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->get(route('admin.tutorial.single', ['tutorial' => $tutorial->id]));

        $response->assertStatus(200);
    }

    /**
     * Test update tutorial.
     *
     * @return void
     */
    public function test_update_tutorial_on_dashboard()
    {
        $this->markTestSkipped('working progress');

        $tutorial = Tutorial::first();

        if (is_null($tutorial)) {
            $tutorial = factory(Tutorial::class)->create([
                'technologie_id' => $this->technologie->id,
            ]);
        }

        $data = [
            'title' => $this->faker->text(30),
            'content' => $this->faker->text(1000),
            'slug' => $this->faker->slug,
            'color' => $this->faker->hexColor,
            'video' => 'https://www.youtube.com/embed/1sqg63imHx0',
            'description' => $this->faker->text,
            'cover' => UploadedFile::fake()->create('javascript.png'),
            'published' => 1,
            'published_at' => now(),
        ];

        $response = $this->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->post(route('admin.tutorial.update', ['id' => $tutorial->id]), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /**
     * Test delete tutorial.
     *
     * @return void
     */
    public function test_delete_tutorial_on_dashboard()
    {
        $this->markTestSkipped('working progress');

        $tutorial = Tutorial::first();

        if (is_null($tutorial)) {
            $tutorial = factory(Tutorial::class)->create([
                'technologie_id' => $this->technologie->id,
            ]);
        }

        $response = $this
            ->withSession(['auth' => true, 'auth_name' => 'papac'])
            ->post(route('admin.tutorial.delete', ['tutorial' => $tutorial->id]), [
                'password' => 'password',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
