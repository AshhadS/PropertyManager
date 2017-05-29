<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Debugbar;
use Redirect;

class RegistrationController extends Controller
{
    public function postRegister(Request $request){
	    $credentials = [
		    'email'    => $request->email,
		    'password' => $request->password,
		];

		$user = Sentinel::registerAndActivate($credentials);
	    return Redirect::to('login');
    }
}
