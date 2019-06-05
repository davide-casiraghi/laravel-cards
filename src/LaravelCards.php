<?php

namespace DavideCasiraghi\LaravelCards;

class LaravelCards
{
    /*protected $cardModelConfig = [];

    public function __construct()
    {
        $this->cardModelConfig = config('laravel-cards.models.card');
    }*/

    /**************************************************************************/

    /**
     *  Provide the card data array (card_title, card_body, card_image).
     *
     *  @param int $cardId
     *  @return  \DavideCasiraghi\LaravelCards\Models\Card    $ret
     **/
    public static function getCard($cardId)
    {
        //$cardModel = $this->cardModelConfig['class'];
        $cardModel = config('laravel-cards.models.card.class');
        $ret = $cardModel::where('id', $cardId)->first();

        return $ret;
    }

    /**************************************************************************/

    /**
     *  Find the card snippet occurances in the text.
     *
     *  @param string $text
     *  @return array $matches
     **/
    public static function getCardSnippetOccurrences($text)
    {
        $re = '/{\#
                \h+card
                \h+(card_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[([^]]*)]
                \h+((?1))=\[([^]]*)]
                \h+((?1))=\[([^]]*)] 
                \h+((?1))=\[([^]]*)]
                \h+((?1))=\[([^]]*)] 
                \h+((?1))=\[([^]]*)] 
                \h*\#}/x';

        if (preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0)) {
            return $matches;
        } else {
            return;
        }
    }

    /**************************************************************************/

    /**
     *  Returns the plugin parameters.
     *
     *  @param array $matches
     *  @return array $ret
     **/
    public static function getSnippetParameters($matches)
    {
        $ret = [];

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];
        //dump($matches);

        $ret['card_id'] = $matches[2];
        $ret['img_col_size_class'] = 'col-md-'.$matches[6];
        $textColSize = 12 - $matches[6];
        $ret['text_col_size_class'] = 'col-md-'.$textColSize;
        $backgroundColor = $matches[8];
        $ret['bkg_color'] = 'background-color: '.$backgroundColor.';';
        $textColor = $matches[10];
        $ret['text_color'] = 'color: '.$textColor.';';
        $containerWrap = $matches[12];
        $ret['container_wrap'] = ($containerWrap == 'true') ? 1 : 0;

        //dd($ret['bkg_color']);
        // Image alignment
        //$ret['img_alignment'] = $matches[4];
        $imageAlignment = $matches[4];

        switch ($imageAlignment) {
             case 'left':
                 $ret['img_col_order_class'] = 'order-md-1';
                 $ret['text_col_order_class'] = 'order-md-2';
                 break;
             case 'right':
                 $ret['img_col_order_class'] = 'order-md-2';
                 $ret['text_col_order_class'] = 'order-md-1';
                 break;
         }

        //dump($ret);

        return $ret;
    }

    /**************************************************************************/

    /**
     *  Prepare the card HTML.
     *
     *  @param array $parameters
     *  @param \DavideCasiraghi\LaravelCards\Models\Card $card
     *
     *  @return string $ret
     **/
    /*public static function prepareCardHtml($parameters, $card)
    {
        if (! is_null($card)) {
            $ret = "<div class='row laravel-card' style='".$parameters['bkg_color'].' '.$parameters['text_color']."'>";
            if ($parameters['container_wrap']) {
                $ret .= "<div class='container'>";
            }
            $ret .= "<div class='text ".$parameters['text_col_size_class'].' my-auto px-4 '.$parameters['text_col_order_class']."'>";
            $ret .= "<h2 class='laravel-card-heading mt-5'>".$card['title'].'</h2>';
            $ret .= "<div class='lead mb-4'>".$card['body'].'</div>';
            $ret .= '</div>';

            if (! empty($card['introimage'])) {
                $ret .= "<div class='image d-none d-md-block ".$parameters['img_col_size_class'].' '.$parameters['img_col_order_class']."'
                        style='
                        background-size: cover;
                        background-image: url(/storage/images/cards_intro_images/".$card['introimage'].");
                        min-height: 400px;
                        background-position: 50% 50%;
                        '>";
                $ret .= '</div>';

                $ret .= "<div class='image col-12 d-md-none ".$parameters['img_col_order_class']."'>";
                $ret .= "<img class='laravel-card-image img-fluid mx-auto' src='/storage/images/cards_intro_images/".$card['introimage']."' alt='".$card['introimage_alt']."'>";
                $ret .= '</div>';
            }


            if ($parameters['container_wrap']) {
                $ret .= '</div>';
            }
            $ret .= '</div>';
        } else {
            $ret = "<div class='alert alert-warning' role='alert'>The card with id ".$parameters['card_id'].' has not been found.</div>';
        }

        return $ret;
    }*/

    /**************************************************************************/

    /**
     *  Return the same text with the cards HTML replaced
     *  where the token strings has been found.
     *
     *  @param string $text
     *  @return string $ret
     **/
    public function replace_card_snippets_with_template($text)
    {
        $matches = self::getCardSnippetOccurrences($text);

        if ($matches) {
            foreach ($matches as $key => $single_gallery_matches) {
                $snippetParameters = self::getSnippetParameters($single_gallery_matches);
                $card = self::getCard($snippetParameters['card_id']);
                $cardParameters = ($card) ? $this->getParametersArray($card) : null;

                $cardView = self::showCard($card, $cardParameters);
                $cardHtml = $cardView->render();

                // Substitute the card html to the token that has been found
                $text = str_replace($parameters['token'], $cardHtml, $text);
            }
        }

        $ret = $text;

        return $ret;
    }

    /***************************************************************************/

    /**
     * Show a Card.
     *
     * @param  \DavideCasiraghi\LaravelCards\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function showCard($card, $cardParameters)
    {
        return view('laravel-cards::show-card', compact('card'))
            ->with('cardParameters', $cardParameters);
    }
    
    /***************************************************************************/

    /**
     * Return an array with the parameters for the show-card.
     * @param  \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage  $jumbotronImage
     * @return array
     */
    public static function getParametersArray($jumbotronImage)
    {
        $ret = [
             'cover_opacity' => 'opacity: '.$jumbotronImage->cover_opacity.';',
             'background_color' => 'background: #'.$jumbotronImage->background_color.';',
             'image' => 'background-image:url(/storage/images/jumbotron_images/'.$jumbotronImage->image_file_name.');',
             'text_horizontal_alignment' => 'text-align: '.$jumbotronImage->text_horizontal_alignment.';',
         ];
        $ret['white_moon'] = ($jumbotronImage->white_moon == 1) ? ' moon-curve ' : '';
        $ret['scroll_down_arrow'] = ($jumbotronImage->scroll_down_arrow == 1) ? "<div class='scroll-arrow white'><span>SCROLL DOWN</span><img src='/vendor/laravel-jumbotron-images/assets/images/angle-down-regular.svg'></div>" : '';

        /* Parallax - The element is defined with stellar plugin like: <section class="parallax" data-stellar-background-ratio="0.5" ><span>Summer</span></section>*/
        $ret['parallax'] = ($jumbotronImage->parallax == 1) ? ' parallax' : '';
        $ret['parallax_ratio'] = ($jumbotronImage->parallax == 1) ? "data-stellar-background-ratio='0.5'" : '';

        /* Text Width */
        if ($jumbotronImage->text_width != 100) {
            switch ($jumbotronImage->text_horizontal_alignment) {
                case 'left':	// Left
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%;';
                break;
                case 'center': // Center
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; margin: auto;';
                break;
                case 'right': // Right
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; float: right;';
                break;
            }
        }

        return $ret;
    }

}
