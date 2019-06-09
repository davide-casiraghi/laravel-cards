<?php

namespace DavideCasiraghi\LaravelCards\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // https://stackoverflow.com/questions/51611015/authuser-return-null-5-6
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    // **********************************************************************

    /**
     * Get the current logged user ID.
     * If user is admin or super admin return 0.
     *
     * @return int $ret
     */
    public function getLoggedUser()
    {
        $user = Auth::user();

        // This is needed to not get error in the queries with: ->when($loggedUser->id, function ($query, $loggedUserId) {
        /*if (! $user) {
            $user = new User();
            $user->name = null;
            $user->group = null;
        }*/

        $ret = $user;

        return $ret;
    }

    // **********************************************************************

    /**
     * Get the current logged user id.
     *
     * @return bool $ret - the current logged user id, if admin or super admin 0
     */
    public function getLoggedAuthorId()
    {
        $user = Auth::user();

        $ret = null;

        if ($user) {
            //disabled for the tests errors -- still to solve the isSuperAdmin()
            //$ret = (! $user->isSuperAdmin() && ! $user->isAdmin()) ? $user->id : 0;
            $ret = (! $user->group == 1 && ! $user->group == 2) ? $user->id : 0;
        }
        /*if ($user) {
            $ret = $user->id;
        }*/

        return $ret;
    }

    // **********************************************************************

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
}
