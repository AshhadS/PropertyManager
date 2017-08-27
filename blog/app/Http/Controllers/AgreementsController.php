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
use App\Model\Receipt;
use App\Model\Payment;
use App\Model\RentalOwner;
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
        $agreement->paymentTypeID  = $request->paymentTypeID;
        $agreement->companyID = Sentinel::getUser()->companyID;
        $agreement->isPDCYN  = (isset($request->pdcyn)) ? $request->pdcyn : '0';

        if($request->dateFrom)
            $agreement->dateFrom = date_create_from_format("j/m/Y", $request->dateFrom)->format('Y-m-d');
        
        if($request->dateTo)
            $agreement->dateTo = date_create_from_format("j/m/Y", $request->dateTo)->format('Y-m-d');
	
	    $agreement->save();

	    return Redirect::to('agreements');
    }

    function getFields($agreementid){
     //   $agreement = Agreement::where('agreementID', $agreementid)->get();
        $agreement = Agreement::where('agreementID', $agreementid)->firstOrFail();
        $propertylist = Property::pluck('pPropertyName', 'PropertiesID');
        $tenantlist = Tenant::pluck('firstName', 'tenantsID');
        $unitlist = Unit::pluck('unitNumber', 'unitID');
        $paymenttypelist = PaymentType::pluck('paymentDescription', 'paymentTypeID');
        $startDate=date_create_from_format("Y-m-d", $agreement->dateFrom)->format('j/m/Y');
        $endDate=date_create_from_format("Y-m-d", $agreement->dateTo)->format('j/m/Y');
        $receipts = Receipt::where('documentID', 8)->where('documentAutoID', $agreement->agreementID)->get();
        $payments = Payment::where('documentID', 8)->where('documentAutoID', $agreement->agreementID)->get();
        $customers = RentalOwner::all();
        $paymentTypes = PaymentType::all();
        return view('agreements_edit', [
            'agreement' => $agreement,
            'propertylist' => $propertylist,
            'tenantlist' => $tenantlist,
            'unitlist' => $unitlist,
            'paymenttypelist' => $paymenttypelist,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'receipts' => $receipts,
            'payments' => $payments,
            'customers' => $customers,
            'paymentTypes' => $paymentTypes,
           ]);
    }

    function submitHandler(Request $request){
        $agreement = Agreement::find($request->agreementID);

        if($request->flag == '0'){
            $monthCount = $this->getMonthsDiff($agreement->dateFrom, $agreement->dateTo);

            for ($i=0; $i < $monthCount ; $i++) { 
                $payment = new Payment();
                $payment->supplierID = $agreement->rentalOwnerID;
                $payment->documentID = 8 ;
                $payment->documentAutoID = $agreement->agreementID;
                $payment->paymentAmount = $agreement->marketRent;
                $payment->paymentTypeID = $agreement->paymentTypeID;
                $payment->lastUpdatedByUserID = Sentinel::getUser()->id;
                $payment->save();


                $receipt = new Receipt();
                $receipt->customerID = $agreement->tenantID;
                $receipt->documentID = 8 ;
                $receipt->documentAutoID = $agreement->agreementID;
                $receipt->receiptAmount = $agreement->actualRent;
                $receipt->paymentTypeID = $agreement->paymentTypeID;
                $receipt->lastUpdatedByUserID = Sentinel::getUser()->id;
                $receipt->save();
            }
        }else{
            // Delete all payments
            Receipt::where('documentAutoID', $request->agreementID )->where('documentID', '8')->delete();
            Payment::where('documentAutoID', $request->agreementID )->where('documentID', '8')->delete();
        }
        $agreement->isSubmitted = ($request->flag == '1') ? '0' : '1';
        $agreement->save();

        return Redirect::back();
    }

    // Calculate the number of months between 2 dates
    static function getMonthsDiff($from, $to){
        $date1 = $from;
        $date2 = $to;

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        
        $year1 = intval(date('Y', $ts1));
        $year2 = intval(date('Y', $ts2));

        $month1 = intval(date('m', $ts1));
        $month2 = intval(date('m', $ts2));

        $monthsDiff = (($year2 - $year1) * 12) + ($month2 - $month1);
        return $monthsDiff;
        return Redirect::back(); 

    }

  
    function update($id,Request $request){

    	//$agreement = Agreement::find($request->agreementID);
        $agreement= Agreement::where('agreementID', $id)->firstOrFail();
        ($request->PropertiesID != 0) ? $agreement->PropertiesID = $request->PropertiesID : false; // do not save if 0 was selected
        $agreement->rentalOwnerID = Property::where('PropertiesID', $request->PropertiesID)->first()->rentalOwnerID;
        $agreement->tenantID = $request->tenantsID;
        $agreement->unitID = $request->unitID;
        $agreement->actualRent = $request->actualRent;
        $agreement->marketRent = $request->marketRent;
        $agreement->paymentTypeID  = $request->paymentTypeID;
        $agreement->isPDCYN  = (isset($request->pdcyn)) ? $request->pdcyn : '0';

        if($request->dateFrom)
            $agreement->dateFrom = date_create_from_format("j/m/Y", $request->dateFrom)->format('Y-m-d');
        
        if($request->dateTo)
            $agreement->dateTo = date_create_from_format("j/m/Y", $request->dateTo)->format('Y-m-d');

        //$agreement->fill($request->all())->save();
        $agreement->save();

        return Redirect::to('agreements');
    	
    }

    

    function delete($agreement){
        $agreement = Agreement::find($agreement);
        $request = Request();
        if($agreement->isSubmitted == 1){
            $request->session()->flash('alert-success', 'You cannot delete this Agreement as the Agreement is submitted');
        }else{
    	    $agreement->delete();
        }
        return Redirect::to('agreements');
    }
}

