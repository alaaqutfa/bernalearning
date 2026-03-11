<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'title', 'description', 'bunny_video_id', 'duration',
        'width',
        'height',
        'available_resolutions',
        'thumbnail_file_name',
        'status',
        'storage_size',
        'views',
        'uploaded_at', 'order'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
