<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Controllers\Controller;
use App\DataTransferObjects\VideosPreview;
use App\Http\Requests\ListadoDeVideosRequest;
use App\Http\Resources\VideoResource;

class VideoController extends Controller
{
    public function getAllVideos(ListadoDeVideosRequest $request)
    {
        $videos = Video::Last(
            $request->getLimit(),
            $request->getPage()
        )->get();

        return VideoResource::collection($videos);
    }

    public function getVideo(Video $video)
    {
        return $video;
    }
}
