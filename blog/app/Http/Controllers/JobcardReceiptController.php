<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\RentalOwner;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\CustomerInvoice;
use App\Model\JobcardReceipt;
use App\Model\PaymentType;
use Redirect;
use Sentinel;
use App;

class JobcardReceiptController extends Controller
{
	function createReceipt(Request $request){
		$receipt = new JobcardReceipt();
		$invoice = CustomerInvoice::find($request->invoiceID);
		$receipt->customerID = $request->customerID;
		$receipt->customerInvoiceID = $request->invoiceID;
		$receipt->invoiceSystemCode = $invoice->CustomerInvoiceSystemCode;
		$receipt->jobcardID = $invoice->jobcardID;
		$receipt->customerInvoiceDate = date("Y-m-d", strtotime($invoice->invoiceDate));
		$receipt->customerInvoiceAmount = $invoice->amount;
		$receipt->receiptAmount = $request->receiptAmount;
		$receipt->paymentTypeID = $request->paymentTypeID;
		$receipt->lastUpdatedByUserID = Sentinel::getUser()->id;
		$receipt->save();

		return Redirect::to('jobcard/edit/'.$request->jobcardID.'/receipt');
	}

	function index($jobcard){
		$jobcard = JobCard::find($jobcard);
		$customers = RentalOwner::all();
		$receipts = JobcardReceipt::all();
		$paymentTypes = PaymentType::all();
		return view('jobcard_receipt', [
            'jobcard' => $jobcard,
            'customers' => $customers,
            'receipts' => $receipts,
            'paymentTypes' => $paymentTypes,
            
	    ]);
	}

	function getInvoiceItems($customer){
		$invoice = CustomerInvoice::where('propertyOwnerID', $customer)->get();
		return $invoice;
	}

	function getInvoiceAmount($invoice){
		// Check if payment has been made before
		$invoiceAmount = CustomerInvoice::find($invoice)->amount;
		$receivedAmount = 0;
		if(JobcardReceipt::where('customerInvoiceID', $invoice)){
			$receivedAmount = JobcardReceipt::where('customerInvoiceID', $invoice)->sum('receiptAmount');
		}
		$finalAmount = $invoiceAmount - $receivedAmount;
		return $finalAmount;
	}


}