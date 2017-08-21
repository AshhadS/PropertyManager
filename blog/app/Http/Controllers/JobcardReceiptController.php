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
		if($request->invoiceID){
			$invoice = CustomerInvoice::find($request->invoiceID);
			$receipt->invoiceSystemCode = $invoice->CustomerInvoiceSystemCode;
			$receipt->customerInvoiceDate = date("Y-m-d", strtotime($invoice->invoiceDate));
			$receipt->customerInvoiceAmount = $invoice->amount;

			$dueReceipt = $invoice->amount - Receipt::where('customerInvoiceID', $invoice->supplierInvoiceID)->where('documentID', 5)->where('documentAutoID', $request->jobcardID)->sum('receiptAmount');

			// Payment Made Y/N
			if($request->receiptAmount && $dueReceipt > $request->receiptAmount){
				// partially paid
				$invoice->paymentReceivedYN = 1;
			}else{
				// fully paid
				$invoice->paymentReceivedYN = 2;
			}
			$invoice->save();
		}
		if($request->customerID)
			$receipt->customerID = $request->customerID;

		$receipt->documentID = 5;
		$receipt->documentAutoID = $request->jobcardID;
		$receipt->customerInvoiceID = $request->invoiceID;
		$receipt->receiptAmount = $request->receiptAmount;
		$receipt->paymentTypeID = $request->paymentTypeID;
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
			$invoices = CustomerInvoice::where('propertyOwnerID', $customer->rentalOwnerID)->where('jobcardID', $jobcard->jobcardID)->get();
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
		$invoice = CustomerInvoice::where('propertyOwnerID', $customer)->where('jobcardID', $jobcard)->get();
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
			$invoice->paymentReceivedYN = 1;
			$invoice->save();
		}

		$receipt->delete();
		return Redirect::to('/jobcard/edit/'.$jobcardID.'/receipt');
	}
}