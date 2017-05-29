<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Tenant;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;

class JobCardsController extends Controller
{
    function index() {
    	$jobcards = JobCard::all();
    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
    	
    	// Debugbar::info($tenants);
	    return view('jobcards', [
	        'jobcards' => $jobcards,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	    ]);
    }
    
    function data(){
    	$t = DB::table('jobcard')
    		->leftJoin('tenants', 'jobcard.tenantsID', '=', 'tenants.tenantsID')
    		->leftJoin('units', 'jobcard.unitID', '=', 'units.unitID')
    		->leftJoin('properties', 'jobcard.PropertiesID', '=', 'properties.PropertiesID')
    		->select('jobcard.jobcardID', 'jobcard.subject', 'jobcard.description', 'properties.pPropertyName', 'units.unitNumber' ,'jobcardStatusID', 'tenants.firstName');
    	return Datatables::of($t)->make(true);

    }

    function create(Request $request) {
	    $jobcard = new JobCard;
	    $jobcard->subject = $request->subject;
	    $jobcard->description = $request->description;
	    $jobcard->jobcardStatusID = $request->jobcardStatusID;
	    $jobcard->PropertiesID = $request->PropertiesID;
	    $jobcard->rentalOwnerID = $request->rentalOwnerID;
	    $jobcard->tenantsID = $request->tenantsID;
	    $jobcard->unitID =$request->unitID;
	
	    $jobcard->save();

	    return Redirect::to('jobcards');
    }

    function edit(JobCard $jobcard){
    	// Debugbar::info($jobcard); 
    	$jobcard = JobCard::find($jobcard->jobcardID);
    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
	    return view('jobcards_edit', [
	        'jobcard' => $jobcard,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	    ]);
    }

    function update(Request $request){	
    	$jobcard = JobCard::find($request->jobcardID);
    	$jobcard->subject = $request->subject;
	    $jobcard->description = $request->description;
	    $jobcard->jobcardStatusID = $request->jobcardStatusID;
	    $jobcard->PropertiesID = $request->PropertiesID;
	    $jobcard->rentalOwnerID = $request->rentalOwnerID;
	    $jobcard->tenantsID = $request->tenantsID;
	    $jobcard->unitID =$request->unitID;

	    $jobcard->save();
	    return Redirect::to('jobcards');
    }

    function delete(JobCard $jobcard){
	    $jobcard->delete();
	    return $this->index();
    }
}

