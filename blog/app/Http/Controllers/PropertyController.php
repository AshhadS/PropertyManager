<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Property;
use App\Model\PropertyType;
use App\Model\PropertySubType;
use App\Model\RentalOwner;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
    	// Debugbar::info($property); 

class PropertyController extends Controller
{
    function index() {
    	$props = Property::all();
	    $props = Property::all();
	    $propSubTypes = PropertySubType::all();
	    $propTypes = PropertyType::all();
    	$rentalowners = RentalOwner::all();


	    return view('prop', [
	        'props' => $props,
	        'propSubTypes' => $propSubTypes,
	        'propTypes' => $propTypes,
	        'rentalowners' => $rentalowners,
	    ]);
    }
    
    function data(){
    	$t = DB::table('properties')->select('PropertiesID', 'companyID', 'documentID', 'pPropertyName', 'description', 'propertyTypeID', 'propertySubTypeID', 'numberOfUnits', 'rentalOwnerID', 'address', 'city', 'forRentOrOwn');
    	return Datatables::of($t)->make(true);


    	// return Datatables::of(prop::query())->make(true);
    }

    function create(Request $request) {
    	Debugbar::info($request);
	    $prop = new Property;
	    $prop->pPropertyName = $request->pPropertyName;
	    $prop->description = $request->description;
	    $prop->propertySubTypeID = $request->propertySubTypeID;
	    $prop->numberOfUnits = $request->numberOfUnits;
	    $prop->rentalOwnerID = $request->rentalOwnerID;
	    $prop->address =$request->address;
	    $prop->city =$request->city;
	    $prop->forRentOrOwn =$request->forRentOrOwn;
	    $prop->documentID =$request->documentID;

	
	    $prop->save();

	    return Redirect::to('props');
    }

    function edit(Property $property){
    	$props = Property::find($property->PropertiesID);
	    $propSubTypes = PropertySubType::all();
    	$rentalowners = RentalOwner::all();
	    

	    return view('props_edit', [
	        'props' => $props,
	        'propSubTypes' => $propSubTypes,
	        'rentalowners' => $rentalowners,

	    ]);
    }

    function update(Request $request){	

    	$prop = Property::find($request->PropertiesID);
    	$prop->pPropertyName = $request->pPropertyName;
	    $prop->description = $request->description;
	    $prop->propertySubTypeID = $request->propertySubTypeID;
	    $prop->numberOfUnits = $request->numberOfUnits;
	    $prop->rentalOwnerID = $request->rentalOwnerID;
	    $prop->address =$request->address;
	    $prop->city =$request->city;
	    $prop->forRentOrOwn =$request->forRentOrOwn;
	    $prop->documentID =$request->documentID;

	    $prop->save();
	    return Redirect::to('props');
    }

    function delete(Property $prop){
	    $prop->delete();
	    return Redirect::to('props');
    }
}

