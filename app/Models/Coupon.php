<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'level_id',
        'price',
        'profit_owner',
        'profit_developer',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // التحقق من صلاحية الكوبون
    public function isValid()
    {
        return $this->is_active && ($this->expires_at === null || $this->expires_at->isFuture());
    }

}
