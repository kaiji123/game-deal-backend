<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals'; // Specify the table name

    protected $fillable = [
        'dealID',
        'storeID',
        'gameID',
        'thumb',
        'title',
        'salePrice',
        'normalPrice',
        'isOnSale',
        'savings',
        'metacriticScore',
        'steamRatingText',
        'steamRatingPercent',
        'steamRatingCount',
        'steamAppID',
        'releaseDate',
        'lastChange',
        'dealRating',
        'internalName',
        'metacriticLink'
    ];

    public function userDeals()
    {
        return $this->hasMany(UserDeal::class);
    }
}
