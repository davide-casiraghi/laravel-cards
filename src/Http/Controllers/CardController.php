<?php

namespace DavideCasiraghi\LaravelCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManagerStatic as Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use DavideCasiraghi\LaravelCards\Models\Card;

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
                    ->with('jumbotronHeightArray', $this->getJumbotronHeightArray())
                    ->with('buttonColorArray', $this->getButtonColorArray())
                    ->with('coverOpacityArray', $this->getCoverOpacityArray())
                    ->with('textWidthArray', $this->getTextWidthArray())
                    ->with('textVerticalAlignmentArray', $this->getTextVerticalAlignmentArray())
                    ->with('textHorizontalAlignmentArray', $this->getTextHorizontalAlignmentArray())
                    ->with('textShadowArray', $this->getTextShadowArray());
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
        $jumbotronImage = new Card();

        // Set the default language to edit the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $jumbotronImage);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image added succesfully');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function show($jumbotronImageId = null)
    {
        $jumbotronImage = Card::find($jumbotronImageId);

        return view('laravel-cards::cards.show', compact('jumbotronImage'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function edit($jumbotronImageId = null)
    {
        $jumbotronImage = Card::find($jumbotronImageId);

        return view('laravel-cards::cards.edit', compact('jumbotronImage'))
                    ->with('jumbotronHeightArray', $this->getJumbotronHeightArray())
                    ->with('buttonColorArray', $this->getButtonColorArray())
                    ->with('coverOpacityArray', $this->getCoverOpacityArray())
                    ->with('textWidthArray', $this->getTextWidthArray())
                    ->with('textVerticalAlignmentArray', $this->getTextVerticalAlignmentArray())
                    ->with('textHorizontalAlignmentArray', $this->getTextHorizontalAlignmentArray())
                    ->with('textShadowArray', $this->getTextShadowArray());
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jumbotronImageId)
    {
        $jumbotronImage = Card::find($jumbotronImageId);

        // Set the default language to update the quote in English
        App::setLocale('en');

        $this->saveOnDb($request, $jumbotronImage);

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image updated succesfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $jumbotronImageId
     * @return \Illuminate\Http\Response
     */
    public function destroy($jumbotronImageId)
    {
        $jumbotronImage = Card::find($jumbotronImageId);
        $jumbotronImage->delete();

        return redirect()->route('jumbotron-images.index')
                            ->with('success', 'Jumbotron image deleted succesfully');
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \DavideCasiraghi\LaravelCards\Models\Card  $jumbotronImage
     * @return void
     */
    public function saveOnDb($request, $jumbotronImage)
    {
        $jumbotronImage->translateOrNew('en')->title = $request->get('title');
        $jumbotronImage->translateOrNew('en')->body = $request->get('body');
        $jumbotronImage->translateOrNew('en')->button_text = $request->get('button_text');
        $jumbotronImage->button_url = $request->get('button_url');
        $jumbotronImage->jumbotron_height = $request->get('jumbotron_height');
        $jumbotronImage->cover_opacity = $request->get('cover_opacity');
        $jumbotronImage->scroll_down_arrow = ($request->scroll_down_arrow == 'on') ? 1 : 0;
        $jumbotronImage->background_color = $request->get('background_color');
        $jumbotronImage->button_color = $request->get('button_color');
        $jumbotronImage->parallax = ($request->parallax == 'on') ? 1 : 0;
        $jumbotronImage->white_moon = ($request->white_moon == 'on') ? 1 : 0;
        $jumbotronImage->text_width = $request->get('text_width');
        $jumbotronImage->text_vertical_alignment = $request->get('text_vertical_alignment');
        $jumbotronImage->text_horizontal_alignment = $request->get('text_horizontal_alignment');
        $jumbotronImage->text_shadow = $request->get('text_shadow');

        // Jumbotron image upload
        if ($request->file('image_file_name')) {
            $imageFile = $request->file('image_file_name');
            $imageName = $imageFile->hashName();
            $imageSubdir = 'cards';
            $imageWidth = '1067';
            $thumbWidth = '690';

            $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
            $jumbotronImage->image_file_name = $imageName;
        } else {
            $jumbotronImage->image_file_name = $request->image_file_name;
        }

        $jumbotronImage->save();
    }

    /***************************************************************************/

    /**
     * Upload image on server.
     * $imageFile - the file to upload
     * $imageSubdir is the subdir in /storage/app/public/images/..
     *
     * @param  array $imageFile
     * @param  string $imageName
     * @param  string $imageSubdir
     * @param  string $imageWidth
     * @param  string $thumbWidth
     * @return void
     */
    public static function uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth)
    {

        // Create dir if not exist (in /storage/app/public/images/..)
        if (! \Storage::disk('public')->has('images/'.$imageSubdir.'/')) {
            \Storage::disk('public')->makeDirectory('images/'.$imageSubdir.'/');
        }

        $destinationPath = 'app/public/images/'.$imageSubdir.'/';

        // Resize the image with Intervention - http://image.intervention.io/api/resize
        // -  resize and store the image to a width of 300 and constrain aspect ratio (auto height)
        // - save file as jpg with medium quality
        $image = Image::make($imageFile->getRealPath())
                                ->resize($imageWidth, null,
                                    function ($constraint) {
                                        $constraint->aspectRatio();
                                    })
                                ->save(storage_path($destinationPath.$imageName), 75);

        // Create the thumb
        $image->resize($thumbWidth, null,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->save(storage_path($destinationPath.'thumb_'.$imageName), 75);
    }

    /***************************************************************************/

    /**
     * Return and array with the jumbotron possible height options.
     *
     * @return array
     */
    public static function getJumbotronHeightArray()
    {
        $ret = [
             'is-small' => 'Small',
             'is-medium' => 'Medium',
             'is-large' => 'Large',
             'is-halfheight' => 'Halfheight',
             'is-fullheight' => 'Fullheight',
         ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and array with the jumbotron possible opacity options.
     *
     * @return array
     */
    public static function getCoverOpacityArray()
    {
        $ret = [
             '0' => 'none',
             '0.1' => '10%',
             '0.2' => '20%',
             '0.3' => '30%',
             '0.4' => '40%',
             '0.5' => '50%',
         ];

        return $ret;
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

    /***************************************************************************/

    /**
     * Return and array with the text possible width options.
     *
     * @return array
     */
    public static function getTextWidthArray()
    {
        $ret = [
             '100' => '100%',
             '90' => '90%',
             '80' => '80%',
             '70' => '70%',
             '60' => '60%',
             '50' => '50%',
             '40' => '40%',
             '30' => '30%',
             '20' => '20%',
         ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and array with the text possible vertical alignment options.
     *
     * @return array
     */
    public static function getTextVerticalAlignmentArray()
    {
        $ret = [
             'align-items: flex-start;' => 'Top',
             'align-items: center;' => 'Center',
             'align-items: flex-end;' => 'Bottom',
         ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and array with the text possible horizontal alignment options.
     *
     * @return array
     */
    public static function getTextHorizontalAlignmentArray()
    {
        $ret = [
             'left' => 'Left',
             'center' => 'Center',
             'right' => 'Right',
         ];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and array with the text possible shadow options.
     *
     * @return array
     */
    public static function getTextShadowArray()
    {
        $ret = [
             '' => 'None',
             'text-shadow: 2px 1px 5px rgba(0,0,0,0.3);' => 'Small',
             'text-shadow: 2px 1px 1px rgba(0,0,0,0.3);' => 'Small Blurred',
             'text-shadow: 3px 2px 2px rgba(0,0,0,0.3);' => 'High',
         ];

        return $ret;
    }
}
