<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\User;
use App\Models\UserDeal;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserDealFactory extends Factory
{
    protected $model = UserDeal::class;

    public function definition()
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->create();

        return [
            'user_id' => $user->id,
            'deal_id' => $deal->dealID, // Assuming 'dealID' is the primary key column in the 'deals' table
        ];
    }
}

