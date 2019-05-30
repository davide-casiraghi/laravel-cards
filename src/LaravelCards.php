<?php

namespace DavideCasiraghi\LaravelCards;

class LaravelCards
{
    /*protected $postModelConfig = [];

    public function __construct()
    {
        $this->postModelConfig = config('laravel-cards.models.post');
    }*/

    /**************************************************************************/

    /**
     *  Provide the post data array (post_title, post_body, post_image).
     *
     *  @param int $postId
     *  @return  \DavideCasiraghi\LaravelCards\Models\Post    $ret
     **/
    public static function getPost($postId)
    {
        //$postModel = $this->postModelConfig['class'];
        $postModel = config('laravel-cards.models.post.class');
        $ret = $postModel::where('id', $postId)->first();

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
                \h+(post_id|img_alignment|img_col_size|bkg_color|text_color|container_wrap)=\[([^]]*)]
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
    public static function getParameters($matches)
    {
        $ret = [];

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];
        //dump($matches);

        $ret['post_id'] = $matches[2];
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
     *  @param \DavideCasiraghi\LaravelCards\Models\Post $post
     *
     *  @return string $ret
     **/
    public static function prepareCardHtml($parameters, $post)
    {
        if (! is_null($post)) {
            $ret = "<div class='row featurette' style='".$parameters['bkg_color'].' '.$parameters['text_color']."'>";
            if ($parameters['container_wrap']) {
                $ret .= "<div class='container'>";
            }
            $ret .= "<div class='text ".$parameters['text_col_size_class'].' my-auto px-4 '.$parameters['text_col_order_class']."'>";
            $ret .= "<h2 class='featurette-heading mt-5'>".$post['title'].'</h2>';
            $ret .= "<div class='lead mb-4'>".$post['body'].'</div>';
            $ret .= '</div>';

            if (! empty($post['introimage'])) {
                $ret .= "<div class='image d-none d-md-block ".$parameters['img_col_size_class'].' '.$parameters['img_col_order_class']."'
                        style='
                        background-size: cover; 
                        background-image: url(/storage/images/posts_intro_images/UQC5mBkk41BNs3mkhMzTysTs3LKu4SpaWFk1uGpQ.jpeg);
                        min-height: 400px;
                        background-position: 50% 50%;
                        '>";
                $ret .= '</div>';

                $ret .= "<div class='image col-12 d-md-none ".$parameters['img_col_order_class']."'>";
                $ret .= "<img class='featurette-image img-fluid mx-auto' src='/storage/images/posts_intro_images/".$post['introimage']."' alt='".$post['introimage_alt']."'>";
                $ret .= '</div>';
            }

            /*$ret .= "<div class='image col-12 ".$parameters['img_col_order_class']."'>";
                $ret .= "<img class='featurette-image img-fluid mx-auto' src='/storage/images/posts_intro_images/".$post['introimage']."' alt='".$post['introimage_alt']."'>";
            $ret .= '</div>';*/

            if ($parameters['container_wrap']) {
                $ret .= '</div>';
            }
            $ret .= '</div>';
        } else {
            $ret = "<div class='alert alert-warning' role='alert'>The post with id ".$parameters['post_id'].' has not been found.</div>';
        }

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
                $parameters = self::getParameters($single_gallery_matches);
                $post = self::getPost($parameters['post_id']);
                $cardHtml = self::prepareCardHtml($parameters, $post);

                // Substitute the card html to the token that has been found
                $text = str_replace($parameters['token'], $cardHtml, $text);
            }
        }

        $ret = $text;

        return $ret;
    }
}
