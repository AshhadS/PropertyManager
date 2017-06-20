<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tenant;
use App\Model\Country;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;
class TenantsController extends Controller
{
    function index() {
    	
    	$countries = Country::all();
	    return view('tenants', [
	        'countries' => $countries,
	    ]);
    }
    
    function data(){
    	$t = DB::table('tenants')
    		->leftJoin('countries', 'tenants.country', '=', 'countries.id')
	    	->select('tenantsID', 'firstName', 'lastName', 'dateOfBirth', 'email', 'phoneNumber', 'officeNumber', 'countries.countryName', 'address', 'city', 'comments', 'companyID');
	    	// ->where('tenants.companyID', Sentinel::getUser()->companyID);
    	return Datatables::of($t)->make(true);

    	// return Datatables::of(Tenant::query())->make(true);
    }

    function create(Request $request) {
	    $tenant = new Tenant;
	    $tenant->firstName = $request->fname;
	    $tenant->lastName = $request->lname;
	    $tenant->email = $request->email;
	    $tenant->phoneNumber = $request->phone;
	    $tenant->officeNumber = $request->officephone;
	    $tenant->country = $request->country;
	    $tenant->address = $request->address;
	    $tenant->city = $request->city;
	    $tenant->comments = $request->comments;
	    $tenant->companyID = Sentinel::getUser()->companyID;
	    $tenant->documentID = 4;

	    if($request->dob)
		    $tenant->dateOfBirth = date_create_from_format("j/m/Y", $request->dob)->format('Y-m-d');

	    $tenant->save();

	    return Redirect::to('tenants');
    }

    function edit(Tenant $tenant){
    	// Debugbar::info($tenant); 
    	$tenant = Tenant::find($tenant->tenantsID);
    	$countries = Country::all();
    	$documentmaster = DocumentMaster::all();
    	$attachments = Attachment::where('documentAutoID', $tenant->tenantsID)->where('documentID', 4)->get();

    	$countryName = (isset($tenant->country)) ? Country::find($tenant->country)->countryName : '';
    	
	    return view('tenants_edit', [
	        'countries' => $countries,
	        'tenant' => $tenant,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'countryName' => $countryName,

	    ]);
    }

    function update(Request $request){	
    	$tenant = Tenant::find($request->tenantsID);
		$tenant->firstName = $request->fname;
	    $tenant->lastName = $request->lname;
	    $tenant->email = $request->email;
	    $tenant->phoneNumber = $request->phone;
	    $tenant->officeNumber = $request->officephone;
	    $tenant->country = $request->country;
	    $tenant->address = $request->address;
	    $tenant->city = $request->city;
	    $tenant->comments = $request->comments;
	    $tenant->companyID = $request->companyID;
	    
	    if($request->dob)
		    $tenant->dateOfBirth = date_create_from_format("j/m/Y", $request->dob)->format('Y-m-d');
	
	    $tenant->save();
	    return Redirect::to('tenants');
    }

    function delete(Tenant $tenant){
	    $tenant->delete();
	    return Redirect::to('tenants');
    }
}
