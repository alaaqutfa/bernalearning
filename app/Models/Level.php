<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'slug', 'order'];

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}
