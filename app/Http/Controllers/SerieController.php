<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SerieResource;
use App\Models\Serie;

class SerieController extends Controller
{
    public function getAllSeries()
    {
        return SerieResource::collection(Serie::all());
    }
}
