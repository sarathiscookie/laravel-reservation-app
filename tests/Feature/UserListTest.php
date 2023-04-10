<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CitySeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_fetch_all_users(): void
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
    }

    public function test_fetch_single_user(): void
    {
        $response = $this->getJson(route('users.show', $this->user->id))
                        ->assertOk();

        $this->assertGreaterThan(2, $response->json()['role_id']);
    }

    public function test_store_user(): void
    {
        $user = User::factory()->make();

        $response = $this->postJson('/api/users', [
            'role_id' => $user->role_id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'contact_number' => $user->contact_number,
            'country_id' => $user->country_id,
            'state_id' => $user->state_id,
            'city_id' => $user->city_id,
            'address' => $user->address
        ])
        ->assertCreated();

        $this->assertEquals($user->name, $response->json()['user']['name']);
    }
}
