<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Property;
use App\Model\PropertyType;
use App\Model\PropertySubType;
use App\Model\Country;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\RentalOwner;
use App\Model\Agreement;
use App\Model\ImageFile;
use App\Model\Note;
use App\Model\Unit;
use App\Model\JobCard;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Debugbar;
use Sentinel;
use Redirect;
    	// Debugbar::info($property); 

class PropertyController extends Controller
{
    function index() {
    	$props = Property::all();
	    $props = Property::all();
	    $propSubTypes = PropertySubType::all();
	    $propTypes = PropertyType::all();
    	$rentalowners = RentalOwner::where('isSubmitted', '1')->get();
    	$countries = Country::all();


	    return view('prop', [
	        'props' => $props,
	        'propSubTypes' => $propSubTypes,
	        'propTypes' => $propTypes,
	        'rentalowners' => $rentalowners,
	        'countries' => $countries,
	    ]);
    }
    
    function data(){
    	$t = DB::table('properties')
			->leftJoin('propertysubtypeid', 'properties.propertySubTypeID', '=', 'propertysubtypeid.propertySubTypeID')
			->leftJoin('rentalowners', 'properties.rentalOwnerID', '=', 'rentalowners.rentalOwnerID')
			->leftJoin('countries', 'properties.country', '=', 'countries.id')
    		->select('PropertiesID', 'pPropertyName', 'description', 'countries.countryName', 'propertysubtypeid.propertySubTypeDescription', 'numberOfUnits', 'rentalowners.firstName', 'properties.address', 'properties.city', 'forRentOrOwn', 'rentalowners.isSubmitted', 'properties.rentalOwnerID', 'rentalowners.isSubmitted');
    	return Datatables::of($t)->make(true);


    	// return Datatables::of(prop::query())->make(true);
    }

    function create(Request $request) {
	    // dd(file_get_contents($request->file('propertyImage')));

		// $prop = new Property();

		$prop =  Property::create();
	    $prop->companyID = Sentinel::getUser()->companyID;
	    $prop->pPropertyName = $request->pPropertyName;
	    $prop->description = $request->description;
	    $prop->propertySubTypeID = $request->propertySubTypeID;
	    ($request->propertyTypeID) ? $prop->propertyTypeID = $request->propertyTypeID : false; // do not save if 0 was selected
	    $prop->numberOfUnits = $request->numberOfUnits;
	    $prop->rentalOwnerID = $request->rentalOwnerID;
	    $prop->address = $request->address;
	    $prop->city = $request->city;
	    $prop->forRentOrOwn = $request->forRentOrOwn;
	    $prop->country = $request->country;
	    $prop->documentID = 1; 
	    // dd($prop->PropertiesID);

	    // File upload
	    if($request->hasFile('propertyImage')){
		    $file = $request->file('propertyImage');
		    $prop->propertyImage = $prop->PropertiesID.'_'. $prop->documentID .'.'. $file->getClientOriginalExtension();
		    Storage::put('uploads/'.$prop->propertyImage, file_get_contents($file));
		}
	    $prop->save();

	    return Redirect::to('props');
    }

    function edit(Property $property){
    	$prop = Property::find($property->PropertiesID);
	    $propTypes = PropertyType::all();
	    $propSubTypes = PropertySubType::all();
    	$rentalowners = RentalOwner::all();
    	$countries = Country::all();
    	$documentmaster = DocumentMaster::all();
    	$attachments = Attachment::where('documentAutoID', $property->PropertiesID)->where('documentID', 1)->get();
    	$propertyImages = ImageFile::where('documentID', 1)->where('documentAutoID', $property->PropertiesID)->get();
    	$notes = Note::where('documentAutoID', $property->PropertiesID)->where('documentID', 1)->get();
	    

    	$property_type_name = (isset($prop->propertySubTypeID)) ? PropertySubType::find($prop->propertySubTypeID)->propertySubTypeDescription : '';
    	$property_parent_type_name = (isset($prop->propertyTypeID)) ? PropertyType::find($prop->propertyTypeID)->propertyDescription : '';
    	$rental_owner_name = (isset($prop->rentalOwnerID)) ? RentalOwner::find($prop->rentalOwnerID)->firstName : '';
    	$rent_or_own = ($prop->forRentOrOwn == 1) ? 'Rent' : 'Own';
    	$countryName = (isset($prop->country)) ? Country::find($prop->country)->countryName : '';

    	$property_units = Unit::where('PropertiesID', $property->PropertiesID)->get();
    	$property_jobcards = JobCard::where('PropertiesID', $property->PropertiesID)->get();
	    return view('props_edit', [
	        'props' => $prop,
	        'propTypes' => $propTypes,
	        'propSubTypes' => $propSubTypes,
	        'rentalowners' => $rentalowners,
	        'documentmaster' => $documentmaster,
	        'attachments' => $attachments,
	        'propertyImages' => $propertyImages,
	        'countries' => $countries,
	        'property_type_name' => $property_type_name,
	        'property_parent_type_name' => $property_parent_type_name,
	        'rental_owner_name' => $rental_owner_name,
	        'rent_or_own' => $rent_or_own,
	        'countryName' => $countryName,
	        'notes' => $notes,
	        'property_units' => $property_units,
	        'property_jobcards' => $property_jobcards,

	    ]);
    }

    function update(Request $request){	

    	$prop = Property::find($request->PropertiesID);
    	$prop->pPropertyName = $request->pPropertyName;
	    $prop->description = $request->description;
	    ($request->propertyTypeID != 0) ? $prop->propertyTypeID = $request->propertyTypeID : false; // do not save if 0 was selected
	    $prop->propertySubTypeID = $request->propertySubTypeID;
	    $prop->numberOfUnits = $request->numberOfUnits;
	    $prop->rentalOwnerID = $request->rentalOwnerID;
	    $prop->address =$request->address;
	    $prop->city =$request->city;
	    $prop->forRentOrOwn =$request->forRentOrOwn;
	    $prop->country = $request->country;


		// File upload
	    if($request->hasFile('propertyImage')){
	    	if(isset($prop->propertyImage)){
		    	Storage::delete('uploads/'.$prop->propertyImage);
	    	}

		    $file = $request->file('propertyImage');
		    $prop->propertyImage = $request->PropertiesID.'_'. $prop->documentID .'.'. $file->getClientOriginalExtension();
		    Storage::put('uploads/'.$prop->propertyImage, file_get_contents($file));
		}

	    $prop->save();
	    return Redirect::to('props');
    }

    function delete(Request $request, Property $property){
    	if(Unit::where('PropertiesID', $property->PropertiesID)->first()){
            $request->session()->flash('alert-success', 'You cannot delete this Property as this has a Unit created under it');
        }else{
		    $property->delete();
		}
	    return Redirect::to('props');
    }


    function getSubtypeList($propertyTypeID){
    	$subtype = PropertySubType::where('propertyTypeID', $propertyTypeID)->get();
    	return $subtype;

    }
}

