<?php

namespace Tests\Feature\Api\V1;

use App\Models\Movie;
use App\Models\Screening;
use App\Models\User;
use Tests\TestCase;

class ScreeningTest extends TestCase
{
    public function test_get_screenings_successfully(): void
    {
        $response = $this->get(route('screenings.index'));

        $response->assertOk();
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_store_screening_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->post(route('screenings.store'), [
            'movie_id' => $movie->id,
            'starts_at' => now()->addDay(),
            'available_seats' => 100,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('screenings', [
            'movie_id' => $movie->id,
            'starts_at' => now()->addDay(),
            'available_seats' => 100,
        ]);
    }

    public function test_store_screening_unauthorized(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->post(route('screenings.store'), [
            'movie_id' => $movie->id,
            'starts_at' => now()->addDay(),
            'available_seats' => 100,
        ]);

        $response->assertForbidden();
    }

    public function test_show_screening_successfully(): void
    {
        $screening = Screening::factory()->create();

        $response = $this->get(route('screenings.show', $screening));

        $response->assertOk();
        $this->assertEquals($screening->id, $response->json('data.id'));
    }

    public function test_update_screening_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $screening = Screening::factory()->create();

        $response = $this->actingAs($user)->put(route('screenings.update', $screening), [
            'starts_at' => now()->addDays(2),
            'available_seats' => 200,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('screenings', [
            'id' => $screening->id,
            'starts_at' => now()->addDays(2),
            'available_seats' => 200,
        ]);
    }

    public function test_update_screening_unauthorized(): void
    {
        $user = User::factory()->create();
        $screening = Screening::factory()->create();

        $response = $this->actingAs($user)->put(route('screenings.update', $screening), [
            'starts_at' => now()->addDays(2),
            'available_seats' => 200,
        ]);

        $response->assertForbidden();
    }

    public function test_delete_screening_successfully(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);
        $screening = Screening::factory()->create();

        $response = $this->actingAs($user)->delete(route('screenings.destroy', $screening));

        $response->assertOk();
        $this->assertDatabaseMissing('screenings', [
            'id' => $screening->id,
        ]);
    }

    public function test_delete_screening_unauthorized(): void
    {
        $user = User::factory()->create();
        $screening = Screening::factory()->create();

        $response = $this->actingAs($user)->delete(route('screenings.destroy', $screening));

        $response->assertForbidden();
    }
}
