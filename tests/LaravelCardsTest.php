<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use DavideCasiraghi\LaravelCards\Models\Card;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;

class LaravelCardsTest extends TestCase
{
    /** @test */
    public function it_gets_multiple_cards_snippet_occurances()
    {
        $text = 'Lorem ipsum {# card card_id=[6] #} sid amet.
                 Lorem ipsum {# card card_id=[8] #}.
        ';
        $matches = LaravelCards::getCardSnippetOccurrences($text);
        //dd($matches);

        $this->assertEquals($matches[0][2], 6);
        $this->assertEquals($matches[1][2], 8);
    }

    /** @test */
    public function it_gets_no_cards_snippet_occurances()
    {
        $text = 'Lorem ipsum  sid amet. ';
        $matches = LaravelCards::getCardSnippetOccurrences($text);

        $this->assertSame($matches, null);
    }

    /** @test */
    public function it_gets_the_parameter_array()
    {
        $text = 'Lorem ipsum {# card card_id=[6] #} sid amet.
                 Lorem ipsum {# card card_id=[8] #}.
        ';
        $matches = LaravelCards::getCardSnippetOccurrences($text);
        $parameters = LaravelCards::getParametersArray($matches[0]);
        //dd($parameters);

        $this->assertEquals($parameters['bkg_color'], 'background-color: #345642;');
        $this->assertEquals($parameters['img_col_size_class'], 'col-md-3');
    }

    /** @test */
    public function it_gets_the_card_data()
    {
        $card = factory(Card::class)->create([
            'id' => 6,
            'title' => 'test title',
        ]);

        $cardData = LaravelCards::getCard($card['id']);
        $this->assertEquals($cardData['title'], 'test title');
    }

    /** @test */
    public function it_replace_card_snippets_with_template()
    {
        $card_1 = factory(Card::class)->create([
            'id' => 6,
            'title' => 'test title',
        ]);

        $card_2 = factory(Card::class)->create([
            'id' => 8,
            'title' => 'test title 2',
        ]);

        $text = 'Lorem ipsum {# card card_id=[6] #} sid amet.
                 Lorem ipsum {# card card_id=[8] #}.
        ';

        $text = LaravelCards::replace_card_snippets_with_template($text);
        $text = trim(preg_replace('/\s+/', ' ', $text));

        $this->assertContains('<div class="row laravel-card" style="background-color: #345642; color: #212529;"> <div class="text col-md-9 my-auto px-4 order-md-1"> <h2 class="laravel-card-heading mt-5">'.$card_1['title'].'</h2> <div class="lead mb-4">'.$card_1['body'].'</div> </div> </div>', $text);
        $this->assertContains('<div class="row laravel-card" style="background-color: #FF0044; color: #f34532;"> <div class="container"> <div class="text col-md-10 my-auto px-4 order-md-2"> <h2 class="laravel-card-heading mt-5">'.$card_2['title'].'</h2> <div class="lead mb-4">'.$card_2['body'].'</div> </div> </div> </div>', $text);
    }

    /** @test */
    public function it_replace_a_card_string_with_alert_if_card_not_found()
    {
        $text = 'Lorem ipsum {# card card_id=[1] #}.';

        $text = LaravelCards::replace_card_snippets_with_template($text);
        $text = trim(preg_replace('/\s+/', ' ', $text));

        $this->assertContains('<div class="alert alert-warning" role="alert">The card with id 2 has not been found.</div>', $text);
    }
}
