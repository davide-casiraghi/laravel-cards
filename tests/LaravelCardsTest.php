<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use Orchestra\Testbench\TestCase;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;
use DavideCasiraghi\LaravelCards\LaravelCardsServiceProvider;

class LaravelCardsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelCardsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelCards' => LaravelCards::class, // facade called LaravelCards and the name of the facade class
        ];
    }
    
    /** @test */
    public function it_gets_cards_snippet_occurances()
    {
        $text = "Lorem ipsum {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[#345642] text_color=[#212529] container_wrap=[false] #} sid amet.";
        $snippet_occurances = LaravelCards::getCardSnippetOccurrences($text);
        //dd($snippet_occurances);
        
        $this->assertEquals(6, $snippet_occurances[0][2]);
        $this->assertEquals('right', $snippet_occurances[0][4]);
        $this->assertEquals(3, $snippet_occurances[0][6]);
        $this->assertEquals('#345642', $snippet_occurances[0][8]);
        $this->assertEquals('#212529', $snippet_occurances[0][10]);
        $this->assertEquals('false', $snippet_occurances[0][12]);    
    }
    
}
