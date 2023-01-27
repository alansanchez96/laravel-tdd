<?php

namespace App\DataTransferObjects;

use App\Models\Video;
use JsonSerializable;

class VideosPreview implements JsonSerializable
{
    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function jsonSerialize(): array
    {
        
    }
}
