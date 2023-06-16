<?php

namespace Database\Factories;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition()
    {
        return [
            'dealID' => $this->faker->unique()->sentence(),
            'storeID' => $this->faker->randomNumber(),
            'gameID' => $this->faker->randomNumber(),
            'thumb' => $this->faker->imageUrl(),
            'title' => $this->faker->sentence(),
            'salePrice' => $this->faker->randomFloat(2, 0, 100),
            'normalPrice' => $this->faker->randomFloat(2, 0, 100),
            'isOnSale' => $this->faker->boolean(),
            'savings' => $this->faker->randomNumber(),
            'metacriticScore' => $this->faker->randomNumber(),
            'steamRatingText' => $this->faker->sentence(),
            'steamRatingPercent' => $this->faker->randomNumber(),
            'steamRatingCount' => $this->faker->randomNumber(),
            'steamAppID' => $this->faker->randomNumber(),
            'releaseDate' => $this->faker->randomNumber(),
            'lastChange' => $this->faker->randomNumber(),
            'dealRating' => $this->faker->randomNumber(),
            'internalName' => $this->faker->word(),
            'metacriticLink' => $this->faker->url(),
        ];
    }
}
