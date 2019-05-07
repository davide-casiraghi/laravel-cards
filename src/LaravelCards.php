<?php

namespace DavideCasiraghi\LaravelCards;

class LaravelCards
{
    /************************************************************************/

    /**
     *  Find the card snippet occurances in the text.
     *  @param array $text     The text where to find the card snippets
     *  @return array $ret     The matches
     **/
    public function getCardSnippetOccurrences($text)
    {
        $re = '/{\#
                \h+card
                \h+(src|column_width|gutter)=\[([^]]*)]
                \h+((?1))=\[([^]]*)]
                \h+((?1))=\[([^]]*)]
                \h*\#}/x';

        if (preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0)) {
            return $matches;
        } else {
            return;
        }
    }
    
    
}
