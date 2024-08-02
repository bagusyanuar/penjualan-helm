<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'reference_number',
        'sub_total',
        'shipping',
        'total',
        'is_sent',
        'shipping_city',
        'shipping_address',
        'status',
        'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }
}
