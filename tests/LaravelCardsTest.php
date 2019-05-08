<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use DavideCasiraghi\LaravelCards\Facades\LaravelCards;
use DavideCasiraghi\LaravelCards\LaravelCardsServiceProvider;
use DavideCasiraghi\LaravelCards\Models\Post;

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
        
        $this->assertEquals($matches[0][2], 6);
        $this->assertEquals($matches[0][4], 'right');
        $this->assertEquals($matches[0][6], 3);
        $this->assertEquals($matches[0][8], '#345642');
        $this->assertEquals($matches[0][10], '#212529');
        $this->assertEquals($matches[0][12], 'false');  
        
        $this->assertEquals($matches[1][2], 8);
        $this->assertEquals($matches[1][4], 'left');
        $this->assertEquals($matches[1][6], 2);
        $this->assertEquals($matches[1][8], '#FF0044');
        $this->assertEquals($matches[1][10], '#f34532');
        $this->assertEquals($matches[1][12], 'true'); 
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
        
        $this->assertEquals($parameters['bkg_color'],'background-color: #345642;');
        $this->assertEquals($parameters['img_col_size_class'], 'col-md-3');
    }
    
    /** @test */
    public function it_gets_the_post_data()
    {
        $post = factory(Post::class)->create([
            'id' => 6,
            'title' => 'test title',
        ]);
            
        $postData = LaravelCards::getPost($post['id']);
        $this->assertEquals($postData['title'], 'test title');
    }
    
    /** @test */
    public function it_prepare_the_card_html()
    {
        $parameters = [
            "token" => "{# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[#345642] text_color=[#212529] container_wrap=[false] #}",
            "post_id" => "6",
            "img_col_size_class" => "col-md-3",
            "text_col_size_class" => "col-md-9",
            "bkg_color" => "background-color: #345642;",
            "text_color" => "color: #212529;",
            "container_wrap" => 0,
            "img_col_order_class" => "order-md-2",
            "text_col_order_class" => "order-md-1",
        ];
        
        $post = factory(Post::class)->create([
            'id' => 6,
            'title' => 'test title',
        ]);
            
        $postData = LaravelCards::getPost($post['id']);
        $cardHtml = LaravelCards::prepareCardHtml($parameters, $postData);
        
        $this->assertEquals($cardHtml, "<div class='row featurette' style='background-color: #345642;color: #212529;'><div class='text col-md-9 my-auto px-4 order-md-1'><h2 class='featurette-heading mt-5'></h2><div class='lead mb-4'></div></div><div class='image col-md-3 order-md-2'></div></div>");
    }
    
}
