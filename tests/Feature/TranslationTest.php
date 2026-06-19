<?php

namespace Tests\Feature;

use App\Models\Translation;
use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_translation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/translations', [
            'key' => 'hello',
            'locale' => 'en',
            'content' => 'Hello World',
            'tags' => ['web']
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                't_key' => 'hello'
            ]);
    }

    public function test_can_search_translation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Translation::factory()->create([
            't_key' => 'hello',
            'locale' => 'en',
            'content' => 'Hello World'
        ]);

        $response = $this->getJson('/api/translations/search?key=hello');

        $response->assertStatus(200)
            ->assertJsonFragment(['t_key' => 'hello']);
    }

    public function test_export_returns_json_structure()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Translation::factory()->create([
            't_key' => 'hello',
            'locale' => 'en',
            'content' => 'Hello'
        ]);

        $response = $this->getJson('/api/translations/export');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'en'
            ]);
    }

    public function test_export_performance()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Translation::factory()->count(5000)->create();

        $start = microtime(true);

        $this->getJson('/api/translations/export');

        $duration = microtime(true) - $start;

        $this->assertLessThan(1.0, $duration);
    }

    public function test_unauthorized_request_fails()
    {
        $response = $this->postJson('/api/translations', []);

        $response->assertStatus(401);
    }

    public function test_translation_service_creates_data()
    {
        $service = new TranslationService();

        $result = $service->create([
            'key' => 'test',
            'locale' => 'en',
            'content' => 'Hello'
        ]);

        $this->assertEquals('test', $result->t_key);
    }
}
