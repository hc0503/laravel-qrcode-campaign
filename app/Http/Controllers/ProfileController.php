<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use File;
use Hash;
use Auth;

class ProfileController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'static'
    ];

    public function __construct(Request $request)
    {
        $this->middleware('owner');
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

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = public_path("/storage/$user->photo"); // get previous image from folder
            if (File::exists($photoPath) && $user->photo != null) { // unlink or remove previous image from folder
                unlink($photoPath);
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->update([
                'photo' => $photoPath
            ]);
        } else {
            if ($request->reset == '1') {
                $photoPath = public_path("/storage/$user->photo"); // get previous image from folder
                if (File::exists($photoPath) && $user->photo != null) { // unlink or remove previous image from folder
                    unlink($photoPath);
                }

                $user->update([
                    'photo' => null
                ]);
            }
        }

        return redirect()
            ->route('profile-edit', $user->id)
            ->with('message', trans('locale.profile.updateSuccess'));
    }

    /**
     * User password change.
     *
     * @param \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(User $user, Request $request)
    {
        $validator = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'retype_password' => 'required|min:6|same:new_password',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            // validation error message
            return back()
                ->withInput()
                ->withErrors(['old_password' => trans('locale.error.notMatchPassword')]);
        }

        $user->update([
            'password' => $request->new_password
        ]);

        return redirect()
            ->route('profile-edit', $user->id)
            ->with('message', trans('locale.profile.updateSuccess'));
    }
}
