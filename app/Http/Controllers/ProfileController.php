<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'static'
    ];

    public function __construct()
    {

    }

    /**
     * User profile show.
     *
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showProfile(User $user)
    {
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.profile.title')], ['name'=>trans('locale.profile.view')]
        ];

        return view('/pages/profiles/view', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user
        ]);
    }
}
