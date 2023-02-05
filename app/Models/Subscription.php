<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_name',
        'start_at',
        'end_at',
        'amount',
    ];

    protected $casts = [
        'amount' => 'float',
    ];
}
