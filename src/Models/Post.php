<?php

namespace DavideCasiraghi\LaravelCards\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /***************************************************************************/

    protected $fillable = [
        'title', 'body','image','image_alt'
    ];

    /***************************************************************************/


}
