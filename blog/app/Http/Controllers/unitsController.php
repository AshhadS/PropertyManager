<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Attachment;
use App\Model\DocumentMaster;
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
    	
	    return view('units', [
	        'units' => $units,
	        'properties' => $properties,
	    ]);
    }

    function data(){
    	$t = DB::table('units')
			->leftJoin('properties', 'units.PropertiesID', '=', 'properties.PropertiesID')
	    	->select('unitID', 'unitNumber', 'units.description', 'size', 'marketRent', 'properties.pPropertyName');		
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
    	$attachments = Attachment::where('documentAutoID', $unit->unitID)->where('documentID', 3)->get();

    	$property_name = (isset($unit->PropertiesID)) ? Property::find($unit->PropertiesID)->pPropertyName : '';
	    return view('units_edit', [
	        'unit' => $unit,
	        'properties' => $properties,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'property_name' => $property_name,
	    ]);
    }

    function update(Request $request){	
    	$unit = Unit::find($request->unitID);
		$unit->unitNumber  = $request->unitNumber;
	    $unit->size        = $request->size;
	    $unit->description = $request->description;
	    $unit->marketRent = $request->marketRent;
	    $unit->PropertiesID = $request->PropertiesID;
	    $unit->save();
	    
	    return Redirect::to('units');
    }

    function delete(Unit $unit){
	    $unit->delete();
	    return Redirect::to('units');
    }
}
