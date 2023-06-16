<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Deal;
use App\Models\UserDeal;
use Illuminate\Support\Facades\Auth;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListDeals()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        Auth::login($user);

        // Create deals and user deals
        $deal1 = Deal::factory()->create();
        $deal2 = Deal::factory()->create();
        $userDeal1 = UserDeal::factory()->create([
            'user_id' => $user->id,
            'deal_id' => $deal1->dealID,
            'rating' => 4,
        ]);
        $userDeal2 = UserDeal::factory()->create([
            'user_id' => $user->id,
            'deal_id' => $deal2->dealID,
            'rating' => 3,
        ]);

        // Make a request to the listDeals endpoint
        $response = $this->actingAs($user)
            ->get('/api/dashboard');

        // Assert the response
        $response->assertStatus(200)
        ->assertJsonFragment([
            'dealID' => $deal1->dealID,
            'rating' => $userDeal1->rating,
        ])
        ->assertJsonFragment([
            'dealID' => $deal2->dealID,
            'rating' => $userDeal2->rating,
        ]);
    }

    public function testAddDeal()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        Auth::login($user);

        // Create a new deal item
        $newDeal = Deal::factory()->create();

        // Make a request to the add endpoint
        $response = $this->actingAs($user)
            ->post('/api/dashboard/', $newDeal->toArray());

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Item added successfully',
                'item' => [
                    'deal_id' => $newDeal->dealID,
                    'user_id' => $user->id,
                ]
            ]);
    }


}
