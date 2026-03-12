<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function subscribedLevels()
    {
        return $this->belongsToMany(Level::class, 'coupons')
            ->wherePivot('is_active', true)->with('videos');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'coupons')
            ->withPivot(['code', 'is_active', 'price', 'profit_owner', 'profit_developer', 'created_at'])
            ->withTimestamps();
    }

    public function watchedVideos()
    {
        return $this->hasMany(BunnyView::class)->where('completed', true);
    }

    // مجموع أرباح المطور من هذا المستخدم
    public function getTotalDeveloperProfitAttribute()
    {
        return $this->coupons->sum('profit_developer');
    }

    // مجموع أرباح بيرنا من هذا المستخدم
    public function getTotalOwnerProfitAttribute()
    {
        return $this->coupons->sum('profit_owner');
    }
}
