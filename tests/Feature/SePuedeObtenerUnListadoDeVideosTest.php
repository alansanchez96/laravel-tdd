<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Video;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class SePuedeObtenerUnListadoDeVideosTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_obtener_un_listado_de_videos()
    {
        $this->withoutExceptionHandling();

        Video::factory(2)->create();

        $this->getJson('/api/videos')
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_el_preview_de_un_video_tiene_id_y_image()
    {
        $this->withoutExceptionHandling();

        $idRandom = 4123;
        $imageRandom = 'https://random-image.com/';

        Video::factory()->create([
            'id' => $idRandom,
            'image' => $imageRandom
        ]);

        $this->getJson('/api/videos')
            ->assertExactJson([
                [
                    'id' => $idRandom,
                    'image' => $imageRandom
                ]
            ]);
    }

    public function test_los_videos_estan_ordenados_de_antiguo_a_reciente()
    {
        $this->withoutExceptionHandling();

        $videoDeUnMes = Video::factory()->create([
            'created_at' => Carbon::now()->subDays(30)
        ]);

        $videoDeAyer = Video::factory()->create([
            'created_at' => Carbon::yesterday()
        ]);

        $videoDeHoy = Video::factory()->create([
            'created_at' => Carbon::now()
        ]);

        $this->getJson('/api/videos')
            ->assertJsonPath('0.id', $videoDeUnMes->id)
            ->assertJsonPath('1.id', $videoDeAyer->id)
            ->assertJsonPath('2.id', $videoDeHoy->id);
    }

    public function test_se_puede_limitar_el_numero_de_videos_a_obtener()
    {
        Video::factory(4)->create();

        $this->getJson('/api/videos?limit=3')
            ->assertJsonCount(3);
    }


    public function test_por_defecto_tira_30_videos()
    {
        Video::factory(40)->create();

        $this->getJson('/api/videos')
            ->assertJsonCount(30);
    }

    public function providerLimitesInvalidos(): array
    {
        return [
            'El limite minimo es de 1 videos' => [4, '-2'],
            'El limite maximo es de 50 videos' => [60, '51'],
            'El limite no puede ser un string' => [5, 'LimitString']
        ];
    }

    /**
     * @dataProvider providerLimitesInvalidos
     */
    public function test_Devuelve_un_Unprocessable_Entity_422_si_hay_un_error_en_el_limite(
        int $cantidadDeVideos,
        string $limite
    ) {
        Video::factory($cantidadDeVideos)->create();

        $this->getJson(sprintf('/api/videos?limit=%s', $limite))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_se_pueden_paginar_los_videos()
    {
        Video::factory(9)->create();

        $this->getJson('/api/videos?limit=5&page=2')
            ->assertJsonCount(4);
    }

    public function test_La_pagina_por_defecto_es_la_primera()
    {
        Video::factory(9)->create();

        $this->getJson('/api/videos=limit=5')
            ->assertJsonCount(5);
    }

    public function test_Devuelve_0_videos_si_la_pagina_no_existe()
    {
        Video::factory(9)->create();

        $this->getJSon('/api/videos?limit=5&page=20')
            ->assertJsonCount(0);
    }

    public function provider_Paginas_invalidas(): array
    {
        return [
            'El page no puede ser un string' => ['unStringError'],
            'El page limite no puede ser menor a 1' => ['-3']
        ];
    }

    /**
     * @dataProvider provider_Paginas_invalidas
     */
    public function test_Devuelve_Unprocessable_Entity_422_si_hay_un_error_en_el_page($page)
    {
        $this->getJson(sprintf('/api/videos?page=%s', $page))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
