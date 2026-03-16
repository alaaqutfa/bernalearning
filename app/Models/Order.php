<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'level_id', 'amount', 'status',
        'payment_link', 'payment_link_created_at', 'receipt_image', 'notes'
    ];

    protected $casts = [
        'payment_link_created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }
}
