<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeal extends Model
{
    protected $table = 'user_deals'; // Specify the table name

    protected $fillable = [
        'user_id',
        'deal_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
