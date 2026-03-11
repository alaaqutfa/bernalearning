<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BunnyView extends Model
{
    protected $fillable = [
        'bunny_video_id', 'video_id', 'user_id', 'ip_address',
        'country', 'watch_time', 'completed', 'bandwidth_used', 'viewed_at',
    ];

    protected $casts = [
        'viewed_at'      => 'datetime',
        'completed'      => 'boolean',
        'watch_time'     => 'integer',
        'bandwidth_used' => 'decimal:2',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * حساب تكلفة عرض الفيديو (حسب استخدام bandwidth)
     * Bunny.net: ~$0.01 per GB
     */
    public function getBandwidthCostAttribute()
    {
        $costPerGB = 0.01; // $0.01 لكل GB
        return $this->bandwidth_used * $costPerGB;
    }

    /**
     * إجمالي تكلفة المشاهدات لشهر معين
     */
    public static function getTotalBandwidthCost($year, $month)
    {
        $totalGB = self::whereYear('viewed_at', $year)
            ->whereMonth('viewed_at', $month)
            ->sum('bandwidth_used');

        return $totalGB * 0.01;
    }
}
