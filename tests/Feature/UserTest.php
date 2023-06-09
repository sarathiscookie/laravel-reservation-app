<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        
        $this->authUser();
    }

    public function test_fetch_all_users(): void
    {
        $response = $this->getJson(route('users.index'));

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

        $response = $this->postJson(route('users.store', [
            'role_id' => $user->role_id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'contact_number' => $user->contact_number,
            'country_id' => $user->country_id,
            'state_id' => $user->state_id,
            'city_id' => $user->city_id,
            'address' => $user->address,
            'postcode' => $user->postcode
        ]))
        ->assertCreated();

        $this->assertEquals($user->name, $response->json()['user']['name']);

        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);
    }

    public function test_delete_user(): void
    {
        $this->deleteJson(route('users.destroy', $this->user->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id
        ]);
    }

    public function test_update_user(): void
    {
        $this->patchJson(route('users.update', $this->user->id), [
            'contact_number' => '0000000000',
            'address' => 'Island'
        ])
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'contact_number' => '0000000000'
        ]);
    }
}
