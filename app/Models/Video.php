<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'description', 'url_video'];

    public function scopeLast($query, int $limit, int $page)
    {
        $offset = ($page - 1) * $limit;

        return $query->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'asc');
    }
}
