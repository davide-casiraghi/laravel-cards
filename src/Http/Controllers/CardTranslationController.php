<?php

namespace DavideCasiraghi\LaravelCards\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DavideCasiraghi\LaravelCards\Models\CardTranslation;

class CardTranslationController extends Controller
{
    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $cardId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function create($cardId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-cards::cardsTranslations.create')
                ->with('cardId', $cardId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $cardTranslationId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function edit($cardId, $languageCode)
    {
        $cardTranslation = CardTranslation::where('card_id', $cardId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('laravel-cards::cardsTranslations.edit', compact('cardTranslation'))
                    ->with('cardId', $cardId)
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

        $cardTranslation = new CardTranslation();

        $this->saveOnDb($request, $cardTranslation, 'save');

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cardTranslationId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cardTranslationId)
    {
        /*request()->validate([
            'text' => 'required',
        ]);*/

        $cardTranslation = CardTranslation::find($cardTranslationId);
        //dd($cardTranslation);
        $this->saveOnDb($request, $cardTranslation, 'update');

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card translation added succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelCards\Models\CardTranslation  $cardTranslation
     * @return void
     */
    public function saveOnDb($request, $cardTranslation, $saveOrUpdate)
    {
        $cardTranslation->title = $request->get('title');
        $cardTranslation->body = $request->get('body');
        $cardTranslation->button_text = $request->get('button_text');

        switch ($saveOrUpdate) {
            case 'save':
                $cardTranslation->card_id = $request->get('card_id');
                $cardTranslation->locale = $request->get('language_code');
                $cardTranslation->save();
                break;
            case 'update':
                $cardTranslation->update();
                break;
        }
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cardTranslationId
     */
    public function destroy($cardTranslationId)
    {
        $cardTranslation = CardTranslation::find($cardTranslationId);
        $cardTranslation->delete();

        return redirect()->route('laravel-cards.index')
                            ->with('success', 'Card translation deleted succesfully');
    }
}
