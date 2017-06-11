<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Tenant;
use App\Model\Attachment;
use App\Model\DocumentMaster;
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
    	$jobcardstatuss = JobCardStatus::all();
    	
    	// Debugbar::info($tenants);
	    return view('jobcards', [
	        'jobcards' => $jobcards,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'jobcardstatuss' => $jobcardstatuss,
	    ]);
    }
    
    function data(){
    	$t = DB::table('jobcard')
    		->leftJoin('tenants', 'jobcard.tenantsID', '=', 'tenants.tenantsID')
    		->leftJoin('units', 'jobcard.unitID', '=', 'units.unitID')
    		->leftJoin('properties', 'jobcard.PropertiesID', '=', 'properties.PropertiesID')
    		->leftJoin('jobcardstatus', 'jobcard.jobcardStatusID', '=', 'jobcardstatus.jobcardStatusID')
    		->leftJoin('users', 'jobcard.createdByUserID', '=', 'users.id')
    		->select('jobcard.jobcardID', 'jobcard.subject', 'jobcard.description', 'properties.pPropertyName', 'jobcardstatus.statusDescription', 'units.unitNumber' , 'tenants.firstName', 'jobcard.createdDateTime', 'users.first_name');
    		// Debugbar::info($t);
    	return Datatables::of($t)->make(true);

    }

    function create(Request $request) {
	    $jobcard = new JobCard;
	    // dd(Sentinel::getUser()->companyID);
	    $jobcard->subject = $request->subject;
	    $jobcard->description = $request->description;
	    $jobcard->jobcardStatusID = $request->jobcardStatusID;
	    ($request->PropertiesID != 0) ? $jobcard->PropertiesID = $request->PropertiesID : false; // do not save if 0 was selected
	    $jobcard->rentalOwnerID = $request->rentalOwnerID;
	    $jobcard->tenantsID = $request->tenantsID;
	    $jobcard->unitID =$request->unitID;
	    $jobcard->companyID = Sentinel::getUser()->companyID;
	    $jobcard->documentID = 5;

	
	    $jobcard->save();

	    return Redirect::to('jobcards');
    }

    function edit(JobCard $jobcard){
    	$jobcard = JobCard::find($jobcard->jobcardID);
    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
    	$jobcardstatuss = JobCardStatus::all();
    	$documentmaster = DocumentMaster::all();
    	$attachments = Attachment::where('documentAutoID', $jobcard->jobcardID)->where('documentID', 5)->get();
    	$tenant_name = ($jobcard->tenantsID ) ? Tenant::find($jobcard->tenantsID)->firstName : '';
    	$unit_number = (Unit::find($jobcard->unitID)) ? Unit::find($jobcard->unitID)->unitNumber : '';
    	$property_name = (Property::find($jobcard->PropertiesID) ) ? Property::find($jobcard->PropertiesID)->pPropertyName : '';
    	$jobcardstatussName = (JobCardStatus::where('jobcardStatusID' )) ? JobCardStatus::where('jobcardStatusID', $jobcard->jobcardStatusID)->first()->statusDescription : '';
    	$created_at = $jobcard->createdDateTime;
    	$created_by = Sentinel::findById($jobcard->createdByUserID)->first_name;
	    return view('jobcards_edit', [
	        'jobcard' => $jobcard,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'tenant_name' => $tenant_name,
	        'unit_number' => $unit_number,
	        'property_name' => $property_name,
	        'jobcardstatuss' => $jobcardstatuss,
	        'jobcardstatussName' => $jobcardstatussName,
	        'created_at' => $created_at,
	        'created_by' => $created_by,
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
	    $jobcard->unitID = $request->unitID;

	    $jobcard->save();
	    return Redirect::to('jobcards');
    }

    function getUnitsForProperty($propertyId){
    	$units = Unit::where('propertiesID', $propertyId)->get(['unitID', 'unitNumber']);
    	return $units;
    }

    function delete(JobCard $jobcard){
	    $jobcard->delete();
	    return Redirect::to('jobcards');
    }
}

