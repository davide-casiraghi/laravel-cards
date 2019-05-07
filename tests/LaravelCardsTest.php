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
    public function it_gets_photos_from_db()
    {
        $gallery = new ResponsiveGalleryFactory();
        $dbImageDatas = $gallery->getPhotoDatasFromDb();
        $this->assertStringContainsString($dbImageDatas['DSC_9470.jpg']->description, 'Photo description');
    }
    
}
