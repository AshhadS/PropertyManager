<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Roles;
use App\Model\User;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;
class UsersController extends Controller
{
    function index() {
        $roles = Roles::all();
        $user = User::all();

        return view('settings.users', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }
    
    function data(){
        $t = DB::table('users')
            // ->leftJoin('roles', 'units.PropertiesID', '=', 'properties.PropertiesID')
            ->select('id', 'first_name', 'last_name', 'email', 'last_login', 'created_at');        
        return Datatables::of($t)->make(true);
    }


    function create(Request $request) {
        $user = Sentinel::registerAndActivate($request->all());
        $role = Sentinel::findRoleById($request->roles);
        $role->users()->attach($user);
        $user->companyID = Sentinel::getUser()->companyID;
        $user->save();


        return Redirect::to('/admin');
    }

    function edit(User $user){
        $user = Sentinel::findById($user->id);
        $roles = Roles::all();

        
        return view('user_edit', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    function update(Request $request){
        $user = Sentinel::findById($request->pk);
        if($request->name == 'roles'){
            $role = Sentinel::findRoleByID($request->roles);
            $role->users()->attach($user);
        }else{
            $details = array($request->name => $request->value);
            $updated_user = Sentinel::update($user, $details);           
        }

        $user->save();
        return $user;
    }

    function delete(User $user){
        $user->delete();
        return Redirect::to('/admin');
    }
}
