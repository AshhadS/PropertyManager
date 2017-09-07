<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RentalOwner;
use App\Model\Country;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Property;
use App\Model\Supplier;
use App\Model\Customer;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Sentinel;
use Redirect;
use Carbon\Carbon;

class RentalOwnersController extends Controller
{
    function index() {
    	$rentalowners = RentalOwner::all();
    	$countries = Country::all();
	    return view('rentalowners', [
	        'rentalowners' => $rentalowners,
	        'countries' => $countries,
	    ]);
    }
    
    function data(){
    	$t = DB::table('rentalowners')
    		->leftJoin('countries', 'rentalowners.country', '=', 'countries.id')
	    	->select('rentalownerID', 'firstName', 'lastName', 'dateOfBirth', 'email', 'phoneNumber', 'officeNumber', 'countries.countryName', 'address', 'city', 'comments', 'isSubmitted');
    	return Datatables::of($t)->make(true);

    	// return Datatables::of(rentalowner::query())->make(true);
    }

    function create(Request $request) {
	    $rentalowner = new RentalOwner;
	    $rentalowner->firstName = $request->fname;
	    $rentalowner->lastName = $request->lname;
	    $rentalowner->email = $request->email;
	    $rentalowner->phoneNumber = $request->phone;
	    $rentalowner->officeNumber = $request->officephone;
	    $rentalowner->country = $request->country;
	    $rentalowner->address = $request->address;
	    $rentalowner->city = $request->city;
	    $rentalowner->comments = $request->comments;
	    $rentalowner->companyID = $request->company;
	    $rentalowner->companyID = Sentinel::getUser()->companyID;
	    $rentalowner->documentID = 2;

	    if($request->dob)
		    $rentalowner->dateOfBirth = date_create_from_format("j/m/Y", $request->dob)->format('Y-m-d');
	    		
	    $rentalowner->save();

	    return Redirect::to('rentalowners');
    }

    function submitHandler(Request $request){
        $rentalowner = RentalOwner::find($request->rentalownerID);

        if($request->flag == '0'){        
            $this->createSupplier($request->rentalownerID);
            $this->createCustomer($request->rentalownerID);
        }else{
           Supplier::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', $request->rentalownerID)->delete();
           Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', $request->rentalownerID)->delete();
        }
        $rentalowner->isSubmitted = ($request->flag == '1') ? '0' : '1';
        $rentalowner->save();

        return Redirect::back();
    }


    function createSupplier($rentalownerID){
        $rentalowner = RentalOwner::find($rentalownerID);
    	$supplier = new Supplier;
        $supplier->supplierCode = '';
        $supplier->supplierName    = $rentalowner->firstName.' '.$rentalowner->lastName;
        $supplier->address = $rentalowner->address;
        $supplier->telephoneNumber = $rentalowner->phoneNumber;
        $supplier->faxNumber   = $rentalowner->officeNumber;
        $supplier->fromPropertyOwnerOrTenant   = 1;
        $supplier->IDFromTenantOrPropertyOwner   = $rentalownerID;
        $supplier->timestamp = Carbon::now();

        $supplier->save();
        $supplier->supplierCode = sprintf("S%'05d\n", $supplier->supplierID);
        $supplier->save();
        return true;
    }

    function createCustomer($rentalownerID){
        $rentalowner = RentalOwner::find($rentalownerID);

        $customer = new Customer;
        $customer->customerName    = $rentalowner->firstName.' '.$rentalowner->lastName;
        $customer->address = $rentalowner->address;
        $customer->telephoneNumber = $rentalowner->phoneNumber;
        $customer->faxNumber   = $rentalowner->officeNumber;   
        $customer->fromPropertyOwnerOrTenant   = 1;
        $customer->IDFromTenantOrPropertyOwner   = $rentalownerID;
        $customer->timestamp = Carbon::now();
        $customer->createdDate = date('Y-m-d');
        $customer->updatedDate = date('Y-m-d');
        $customer->customerCode = 0;

        $customer->save();

        $customer->customerCode = sprintf("CUST%'05d\n", $customer->customerID);
        $customer->save();
    }


    function edit(RentalOwner $rentalowner){
    	// Debugbar::info($rentalowner); 
    	$rentalowner = RentalOwner::find($rentalowner->rentalOwnerID);
    	$countries = Country::all();
    	$documentmaster = DocumentMaster::all();
    	$attachments = Attachment::where('documentAutoID', $rentalowner->rentalOwnerID)->where('documentID', 2)->get();
    	$ownedProperties = Property::where('rentalOwnerID', $rentalowner->rentalOwnerID)->get();
    	$countryName = (isset($rentalowner->country)) ? Country::find($rentalowner->country)->countryName : '';

	    return view('rentalowners_edit', [
	        'rentalowner' => $rentalowner,
	        'countries' => $countries,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'countryName' => $countryName,
	        'ownedProperties' => $ownedProperties,
	    ]);
    }

    function update(Request $request){	
    	$rentalowner = RentalOwner::find($request->rentalOwnerID);
		$rentalowner->firstName = $request->fname;
	    $rentalowner->lastName = $request->lname;
	    $rentalowner->email = $request->email;
	    $rentalowner->phoneNumber = $request->phone;
	    $rentalowner->officeNumber = $request->officephone;
	    $rentalowner->country = $request->country;
	    $rentalowner->address = $request->address;
	    $rentalowner->city = $request->city;
	    $rentalowner->comments = $request->comments;
	    $rentalowner->companyID = $request->company;

	    if($request->dob)
		    $rentalowner->dateOfBirth = date_create_from_format("j/m/Y", $request->dob)->format('Y-m-d');

	    $rentalowner->save();
	    return Redirect::to('rentalowners');
    }

    function delete(Request $request, $rentalOwnerID){
    	$rentalowner = RentalOwner::find($rentalOwnerID);
        if($rentalowner->isSubmitted == 1){
            $request->session()->flash('alert-success', 'You cannot delete this RentalOwner as this is submitted');
        }else{
            $rentalowner->delete();
        }
	    return Redirect::to('rentalowners');
    }
}
 