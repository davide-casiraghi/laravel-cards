<?php

namespace DavideCasiraghi\LaravelCards\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelCards\Models\CardTranslation;

class CardTranslationController
{
    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $jumbotronImageId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function create($jumbotronImageId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-jumbotron-images::jumbotronImagesTranslations.create')
                ->with('jumbotronImageId', $jumbotronImageId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $jumbotronImageTranslationId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function edit($jumbotronImageId, $languageCode)
    {
        $jumbotronImageTranslation = CardTranslation::where('jumbotron_image_id', $jumbotronImageId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-jumbotron-images::jumbotronImagesTranslations.edit', compact('jumbotronImageTranslation'))
                    ->with('jumbotronImageId', $jumbotronImageId)
                    ->with('languageCode', $languageCode)
                    ->with('selectedLocaleName', $selectedLocaleName);
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

        // Validate form datas
        /*$validator = Validator::make($request->all(), [
                'text' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }*/

        $jumbotronImageTranslation = new CardTranslation();

        $this->saveOnDb($request, $jumbotronImageTranslation, 'save');

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jumbotronImageTranslationId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jumbotronImageTranslationId)
    {
        /*request()->validate([
            'text' => 'required',
        ]);*/

        $jumbotronImageTranslation = CardTranslation::find($jumbotronImageTranslationId);
        //dd($jumbotronImageTranslation);
        $this->saveOnDb($request, $jumbotronImageTranslation, 'update');

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelCards\Models\CardTranslation  $jumbotronImageTranslation
     * @return void
     */
    public function saveOnDb($request, $jumbotronImageTranslation, $saveOrUpdate)
    {
        $jumbotronImageTranslation->title = $request->get('title');
        $jumbotronImageTranslation->body = $request->get('body');
        $jumbotronImageTranslation->button_text = $request->get('button_text');

        switch ($saveOrUpdate) {
            case 'save':
                $jumbotronImageTranslation->jumbotron_image_id = $request->get('jumbotron_image_id');
                $jumbotronImageTranslation->locale = $request->get('language_code');
                $jumbotronImageTranslation->save();
                break;
            case 'update':
                $jumbotronImageTranslation->update();
                break;
        }
    }

    /***************************************************************************/

    /**
     * Get the language name from language code.
     *
     * @param  string $languageCode
     * @return string
     */
    public function getSelectedLocaleName($languageCode)
    {
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        $ret = $countriesAvailableForTranslations[$languageCode]['name'];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $jumbotronImageTranslationId
     */
    public function destroy($jumbotronImageTranslationId)
    {
        $jumbotronImageTranslation = CardTranslation::find($jumbotronImageTranslationId);
        $jumbotronImageTranslation->delete();

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron Image translation deleted succesfully');
    }
}
