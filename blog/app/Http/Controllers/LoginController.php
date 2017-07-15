<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Debugbar;
use Redirect;

class LoginController extends Controller
{
	public function show(){
		return view('customauth.login');
	}

    public function login(Request $request){
    	Sentinel::authenticate($request->all());
    	if(Sentinel::check()){

            return redirect('/');
        }else{
            $request->session()->flash('alert-success', 'Username or Password incorrect.');
	    	return redirect('/login');
        }
    }
    

    public function logout(){
        Sentinel::logout();
        return Redirect::to('login');
    }
}
