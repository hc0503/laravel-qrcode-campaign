<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // page config setting array
    protected $pageConfigs = [
        'bodyClass' => "bg-full-screen-image",
        'blankPage' => true
    ];

    /**
     * Locked page when user islocked is 1
     */
    public function lockedPage()
    {
        return view('/pages/lockedpage', [
            'pageConfigs' => $this->pageConfigs
        ]);
    }
}
