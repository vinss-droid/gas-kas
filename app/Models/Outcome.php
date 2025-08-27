<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = ['description', 'amount', 'spent_at'];
}
