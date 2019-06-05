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
                \h+(card_id)=\[([^]]*)]
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

        return $ret;
    }

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
     * @param  \DavideCasiraghi\LaravelJumbotronImages\Models\Card  $card
     * @return array
     */
    public static function getParametersArray($card)
    {
        $ret = [
             'img_col_size_class' => 'col-md-'.$card->img_col_size,
             'text_col_size_class' => 'col-md-'.(12-$card->img_col_size),
             'bkg_color' => 'background-color: '.$card->bkg_color.';',
             'text_color' => 'color: '.$card->text_color.';',
             'container_wrap' => ($card->container_wrap == 'true') ? 1 : 0,
         ];
         
        switch ($card->img_alignment) {
             case 'left':
                 $ret['img_col_order_class'] = 'order-md-1';
                 $ret['text_col_order_class'] = 'order-md-2';
                 break;
             case 'right':
                 $ret['img_col_order_class'] = 'order-md-2';
                 $ret['text_col_order_class'] = 'order-md-1';
                 break;
         }
        
        return $ret;
    }

}
