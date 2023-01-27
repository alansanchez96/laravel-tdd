<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Video;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SePuedeObtenerUnVideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_obtener_un_video_por_su_id()
    {
        $video = Video::factory()->create();

        $response = $this->get(
            sprintf(
                '/api/video/%s',
                $video->id
            )
        );

        $response->assertExactJson([
            'id' => $video->id,
            'title' => $video->title,
            'description' => $video->description,
            'url_video' => $video->url_video,
        ]);
    }
}
