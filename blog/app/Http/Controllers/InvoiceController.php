<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\Supplier;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\Customer;
use App\Model\SupplierInvoice;
use App\Model\CustomerInvoice;
use App\Model\RentalOwner;
use App\Model\Payment;
use App\Model\Receipt;
use App\Model\GeneralLedger;
use Redirect;
use Sentinel;
use App;
use Carbon\Carbon;

class InvoiceController extends Controller
{
	/******************************************************************************************
	 * 
	 * Supplier Invoice
	 * 
	 *******************************************************************************************/


	function submitButtonHandler(Request $request){
		$this->groupingSuppliers($request);

		$this->createCustomerInvoice($request);

		// Change the isSubmitted flag everytime submit or reverse is clicked
		$jobcard = JobCard::find($request->jobcardID);
		$jobcard->isSubmitted = ($request->flag == '1') ? '0' : '1';
		$jobcard->save();

	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');		
	}

	function invoiceSubmitHandler(Request $request){
		if($request->invoiceType == 1){//Supplier Invoice
	        $invoice = SupplierInvoice::find($request->invoiceID);

	        // Update General Ledger
	        GeneralLedger::addEntry($invoice->supplierInvoiceID, 6, $invoice->invoiceSystemCode, $invoice->invoiceDate,	$invoice->jobCardID, $invoice->supplierID, 1, $invoice->description, 3, 1, $invoice->amount);
		}
		if($request->invoiceType == 2){//Customer Invoice
	        $invoice = CustomerInvoice::find($request->invoiceID);

	        // Update General Ledger
	        GeneralLedger::addEntry($invoice->customerInvoiceID, 7, $invoice->CustomerInvoiceSystemCode, $invoice->invoiceDate,	$invoice->jobcardID, $invoice->propertyOwnerID, 1, $invoice->description, 2, 4, $invoice->amount);
		}

        $invoice->submittedYN = ($request->flag == '1') ? '0' : '1';
        $invoice->submittedDate = Carbon::now();
        $invoice->submittedUserID = Sentinel::getUser()->id;
        $invoice->save();

        return Redirect::back();
    }

	// Save the supplier invoice info to the db
	function createSuppliersInvoice($supplierID, $jobcardID, $total){
		$jobcard = Jobcard::find($jobcardID);
		$invoice = new SupplierInvoice();
		$invoice->supplierID = $supplierID;
		$invoice->jobcardID = $jobcardID;
		$invoice->unitID = $jobcard->unitID;
		$invoice->PropertiesID = $jobcard->PropertiesID;
		$invoice->description = 'invoice for '. $jobcard->jobCardCode;
		$invoice->amount = $total;
		$invoice->invoiceDate = date("Y-m-d H:i:s");
		$invoice->lastUpdatedByUserID = Sentinel::getUser()->id;

		$invoice->save();
		$invoice->invoiceSystemCode = sprintf("SINV%'05d\n", $invoice->supplierInvoiceID);
		$invoice->save();
	}

	// Adds all the supliers totals needed for the invoice table
	function groupingSuppliers(Request $request){
		// if 0 is returned from isSubmitted then generate the suppliers invoice 
		if($request->flag == '0'){
			// Generate supplier invoice per supplier

			// Get a list of unique supplier ids
			$supplierids = Maintenance::where('jobcardID', $request->jobcardID)->distinct()->get(['supplierID'])->pluck('supplierID');

			foreach ($supplierids as $supplierid) {
				// Get totals for each supplier
				$supplierTotal = Maintenance::where('supplierID', $supplierid)->where('jobcardID', $request->jobcardID)->sum('total');
				$this->createSuppliersInvoice($supplierid, $request->jobcardID, $supplierTotal);
			}
		}else{ //Delete all the invoices for that jobcard that have been automatically created
			SupplierInvoice::where('jobcardID', $request->jobcardID)->where('manuallyAdded', '0')->delete();
		}
	}

	// Creates the supplier invoice page
	function supplierIndex($jobcard){
		$jobcard = JobCard::find($jobcard);
    	$supplierInvoices = SupplierInvoice::where('jobcardID', $jobcard->jobcardID)->get();
    	$customerInvoices = CustomerInvoice::where('jobcardID', $jobcard->jobcardID)->get();
    	$suppliers = Supplier::where('fromPropertyOwnerOrTenant', '0')->get();
    	if($jobcard->rentalOwnerID){
			$customer = RentalOwner::find($jobcard->rentalOwnerID);			
		}
        // dd($supplierInvoices->first());


		return view('jobcard_invoices', [
            'jobcard' => $jobcard,
            'supplierInvoices' => $supplierInvoices,
            'customerInvoices' => $customerInvoices,
            'suppliers' => $suppliers,
            'customer' => $customer,
	    ]);
	}

	

	// Returns a list of maintenace items belonging to a specific supplier and jobcard
	function getMaintenanceItems($supplierid, $jobcardID){
		$items = Maintenance::where('supplierID', $supplierid)->where('jobcardID', $jobcardID)->get();
		return $items;
	}

	// Function that generates the supplier invoice pdf 
	function supplierInvoicePDF($invoiceID){
		$pdf = App::make('dompdf.wrapper');
		$invoice = SupplierInvoice::find($invoiceID);
		$jobcard = JobCard::find($invoice->jobcardID);
    	$company = Company::find(Sentinel::getUser()->companyID);
		$items = $this->getMaintenanceItems($invoice->supplierID, $invoice->jobcardID);

		// dd($items);
		$data = array(
			'jobcard' => $jobcard,
            'company' => $company,
            'invoice' => $invoice,
            'items' => $items,
		);

		$pdf->loadView('invoice_supplier_pdf', $data , $data);
		return $pdf->stream();

		// return view('invoice_pdf', $data);
	}

	function updateSupplierInvoice(Request $request){
		// dd($request->invoiceDate);
		$invoice = SupplierInvoice::find($request->supplierInvoiceID);
		$invoice->supplierInvoiceCode = $request->supplierInvoiceCode;
		$invoice->invoiceDate = date_create_from_format("j/m/Y", $request->invoiceDate)->format('Y-m-d');
		$invoice->save();
		$jobcardID = $invoice->jobcardID;
		
		return Redirect::back();
	}



	/******************************************************************************************
	 * 
	 * Customer Invoice
	 * 
	 *******************************************************************************************/
	function createCustomerInvoice(Request $request){
		// if 0 is returned from isSubmitted then generate the suppliers invoice 
		if($request->flag == '0'){
			$jobcard = Jobcard::find($request->jobcardID);
			$invoice = new CustomerInvoice();
			$invoice->jobcardID = $request->jobcardID;
			$invoice->unitID = $jobcard->unitID;
			$invoice->PropertiesID = $jobcard->PropertiesID;
			$invoice->propertyOwnerID = Property::find($jobcard->PropertiesID)->rentalOwnerID;
			$invoice->description = 'invoice for '. $jobcard->jobCardCode;
			$invoice->amount = $this->getJobcardGrandTotal($jobcard->jobcardID);
			$invoice->invoiceDate = date("Y-m-d H:i:s");
			$invoice->lastUpdatedByUserID = Sentinel::getUser()->id;

			// Check if tenant owner has been submitted
            if(Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', Property::find($jobcard->PropertiesID)->rentalOwnerID)->first()){
                $invoice->propertyOwnerID = Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', Property::find($jobcard->PropertiesID)->rentalOwnerID)->first()->customerID;
            }else{
                // if not renturn without saving
                $request->session()->flash('alert-success', 'Cannot submit this agreement because the rental owner has not been submitted');
                return Redirect::back();                
            }

			$invoice->save();
			$invoice->CustomerInvoiceSystemCode = sprintf("CINV%'05d\n", $invoice->customerInvoiceID);
			$invoice->save();


		}else{ //Delete all the invoices for that jobcard
			CustomerInvoice::where('jobcardID', $request->jobcardID)->where('manuallyAdded', '0')->delete();
		}
	}

	// Function that generates the customer invoice pdf 
	function customerInvoicePDF($invoiceID){
		$pdf = App::make('dompdf.wrapper');
		$customerInvoice = CustomerInvoice::find($invoiceID);
		$jobcard = JobCard::find($customerInvoice->jobcardID);
    	$company = Company::find(Sentinel::getUser()->companyID);
    	$items = Maintenance::where('jobcardID', $customerInvoice->jobcardID)->get();


		// dd($items);
		$data = array(
			'jobcard' => $jobcard,
            'company' => $company,
            'customerInvoice' => $customerInvoice,
            'items' => $items,
		);

		$pdf->loadView('invoice_customer_pdf', $data , $data);
		return $pdf->stream();

		// return view('invoice_customer_pdf', $data);
		
	}

	// Returns to cost + Margin for a jobcard
	function getJobcardGrandTotal($jobcardID){
		return Maintenance::where('jobcardID', $jobcardID)->sum('netTotal');
	}

	function updateCustomerInvoice(Request $request){
		$invoice = CustomerInvoice::find($request->customerInvoiceID);
		$invoice->invoiceDate = date_create_from_format("j/m/Y", $request->invoiceDate)->format('Y-m-d');
		
		$invoice->save();
		$jobcardID = $invoice->jobcardID;

		
		return Redirect::back();
	}

	/**
	* Common to both invoices
	*/
	function createInvoice(Request $request){
		//supplier
		if($request->invoiceType == '0'){
			$invoice = new SupplierInvoice;
			$jobcard = JobCard::find($request->jobcardID);
			$invoice->supplierID = $request->supplierID;
			$invoice->jobCardID = $request->jobcardID;
			$invoice->PropertiesID = $request->PropertiesID;
			$invoice->unitID = $request->unitID;
			$invoice->supplierInvoiceCode = $request->supplierInvoiceCode;
			$invoice->invoiceSystemCode = 0;
			$invoice->amount = $request->amount;
			$invoice->paymentPaidYN = 0;
			$invoice->manuallyAdded = 1;
			$invoice->createdDateTime = Carbon::now();
			$invoice->lastUpdatedDateTime = Carbon::now();
			$invoice->lastUpdatedByUserID = Sentinel::getUser()->id;
			$invoice->description = 'invoice for '.$jobcard->jobCardCode ;
			if($request->invoiceDate)
				$invoice->invoiceDate = date_create_from_format("j/m/Y", $request->invoiceDate)->format('Y-m-d');

			$invoice->save();
			$invoice->invoiceSystemCode = sprintf("SINV%'05d\n", $invoice->supplierInvoiceID);
			$invoice->save();
            return Redirect::back();    
        }

		//customer
		if($request->invoiceType == '1'){ 
			$invoice = new CustomerInvoice;
			$jobcard = JobCard::find($request->jobcardID);
			$invoice->jobcardID = $request->jobcardID;
			$invoice->PropertiesID = $request->PropertiesID;
			$invoice->unitID = $request->unitID;
			$invoice->CustomerInvoiceSystemCode = 0;
			$invoice->invoiceDate = date_create_from_format("j/m/Y", $request->invoiceDate)->format('Y-m-d');
			$invoice->amount = $request->amount;
			$invoice->paymentReceivedYN = 0;
			$invoice->manuallyAdded = 1;
			$invoice->createdDateTime = Carbon::now();
			$invoice->lastUpdatedDateTime = Carbon::now();
			$invoice->lastUpdatedByUserID = Sentinel::getUser()->id;
			$invoice->description = 'invoice for '.$jobcard->jobCardCode ;

			// Check if owner has been submitted
            if(Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', Property::find($jobcard->PropertiesID)->rentalOwnerID)->first()){
                $invoice->propertyOwnerID = Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', Property::find($jobcard->PropertiesID)->rentalOwnerID)->first()->customerID;
            }else{
                // if not renturn without saving
                $request->session()->flash('alert-success', 'Cannot create this invoice because the rental owner has not been submitted');
                return Redirect::back();                
            }

			$invoice->save();
			$invoice->CustomerInvoiceSystemCode = sprintf("CINV%'05d\n", $invoice->customerInvoiceID);
			$invoice->save();
		}
        return Redirect::back();                
	}

	function deleteManualInvoice(Request $request){
		//Supplier
		if($request->invoiceType == '0'){
			if(Payment::where('supplierInvoiceID', $request->invoiceID)->first()){
				$request->session()->flash('alert-success', 'Cannot delete this invoice because there is already payments created under this');
                return Redirect::back();  
			}
			$invoice = SupplierInvoice::find($request->invoiceID);
		}
		//Customer
		if($request->invoiceType == '1'){
			if(Receipt::where('customerInvoiceID', $request->invoiceID)->first()){
				$request->session()->flash('alert-success', 'Cannot delete this invoice because there is already receipts created under this');
                return Redirect::back();  
			}
			$invoice = CustomerInvoice::find($request->invoiceID);
		}
		$invoice->delete();
        return Redirect::back();                
	}


}