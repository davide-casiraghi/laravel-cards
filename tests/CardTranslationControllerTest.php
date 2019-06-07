<?php

namespace DavideCasiraghi\LaravelCards\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use DavideCasiraghi\LaravelCards\Models\Card;
use DavideCasiraghi\LaravelCards\Models\CardTranslation;
use DavideCasiraghi\LaravelCards\LaravelCardsServiceProvider;

class CardTranslationControllerTest extends TestCase
{
    use WithFaker;
    
    /** @test */
    public function the_route_create_translation_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'image_test_1.jpg',
            'img_alignment' => 'right',
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

        $this->get('laravel-cards-translation/'.$id.'/es/create')
            ->assertViewIs('laravel-cards::cardsTranslations.create')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_edit_translation_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'image_test_1.jpg',
            'img_alignment' => 'right',
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

        CardTranslation::insert([
            'card_id' => $id,
            'heading' => 'test heading spanish',
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish',
            'locale' => 'es',
        ]);

        $this->get('laravel-cards-translation/'.$id.'/es/edit')
            ->assertViewIs('laravel-cards::cardsTranslations.edit')
            ->assertViewHas('cardId')
            ->assertViewHas('languageCode')
            ->assertStatus(200);
    }

    /** @test */
    public function the_route_store_translation_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'image_test_1.jpg',
            'img_alignment' => 'right',
            'button_url' => 'test button url',
            'img_col_size'  => '3',
            'bkg_color'  => '#FF00FF',
            'text_color'  => '#2365AA',
            'container_wrap'  => '1',
        ]);

        $data = [
            'card_id' => $id,
            'language_code' => 'es',
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish',
        ];

        $this
            ->followingRedirects()
            ->post('/laravel-cards-translation', $data);

        $this->assertDatabaseHas('cards', ['image_file_name' => 'image_test_1.jpg']);
    }

    /** @test */
    public function the_route_destroy_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'image_test_1.jpg',
            'img_alignment' => 'right',
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

        CardTranslation::insert([
            'card_id' => $id,
            'heading' => 'test heading spanish',
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish',
            'locale' => 'es',
        ]);

        $this->delete('laravel-cards-translation/'.$id)
            ->assertStatus(302);
    }

    /** @test */
    public function the_route_update_can_be_accessed()
    {
        $id = Card::insertGetId([
            'image_file_name' => 'image_test_1.jpg',
            'img_alignment' => 'right',
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

        $translationId = CardTranslation::insert([
            'card_id' => $id,
            'heading' => 'test heading spanish',
            'title' => 'test title spanish',
            'body' => 'test body spanish',
            'button_text' => 'test button text spanish',
            'locale' => 'es',
        ]);

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'card_translation_id' => $translationId,
            'card_id' => $id,
            'body' => 'test spanish text updated',
            'language_code' => 'es',
         ]);

        $this->put('laravel-cards-translation/'.$translationId, [$request, $translationId])
                 ->assertStatus(302);

        //$this->assertDatabaseHas('quote_translations', ['text' => 'test spanish text updated']);
    }
}
