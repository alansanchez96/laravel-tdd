<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SePuedeObtenerLosVideosDeUnaSerieTest extends TestCase
{
    use RefreshDatabase;

    public function test_Se_puede_obtener_los_videos_de_una_Serie()
    {
        Video::factory()->create();

        $serie = Serie::factory()->create();

        $serie->video()->attach(
            Video::factory(2)->create()->pluck('id')->toArray()
        );

        $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_El_contenido_de_los_videos_es_el_correcto()
    {
        $video = Video::factory()->create();

        $serie = Serie::factory()->create();
        $serie->video()->attach(
            $video->id
        );

        $this->getJson(sprintf('/api/series/%s/videos', $serie->id))
            ->assertExactJson([
                [
                    'id' => $video->id,
                    'image' => $video->image
                ]
            ]);
    }
}
