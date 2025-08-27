<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'week_id',
        'payment_method_id',
        'amount',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function week()
    {
        return $this->belongsTo(Week::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
