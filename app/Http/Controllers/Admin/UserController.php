<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    // Default pageConfig
    protected $pageConfigs = [
        'navbarType' => 'sticky',
        'footerType' => 'static',
        'mainLayoutType' => 'horizontal',
        'horizontalMenuType' => 'floating',
        'theme' => 'dark',
        'navbarColor' => 'bg-primary'
    ];

    public function __construct() {
        // $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); //Get all users
        $breadcrumbs = [
            ['link'=>"/admin/users", 'name'=>trans('locale.user.title')], ['name'=>trans('locale.user.list')]
        ];

        return view('/pages/admin/users/index', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(); //Get all roles
        $breadcrumbs = [
            ['link'=>"/admin/users",'name'=>trans('locale.user.title')], ['name'=>trans('locale.user.create')]
        ];
        
        return view('/pages/admin/users/create', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'surname'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $user = User::create($request->all()); //Retrieving only the email and password data

        $roles = $request->roles; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {
            $user->assignRole($roles); //Assigning role to user
        }        
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('message', trans('locale.user.message.save'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all(); //Get all roles

        $breadcrumbs = [
            ['link'=>"/admin/users",'name'=>trans('locale.user.title')], ['name'=>trans('locale.user.edit')]
        ];
        
        return view('/pages/admin/users/edit', [
            'pageConfigs' => $this->pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'surname'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($request->all());
        $roles = $request->roles;

        if (isset($roles)) {
            $user->syncRoles($roles);
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        
        return redirect()->route('users.index')
            ->with('message', trans('locale.user.message.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('message', trans('locale.user.message.delete'));
    }

    /**
     * Set user lock, the default user has 0 as islocked field.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setLock(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $user->islocked = $request->state;
        $user->save();

        return new JsonResponse(null, 204);
    }
}
