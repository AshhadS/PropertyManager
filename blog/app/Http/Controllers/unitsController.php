<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Currency;
use App\Model\Agreement;
use App\Model\ImageFile;
use Debugbar;
use Datatables;
use Sentinel;
use Redirect;
use Illuminate\Support\Facades\DB;

class UnitsController extends Controller
{
    function index() {
    	// $units = Unit::where('companyID', Sentinel::getUser()->companyID)->get();
    	// $properties = Property::where('companyID', Sentinel::getUser()->companyID)->get();
    	$units = Unit::all();
    	$properties = Property::all();
    	$currencies = Currency::all();
    	
	    return view('units', [
	        'units' => $units,
	        'properties' => $properties,
	        'currencies' => $currencies,
	    ]);
    }

    function data(){
    	$t = DB::table('units')
			->leftJoin('properties', 'units.PropertiesID', '=', 'properties.PropertiesID')
			->leftJoin('currencymaster', 'units.currencyID', '=', 'currencymaster.currencyID')
	    	->select('unitID', 'unitNumber', 'units.description', 'size', 'marketRent', 'currencymaster.currencyCode', 'properties.pPropertyName');		
	    	// ->where('units.companyID', Sentinel::getUser()->companyID);
    	return Datatables::of($t)->make(true);
    }

    function create(Request $request) {
	    $units = new Unit;
	    $units->unitNumber  = $request->unitNumber;
	    $units->size        = $request->size;
	    $units->description = $request->description;
	    $units->PropertiesID = $request->PropertiesID;
	    $units->marketRent = $request->marketRent;
	    $units->currencyID = $request->currencyID;
	    $units->roomsCount = $request->roomsCount;
	    $units->bathroomCount = $request->bathroomCount;
	    $units->kitchenCount = $request->kitchenCount;
	    $units->hallCount = $request->hallCount;
	    $units->companyID = Sentinel::getUser()->companyID;
	    $units->documentID = 3;

	    $units->save();

	    return Redirect::to('units');
    }

    function edit(Unit $unit){
    	$unit = Unit::find($unit->unitID);
    	// $properties = Property::where('companyID', Sentinel::getUser()->companyID)->get();
    	$properties = Property::all();
    	$documentmaster = DocumentMaster::all();
    	$currencies = Currency::all();
    	if(Attachment::where('documentAutoID', $unit->unitID)->where('documentID', 3))
	    	$attachments = Attachment::where('documentAutoID', $unit->unitID)->where('documentID', 3)->get();

	    $currencyName = false;
	    if($unit->currencyID != 0 && Currency::where('currencyID', $unit->currencyID) )
	    	$currencyName = Currency::where('currencyID', $unit->currencyID)->first()->currencyCode;

    	$property_name = (Property::find($unit->PropertiesID)) ? Property::find($unit->PropertiesID)->pPropertyName : '';
    	$unitImages = ImageFile::where('documentID', 3)->where('documentAutoID', $unit->unitID)->get();
	    return view('units_edit', [
	        'unit' => $unit,
	        'properties' => $properties,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'property_name' => $property_name,
	        'currencyName' => $currencyName,
	        'currencies' => $currencies,
	        'unitImages' => $unitImages,
	    ]);
    }

    function update(Request $request){	
    	$unit = Unit::find($request->unitID);
		$unit->unitNumber  = $request->unitNumber;
	    $unit->size        = $request->size;
	    $unit->description = $request->description;
	    $unit->marketRent = $request->marketRent;
	    $unit->PropertiesID = $request->PropertiesID;
	    $unit->currencyID = $request->currencyID;
	    $unit->roomsCount = $request->roomsCount;
	    $unit->bathroomCount = $request->bathroomCount;
	    $unit->kitchenCount = $request->kitchenCount;
	    $unit->hallCount = $request->hallCount;
	    $unit->save();
	    
	    return Redirect::to('units');
    }

    function delete(Request $request, Unit $unit){
    	if(Agreement::where('unitID', $unit->unitID)->first()){
            $request->session()->flash('alert-success', 'You cannot delete this unit as this has an Agreement created under it');
        }else{
		    $unit->delete();
		}
	    return Redirect::to('units');
    }

}
