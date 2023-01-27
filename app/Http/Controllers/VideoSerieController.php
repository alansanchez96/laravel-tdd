<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Serie;
use Illuminate\Http\Request;

class VideoSerieController extends Controller
{
    public function getRelationshipVideoSerie(Serie $serie)
    {
        return VideoResource::collection($serie->video);
    }
}
