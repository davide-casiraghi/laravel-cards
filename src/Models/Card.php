<?php

namespace DavideCasiraghi\LaravelCards\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    use Translatable;

    public $translatedAttributes = ['heading', 'title', 'body', 'button_text', 'image_alt'];
    protected $fillable = [
        'image_file_name',
        'img_alignment',
        'img_col_size',
        'bkg_color',
        'text_color',
        'button_url',
        'button_color',
        'button_corners',
        'button_icon',
        'container_wrap',
    ];
}
