<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profil');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        \Livewire\Livewire::actingAs($user)
            ->test(\App\Livewire\Profil::class)
            ->set('name', 'Updated Name')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $user->refresh();
        $this->assertSame('Updated Name', $user->name);
    }

    public function test_user_can_logout_from_profile(): void
    {
        $user = User::factory()->create();

        \Livewire\Livewire::actingAs($user)
            ->test(\App\Livewire\Profil::class)
            ->call('logout')
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
