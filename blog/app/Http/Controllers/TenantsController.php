<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tenant;
use App\Model\Country;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
class TenantsController extends Controller
{
    function index() {
    	$tenants = Tenant::all();
    	$countries = Country::all();
	    return view('tenants', [
	        'tenants' => $tenants,
	        'countries' => $countries,
	    ]);
    }
    
    function data(){
    	$t = DB::table('tenants')
    		->leftJoin('countries', 'tenants.country', '=', 'countries.id')
	    	->select('tenantsID', 'firstName', 'lastName', 'dateOfBirth', 'email', 'phoneNumber', 'officeNumber', 'countries.countryName', 'address', 'city', 'comments', 'companyID');
    	return Datatables::of($t)->make(true);

    	// return Datatables::of(Tenant::query())->make(true);
    }

    function create(Request $request) {
	    $tenant = new Tenant;
	    $tenant->firstName = $request->fname;
	    $tenant->lastName = $request->lname;
	    $tenant->dateOfBirth = $request->dob;
	    $tenant->email = $request->email;
	    $tenant->phoneNumber = $request->phone;
	    $tenant->officeNumber = $request->officephone;
	    $tenant->country = $request->country;
	    $tenant->address = $request->address;
	    $tenant->city = $request->city;
	    $tenant->comments = $request->comments;
	    $tenant->companyID = $request->company;
	
	    $tenant->save();

	    return $this->index();
    }

    function edit(Tenant $tenant){
    	// Debugbar::info($tenant); 
    	$tenant = Tenant::find($tenant->tenantsID);
    	$countries = Country::all();
	    return view('tenants_edit', [
	        'countries' => $countries,
	        'tenant' => $tenant,

	    ]);
    }

    function update(Request $request){	
    	$tenant = Tenant::find($request->tenantsID);
		$tenant->firstName = $request->fname;
	    $tenant->lastName = $request->lname;
	    $tenant->dateOfBirth = $request->dob;
	    $tenant->email = $request->email;
	    $tenant->phoneNumber = $request->phone;
	    $tenant->officeNumber = $request->officephone;
	    $tenant->country = $request->country;
	    $tenant->address = $request->address;
	    $tenant->city = $request->city;
	    $tenant->comments = $request->comments;
	    $tenant->companyID = $request->company;

	    $tenant->save();
	    return Redirect::to('tenants');
    }

    function delete(Tenant $tenant){
	    $tenant->delete();
	    return $this->index();
    }
}
