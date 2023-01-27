<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Serie;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SePuedeObtenerUnListadoDeSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_Se_puede_obtener_un_listado_de_series()
    {
        Serie::factory(2)->create();

        $this->getJson('/api/series')
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_Preview_de_una_Serie_tiene_el_formato_correcto()
    {
        $id = 4123;
        $title = 'Title Serie';
        $image = 'Image.jpg';
        $resume = 'Resume Serie';

        Serie::factory(1)->create([
            'id' => $id,
            'title' => $title,
            'image' => $image,
            'resume' => $resume
        ]);

        $this->getJson('/api/series')
            ->assertExactJson([
                [
                    'id' => $id,
                    'title' => $title,
                    'image' => $image,
                    'resume' => $resume
                ]
            ]);
    }
}
