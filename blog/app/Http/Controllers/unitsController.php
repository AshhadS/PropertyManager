<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use Datatables;
use Illuminate\Support\Facades\DB;
class unitsController extends Controller
{
    function index() {
    	$units = Unit::all();
    	$properties = Property::all();
	    return view('units', [
	        'units' => $units,
	        'properties' => $properties,
	    ]);
    }

    function data(){
    	$t = DB::table('units')
			->leftJoin('properties', 'units.PropertiesID', '=', 'units.PropertiesID')
	    	->select('unitID', 'unitNumber', 'units.description', 'size', 'marketRent', 'properties.pPropertyName');
	    	// dd(Datatables::of($t)->make(true));
    	return Datatables::of($t)->make(true);
    }

    function create(Request $request) {
	    $units = new Unit;
	    $units->unitNumber  = $request->unitNumber;
	    $units->size        = $request->size;
	    $units->description = $request->description;
	    $units->marketRent = $request->marketRent;
	    $units->save();

	    return $this->index();
    }

    function edit(Unit $unit){
    	$unit = Unit::find($unit->unitID);
	    return view('units_edit', [
	        'unit' => $unit,
	    ]);
    }

    function update(Request $request){	
    	$unit = Unit::find($request->unitID);
		$unit->unitNumber  = $request->unitNumber;
	    $unit->size        = $request->size;
	    $unit->description = $request->description;
	    $unit->marketRent = $request->marketRent;
	    $unit->PropertiesID = $request->propertyType;
	    $unit->save();
	    return $this->index();
    }

    function delete(Unit $unit){
	    $unit->delete();
	    return $this->index();
    }
}
