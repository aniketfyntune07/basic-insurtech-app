<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'policy_number',
        'customer_name',
        'type',
        'premium_amount',
        'start_date',
        'end_date',
        'status',
    ];
}
