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
use App\Model\Customer;
use Redirect;
use Sentinel;
use App;
use Debugbar;

class JobcardReceiptController extends Controller
{
	function createReceipt(Request $request){
		$receipt = new Receipt();
		if($request->invoiceID){
			$invoice = CustomerInvoice::find($request->invoiceID);
			$receipt->invoiceSystemCode = $invoice->CustomerInvoiceSystemCode;
			$receipt->customerInvoiceDate = date("Y-m-d", strtotime($invoice->invoiceDate));
			$receipt->customerInvoiceAmount = $invoice->amount;

			$dueReceipt = $invoice->amount - Receipt::where('customerInvoiceID', $invoice->customerInvoiceID)->where('documentID', 5)->where('documentAutoID', $request->jobcardID)->sum('receiptAmount');

			// dd($dueReceipt);

			// Payment Made Y/N
			if($request->receiptAmount && ($dueReceipt <= $request->receiptAmount)){
				// partially paid
				$invoice->paymentReceivedYN = 2;
			}else{
				// fully paid
				$invoice->paymentReceivedYN = 1;
			}
			$invoice->save();
		}
		// Check if renatal owner has been submitted
		if(Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', $request->customerID)->first()){
			$customerid = Customer::where('fromPropertyOwnerOrTenant', 1)->where('IDFromTenantOrPropertyOwner', $request->customerID)->first()->customerID;
			$receipt->customerID = $customerid;
		}else{
			// if not renturn without saving
			$request->session()->flash('alert-success', 'This rental owner has not been submitted so this action cannot be done');
			return Redirect::back();				
		}


		$receipt->documentID = 5;
		$receipt->documentAutoID = $request->jobcardID;
		$receipt->customerInvoiceID = $request->invoiceID;
		$receipt->receiptAmount = $request->receiptAmount;
		$receipt->paymentTypeID = $request->paymentTypeID;
		$receipt->chequeNumber = $request->chequeNumber;
		if($request->chequeDate)
			$receipt->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');
		$receipt->lastUpdatedByUserID = Sentinel::getUser()->id;
		$receipt->save();

		return Redirect::to('jobcard/edit/'.$request->jobcardID.'/receipt');
	}

	function index($jobcard){
		$jobcard = JobCard::find($jobcard);
		$customer = null;
		if($jobcard->rentalOwnerID){
			$customer = RentalOwner::find($jobcard->rentalOwnerID);			
		}
		// dd($customer);
		$receipts = Receipt::where('documentID',5 )->where('documentAutoID', $jobcard->jobcardID)->get();
		$invoices = null;
		if(isset($customer->rentalOwnerID) && CustomerInvoice::where('propertyOwnerID', $customer->rentalOwnerID))
			$invoices = CustomerInvoice::where('propertyOwnerID', $customer->rentalOwnerID)->where('jobcardID', $jobcard->jobcardID)->where('paymentReceivedYN', '!=', 2)->get();
		$paymentTypes = PaymentType::all();
		return view('jobcard_receipt', [
            'jobcard' => $jobcard,
            'customer' => $customer,
            'invoices' => $invoices,
            'receipts' => $receipts,
            'paymentTypes' => $paymentTypes,
            
	    ]);
	}

	function getInvoiceItems($customer, $jobcard){
		$invoice = CustomerInvoice::where('propertyOwnerID', $customer)->where('jobcardID', $jobcard)->where('paymentReceivedYN', '!=', 2)->get();
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
		$jobcard = JobCard::find($receipt->documentAutoID);
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
		$jobcardID = $receipt->documentAutoID;

		if(isset($receipt->customerInvoiceID)){
			$invoice = CustomerInvoice::find($receipt->customerInvoiceID);

			// All receipts for invoice - this receipt
			$thisReceiptAmount = Receipt::where('customerInvoiceID', $receipt->customerInvoiceID)->first()->receiptAmount;
			$allReceiptAmount = Receipt::where('customerInvoiceID', $receipt->customerInvoiceID)->sum('receiptAmount');
			$balence = $allReceiptAmount - $thisReceiptAmount;

			if($balence > 0){
				$invoice->paymentReceivedYN = 1;
			}else{
				$invoice->paymentReceivedYN = 0;
			}
			$invoice->save();				


		}

		$receipt->delete();
		return Redirect::to('/jobcard/edit/'.$jobcardID.'/receipt');
	}
}