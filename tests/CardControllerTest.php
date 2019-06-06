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
    public function it_displays_the_cards_index_page()
    {
        $this->authenticateAsAdmin();
        $this->get('cards')->dump();
            //->assertViewIs('laravel-cards::cards.index')
            //->assertStatus(200);
    }
    
}
