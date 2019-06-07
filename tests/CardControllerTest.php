<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use DavideCasiraghi\LaravelCards\Models\Card;
use DavideCasiraghi\LaravelCards\Models\CardTranslation;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;

use Illuminate\Foundation\Testing\WithFaker;

class CardControllerTest extends TestCase
{
    use WithFaker;
    
    /***************************************************************/

    /** @test */
    public function the_route_index_can_be_accessed()
    {
        $this->authenticateAsAdmin();
        $this->get('laravel-cards')
            ->assertViewIs('laravel-cards::cards.index')
            ->assertStatus(200);
    }
    
    /** @test */
    public function the_route_create_can_be_accessed()
    {
        $this->authenticateAsAdmin();
        $this->get('laravel-cards/create')
            ->assertViewIs('laravel-cards::cards.create')
            ->assertStatus(200);
    }
    
    /** @test */
    public function the_route_destroy_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
            'img_col_size'  => '3',
            'bkg_color'  => '#FF00FF',
            'text_color'  => '#2365AA',
            'container_wrap'  => '1',
        ]);

        CardTranslation::insert([
            'card_id' => $id,
            'heading' => 'test heading',
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $this->delete('laravel-cards/1')
            ->assertStatus(302);
    }
    
    /** @test */
    public function the_route_update_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'test image name',
            'button_url' => 'test button url',
            'img_col_size'  => '3',
            'bkg_color'  => '#FF00FF',
            'text_color'  => '#2365AA',
            'container_wrap'  => '1',
        ]);

        CardTranslation::insert([
            'card_id' => $id,
            'heading' => 'test heading',
            'title' => 'test title',
            'body' => 'test body',
            'button_text' => 'test button text',
            'locale' => 'en',
        ]);

        $request = new \Illuminate\Http\Request();
        $request->replace([
              'title' => 'test title updated',
              'body' => 'test body updated',
          ]);

        $this->put('laravel-cards/1', [$request, 1])
             ->assertStatus(302);
    }
    
}
