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
    	Debugbar::info($request->all());
    	Sentinel::authenticate($request->all());
    	if(Sentinel::check()){

	    	return redirect('/');
    	}
    }
    

    public function logout(){
        Sentinel::logout();
        return Redirect::to('login');
    }
}
