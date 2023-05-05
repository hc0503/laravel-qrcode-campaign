<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ThemeController extends Controller
{
    /**
     * This switches the theme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeTheme(Request $request)
    {
        $val = $request->session()->get('theme', 'light');
        if ($val === 'light') {
            $request->session()->put('theme', 'dark-layout');
        }
        else {
            $request->session()->put('theme', 'light');
        }
        return $request->session()->get('theme', 'light');
        //return response($request->session()->get('theme', 'light'), 200)->header('Content-Type', 'text/plain');
    }

    /**
     * This Retrieves the actual theme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTheme(Request $request)
    {
        return $request->session()->get('theme', 'light');
        //return response($request->session()->get('theme', 'light'), 200)->header('Content-Type', 'text/plain');
    }

}
