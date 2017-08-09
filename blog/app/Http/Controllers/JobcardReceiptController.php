<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\RentalOwner;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\CustomerInvoice;
use App\Model\Receipt;
use App\Model\PaymentType;
use Redirect;
use Sentinel;
use App;

class JobcardReceiptController extends Controller
{
	function createReceipt(Request $request){
		$receipt = new Receipt();
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
		$receipts = Receipt::all();
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
		if(Receipt::where('customerInvoiceID', $invoice)){
			$receivedAmount = Receipt::where('customerInvoiceID', $invoice)->sum('receiptAmount');
		}
		$finalAmount = $invoiceAmount - $receivedAmount;
		return $finalAmount;
	}

	function generatePDF($id){
		$pdf = App::make('dompdf.wrapper');
		$receipt = Receipt::find($id);
		$jobcard = JobCard::find($receipt->jobCardID);
    	$company = Company::find(Sentinel::getUser()->companyID);
		$data = array(
			'jobcard' => $jobcard,
            'company' => $company,
            'receipt' => $receipt,
		);

		$pdf->loadView('pdf/jobcard_receipt_pdf', $data , $data);
		return $pdf->stream();
	}

	function delete($receiptID){
		$receipt = Receipt::find($receiptID);
		$jobcardID = $receipt->jobCardID;

		$receipt->delete();
		return Redirect::to('/jobcard/edit/'.$jobcardID.'/receipt');
	}
}