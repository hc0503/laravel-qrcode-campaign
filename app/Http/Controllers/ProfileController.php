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

    /**
     * User profile edit.
     *
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editProfile(User $user)
    {
        $breadcrumbs = [
            ['link'=>"",'name'=>trans('locale.profile.title')], ['name'=>trans('locale.profile.edit')]
        ];

        return view('/pages/profiles/edit', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'user' => $user
        ]);
    }

    /**
     * User profile update.
     *
     * @param \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(User $user, Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:190',
            'surname' => 'required|string|max:190',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user = $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('profile-edit', $user->id)
            ->with('message', trans('locale.campaign.saveSuccess'));
    }
}
