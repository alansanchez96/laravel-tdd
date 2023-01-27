<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serie extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'image', 'resume'];

    public function video()
    {
        return $this->belongsToMany(Video::class);
    }
}
