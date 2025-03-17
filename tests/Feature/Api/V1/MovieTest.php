<?php

namespace Tests\Feature\Api\V1;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_movies_successfully(): void
    {
        $response = $this->get(route('movies.index'));

        $response->assertOk();
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_store_movie_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $payload = [
            'title' => 'Test Movie',
            'description' => 'Test Description',
            'age_limit' => 18,
            'language' => 'en',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response = $this->actingAs($user)->post(route('movies.store'), $payload);

        $response->assertOk();
        $this->assertDatabaseHas('movies', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'age_limit' => $payload['age_limit'],
            'language' => $payload['language'],
        ]);
    }

    public function test_store_movie_unauthorized(): void
    {
        $user = User::factory()->create();
        $payload = [
            'title' => 'Test Movie',
            'description' => 'Test Description',
            'age_limit' => 18,
            'language' => 'en',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response = $this->actingAs($user)->post(route('movies.store'), $payload);

        $response->assertForbidden();
        $this->assertDatabaseMissing('movies', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'age_limit' => $payload['age_limit'],
            'language' => $payload['language'],
        ]);
    }

    public function test_show_movie_successfully(): void
    {
        $movie = Movie::factory()->create();

        $response = $this->get(route('movies.show', $movie));

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $movie->id,
            'title' => $movie->title,
            'description' => $movie->description,
            'age_limit' => $movie->age_limit,
            'language' => $movie->language,
        ]);
    }

    public function test_update_movie_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $movie = Movie::factory()->create();

        $payload = [
            'title' => 'Updated Movie',
            'description' => 'Updated Description',
            'age_limit' => 21,
            'language' => 'fr',
        ];

        $response = $this->actingAs($user)->patch(route('movies.update', $movie), $payload);

        $response->assertOk();
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => $payload['title'],
            'description' => $payload['description'],
            'age_limit' => $payload['age_limit'],
            'language' => $payload['language'],
        ]);
    }

    public function test_update_movie_unauthorized(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $payload = [
            'title' => 'Updated Movie',
            'description' => 'Updated Description',
            'age_limit' => 21,
            'language' => 'fr',
        ];

        $response = $this->actingAs($user)->patch(route('movies.update', $movie), $payload);

        $response->assertForbidden();
        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
            'title' => $payload['title'],
            'description' => $payload['description'],
            'age_limit' => $payload['age_limit'],
            'language' => $payload['language'],
        ]);
    }

    public function test_delete_movie_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $movie = Movie::factory()->hasScreenings(3)->create();

        $response = $this->actingAs($user)->delete(route('movies.destroy', $movie));

        $response->assertOk();
        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);
        $this->assertDatabaseMissing('screenings', [
            'movie_id' => $movie->id,
        ]);
    }

    public function test_delete_movie_unauthorized(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->hasScreenings(3)->create();

        $response = $this->actingAs($user)->delete(route('movies.destroy', $movie));

        $response->assertForbidden();
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
        ]);
        $this->assertDatabaseHas('screenings', [
            'movie_id' => $movie->id,
        ]);
    }
}
