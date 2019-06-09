<?php

namespace DavideCasiraghi\LaravelCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use DavideCasiraghi\LaravelCards\Models\Card;
use Intervention\Image\ImageManagerStatic as Image;
use DavideCasiraghi\LaravelCards\Facades\LaravelCards;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelFormPartials\Facades\LaravelFormPartials;

class CardController
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchKeywords = $request->input('keywords');
        //$searchCategory = $request->input('category_id');
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        if ($searchKeywords) {
            $cards = Card::
                                select('card_translations.card_id AS id', 'title', 'body', 'button_text', 'image_file_name', 'button_url', 'locale')
                                ->join('card_translations', 'cards.id', '=', 'card_translations.card_id')
                                ->orderBy('title')
                                ->where('title', 'like', '%'.$searchKeywords.'%')
                                ->where('locale', 'en')
                                ->paginate(20);
        } else {
            $cards = Card::
                                select('card_translations.card_id AS id', 'title', 'body', 'button_text', 'image_file_name', 'button_url', 'locale')
                                ->join('card_translations', 'cards.id', '=', 'card_translations.card_id')
                                ->where('locale', 'en')
                                ->orderBy('title')
                                ->paginate(20);
        }

        return view('laravel-cards::cards.index', compact('cards'))
                             ->with('i', (request()->input('page', 1) - 1) * 20)
                             ->with('searchKeywords', $searchKeywords)
                             ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laravel-cards::cards.create')
                    ->with('buttonColorArray', $this->getButtonColorArray());
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card = new Card();

        // Set the default language to edit the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $card);

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card image added succesfully');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int $cardId
     * @return \Illuminate\Http\Response
     */
    public function show($cardId = null)
    {
        //$card = Card::find($cardId);
        $card = LaravelCards::getCard($cardId);
        $cardParameters = ($card) ? (LaravelCards::getParametersArray($card)) : null;

        return view('laravel-cards::cards.show', compact('card'))
                ->with('cardParameters', $cardParameters);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $cardId
     * @return \Illuminate\Http\Response
     */
    public function edit($cardId = null)
    {
        $card = Card::find($cardId);

        return view('laravel-cards::cards.edit', compact('card'))
                    ->with('buttonColorArray', $this->getButtonColorArray());
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cardId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cardId)
    {
        $card = Card::find($cardId);

        // Set the default language to update the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $card);

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card image updated succesfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cardId
     * @return \Illuminate\Http\Response
     */
    public function destroy($cardId)
    {
        $card = Card::find($cardId);
        $card->delete();

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card image deleted succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelCards\Models\Card  $card
     * @return void
     */
    public function saveOnDb($request, $card)
    {
        $card->translateOrNew('en')->heading = $request->get('heading');
        $card->translateOrNew('en')->title = $request->get('title');
        $card->translateOrNew('en')->body = $request->get('body');
        $card->translateOrNew('en')->button_text = $request->get('button_text');
        $card->translateOrNew('en')->image_alt = $request->get('image_alt');

        $card->img_alignment = $request->get('img_alignment');
        $card->img_col_size = $request->get('img_col_size');
        $card->img_col_size = $request->get('img_col_size');
        $card->bkg_color = $request->get('bkg_color');
        $card->button_url = $request->get('button_url');
        $card->button_color = $request->get('button_color');
        $card->button_corners = $request->get('button_corners');
        $card->button_icon = $request->get('button_icon');
        $card->container_wrap = ($request->container_wrap == 'on') ? 1 : 0;

        // Card image upload
        $imageSubdir = 'cards';
        $imageWidth = '1067';
        $thumbWidth = '690';
        $card->image_file_name = LaravelFormPartials::uploadImageOnServer($request->file('image_file_name'), $request->image_file_name, $imageSubdir, $imageWidth, $thumbWidth);

        $card->save();
    }

    /***************************************************************************/

    /**
     * Return and array with the button possible color options.
     *
     * @return array
     */
    public static function getButtonColorArray()
    {
        $ret = [
             'press-red' => 'Red',
             'press-pink' => 'Pink',
             'press-purple' => 'Purple',
             'press-deeppurple' => 'Deep purple',
             'press-indigo' => 'Indigo',
             'press-blue' => 'Blue',
             'press-lightblue' => 'Light blue',
             'press-cyan' => 'Cyan',
             'press-teal' => 'Teal',
             'press-green' => 'Green',
             'press-lightgreen' => 'Light green',
             'press-lime' => 'Lime',
             'press-yellow' => 'Yellow',
             'press-amber' => 'Amber',
             'press-orange' => 'Orange',
             'press-deeporange' => 'Deeporange',
             'press-brown' => 'Brown',
             'press-grey' => 'Grey',
             'press-bluegrey' => 'Blue grey',
             'press-black' => 'Black',
         ];

        return $ret;
    }
}
