<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccessController extends Controller
{
    public function index(){

        // Breadcrumbs  
         $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => " Extra Components"], ['name' => "Access Controller"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
            
          return view('pages.access-control',['pageConfigs'=>$pageConfigs,'breadcrumbs'=>$breadcrumbs]);
        }
    
        public function roles($role){
        if(Auth::user()){
            // check group is empty
          $roles = DB::table('roles')->count();
          if($roles == null){
            //if group empty add two group and assign permission
            $editor = Role::create(['name' => 'Editor']);
            $permissionEditor = Permission::create(['name' => 'create articles']);
            $editor->givePermissionTo($permissionEditor);
  
            $admin = Role::create(['name' => 'Admin']);
            $permission = Permission::create(['name' => 'approve articles']);
            $admin->givePermissionTo($permission,$permissionEditor);
          } 
          //if 
            $user = Auth::user();
            if($role === 'admin'){
              $user->removeRole('Editor');
              $user->assignRole('Admin');
            }
            else{
              $user->removeRole('Admin');
              $user->assignRole('Editor'); 
           }
        }
        return redirect()->back();
        }
        // function home
        public function home(){
          return view('pages.dashboard-analytics');
        }
}
