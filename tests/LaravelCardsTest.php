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
        $text = "lorem ipsum {# card post_id=[6] img_alignment=[right] img_col_size=[3] bkg_color=[transparent|#34564] text_color=[#212529] container_wrap=[false] #} lorem ipsum";
        $snippet_occurances = LaravelCards::getCardSnippetOccurrences($text);
        dd($snippet_occurances);
        //$gallery = new ResponsiveGalleryFactory();
        //$dbImageDatas = $gallery->getPhotoDatasFromDb();
        $this->assertStringContainsString($snippet_occurances, 'aa');
    }
    
}
