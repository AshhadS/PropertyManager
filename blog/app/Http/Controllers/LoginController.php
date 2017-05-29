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

    // public function login(Request $request){
    // 	Debugbar::info($request->all());
    // 	Sentinel::authenticate($request->all());
    //         echo "string";
    //         exit;
    // 	if(Sentinel::check()){

	   //  	return redirect('dashboard');
    // 	}
    // }
    // 

    public function logout(){
        Sentinel::logout();
        return Redirect::to('login');
    }
    public function login(){
    	// Sentinel::logout();
    	return Redirect::to('dashboard');
    }
}
