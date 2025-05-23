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

        $response = $this->actingAs($user)
            ->get('/profile');

        $response->assertInertia(fn ($assert) => $assert
            ->component('Profile/Edit')
            ->has('status', 'success')
        );
        dd($response->dump());

    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test Name',
                'email' => 'test@example.com',
            ]);

        $response->assertInertia(fn ($assert) => $assert
            ->component('Profile/Edit')
            ->has('status', 'success')
            ->has('message')
        );

        $user->refresh();
        $this->assertEquals('Test Name', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        dd($response->dump());

    }

    public function test_email_verification_status_is_unchanged_when_email_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test Name',
                'email' => $user->email,
            ]);

        $response->assertInertia(fn ($assert) => $assert
            ->component('Profile/Edit')
            ->has('status', 'success')
        );
        dd($response->dump());

    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
        $this->assertNull($user->fresh());
        dd($response->dump());

    }


}
