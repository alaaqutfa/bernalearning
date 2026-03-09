<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'title', 'description', 'bunny_video_id', 'order'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
