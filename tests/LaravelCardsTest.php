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
    public function it_gets_multiple_cards_snippet_occurances()
    {
        $text = "Lorem ipsum {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[#345642] text_color=[#212529] container_wrap=[false] #} sid amet.
                 Lorem ipsum {# card post_id=[8] img_alignment=[left] img_col_size=[2] bkg_color=[#FF0044] text_color=[#f34532] container_wrap=[true] #}.
        ";
        $matches = LaravelCards::getCardSnippetOccurrences($text);
        //dd($matches);
        
        $this->assertEquals(6, $matches[0][2]);
        $this->assertEquals('right', $matches[0][4]);
        $this->assertEquals(3, $matches[0][6]);
        $this->assertEquals('#345642', $matches[0][8]);
        $this->assertEquals('#212529', $matches[0][10]);
        $this->assertEquals('false', $matches[0][12]);  
        
        $this->assertEquals(8, $matches[1][2]);
        $this->assertEquals('left', $matches[1][4]);
        $this->assertEquals(2, $matches[1][6]);
        $this->assertEquals('#FF0044', $matches[1][8]);
        $this->assertEquals('#f34532', $matches[1][10]);
        $this->assertEquals('true', $matches[1][12]); 
    }
    
    /** @test */
    public function it_gets_the_parameter_array()
    {
        $text = "Lorem ipsum {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[#345642] text_color=[#212529] container_wrap=[false] #} sid amet.
                 Lorem ipsum {# card post_id=[8] img_alignment=[left] img_col_size=[2] bkg_color=[#FF0044] text_color=[#f34532] container_wrap=[true] #}.
        ";
        $matches = LaravelCards::getCardSnippetOccurrences($text);
        $parameters = LaravelCards::getParameters($matches[0]);
        
        //dd($parameters);
        
        $this->assertEquals('background-color: #345642;', $parameters['bkg_color']);
        $this->assertEquals('col-md-3', $parameters['img_col_size_class']);
        
        
    }
    
    
    
}
