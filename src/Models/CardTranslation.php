<?php

namespace DavideCasiraghi\LaravelCards\Models;

use Illuminate\Database\Eloquent\Model;

class CardTranslation extends Model
{
    protected $table = 'card_translations';

    public $timestamps = false;
    protected $fillable = [
        'card_id',
        'heading',
        'title',
        'body',
        'button_text',
        'locale',
    ];
}
