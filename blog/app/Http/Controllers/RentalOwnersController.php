<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RentalOwner;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
class RentalOwnersController extends Controller
{
    function index() {
    	$rentalowners = RentalOwner::all();
	    return view('rentalowners', [
	        'rentalowners' => $rentalowners,
	    ]);
    }
    
    function data(){
    	$t = DB::table('rentalowners')
    		->leftJoin('countries', 'rentalowners.country', '=', 'countries.id')
	    	->select('rentalownerID', 'firstName', 'lastName', 'dateOfBirth', 'email', 'phoneNumber', 'officeNumber', 'countries.countryName', 'address', 'city', 'comments');
    	return Datatables::of($t)->make(true);

    	// return Datatables::of(rentalowner::query())->make(true);
    }

    function create(Request $request) {
	    $rentalowner = new RentalOwner;
	    $rentalowner->firstName = $request->fname;
	    $rentalowner->lastName = $request->lname;
	    $rentalowner->dateOfBirth = $request->dob;
	    $rentalowner->email = $request->email;
	    $rentalowner->phoneNumber = $request->phone;
	    $rentalowner->officeNumber = $request->officephone;
	    $rentalowner->country = $request->country;
	    $rentalowner->address = $request->address;
	    $rentalowner->city = $request->city;
	    $rentalowner->comments = $request->comments;
	    $rentalowner->companyID = $request->company;
	
	    $rentalowner->save();

	    return $this->index();
    }

    function edit(RentalOwner $rentalowner){
    	// Debugbar::info($rentalowner); 
    	$rentalowner = RentalOwner::find($rentalowner->rentalownerID);
	    return view('rentalowners_edit', [
	        'rentalowner' => $rentalowner,
	    ]);
    }

    function update(Request $request){	
    	$rentalowner = RentalOwner::find($request->rentalownerID);
		$rentalowner->firstName = $request->fname;
	    $rentalowner->lastName = $request->lname;
	    $rentalowner->dateOfBirth = $request->dob;
	    $rentalowner->email = $request->email;
	    $rentalowner->phoneNumber = $request->phone;
	    $rentalowner->officeNumber = $request->officephone;
	    $rentalowner->country = $request->country;
	    $rentalowner->address = $request->address;
	    $rentalowner->city = $request->city;
	    $rentalowner->comments = $request->comments;
	    $rentalowner->companyID = $request->company;

	    $rentalowner->save();
	    return Redirect::to('rentalowners');
    }

    function delete(RentalOwner $rentalowner){
	    $rentalowner->delete();
	    return $this->index();
    }
}
