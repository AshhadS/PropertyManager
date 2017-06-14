<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Tenant;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Agreement;
use App\Model\PaymentType;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;
use DateTime;

class AgreementsController extends Controller
{
    function index() {
    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
        $paymentypes = PaymentType::all();
    	
    	// Debugbar::info($tenants);
	    return view('agreement', [
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'paymentypes' => $paymentypes,
	    ]);
    }
    
    function data(){
    	$t = DB::table('agreement')
    		->leftJoin('tenants', 'agreement.tenantID', '=', 'tenants.tenantsID')
    		->leftJoin('units', 'agreement.unitID', '=', 'units.unitID')
            ->leftJoin('properties', 'agreement.PropertiesID', '=', 'properties.PropertiesID')
    		->leftJoin('paymenttype', 'agreement.paymentTypeID', '=', 'paymenttype.paymentTypeID')
    		->select('agreement.agreementID', 'properties.pPropertyName', 'units.unitNumber' , 'tenants.firstName', 'agreement.dateFrom','agreement.dateTo','agreement.marketRent','agreement.actualRent', 'paymenttype.paymentDescription');
    	return Datatables::of($t)->make(true);

    }

    function create(Request $request) {
	    $agreement = new Agreement;
	    ($request->PropertiesID != 0) ? $agreement->PropertiesID = $request->PropertiesID : false; // do not save if 0 was selected
	    $agreement->rentalOwnerID = Property::where('PropertiesID', $request->PropertiesID)->first()->rentalOwnerID;
	    $agreement->tenantID = $request->tenantsID;
        $agreement->unitID = $request->unitID;
        $agreement->actualRent = $request->actualRent;
        $agreement->marketRent = $request->marketRent;
        $agreement->dateFrom =  $request->dateFrom;
        $agreement->dateTo =  $request->dateTo;
        $agreement->paymentTypeID  = $request->paymentTypeID;
	    $agreement->companyID = Sentinel::getUser()->companyID;
        $agreement->isPDCYN  = (isset($request->pdcyn)) ? $request->pdcyn : '0';

	
	    $agreement->save();

	    return Redirect::to('agreements');
    }

    function getFields($agreementid){
        $agreement = Agreement::where('agreementID', $agreementid)->get();
        return $agreement;
    }

  
    function update(Request $request){
    	$agreement = Agreement::find($request->agreementID);
        ($request->PropertiesID != 0) ? $agreement->PropertiesID = $request->PropertiesID : false; // do not save if 0 was selected
        $agreement->rentalOwnerID = Property::where('PropertiesID', $request->PropertiesID)->first()->rentalOwnerID;
        $agreement->tenantID = $request->tenantsID;
        $agreement->unitID = $request->unitID;
        $agreement->actualRent = $request->actualRent;
        $agreement->marketRent = $request->marketRent;
        $agreement->dateFrom =  $request->dateFrom;
        $agreement->dateTo =  $request->dateTo;
        $agreement->paymentTypeID  = $request->paymentTypeID;
        $agreement->isPDCYN  = (isset($request->pdcyn)) ? $request->pdcyn : '0';

    
        $agreement->save();

        return Redirect::to('agreements');
    	
    }

    

    function delete($agreement){
        $agreement = Agreement::find($agreement);
	    $agreement->delete();
	    return Redirect::to('agreements');
    }
}

