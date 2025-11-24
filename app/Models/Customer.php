<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controller\CustomerController;


class Customer extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'address',
    ];
}
