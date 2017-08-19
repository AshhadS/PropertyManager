<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\Supplier;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\SupplierInvoice;
use App\Model\Payment;
use App\Model\PaymentType;
use Redirect;
use Sentinel;
use App;

class JobcardPaymentController extends Controller
{
	function createPayment(Request $request){
		$payment = new Payment();
		if($request->invoiceID){
			$invoice = SupplierInvoice::find($request->invoiceID);
			$payment->invoiceSystemCode = $invoice->invoiceSystemCode;
			$payment->supplierInvoiceCode = $invoice->supplierInvoiceCode;
			$payment->SupplierInvoiceDate = date("Y-m-d", strtotime($invoice->invoiceDate));
			$payment->supplierInvoiceAmount = $invoice->amount;			
			$payment->supplierInvoiceID = $request->invoiceID;
		}
		if($request->supplierID)
			$payment->supplierID = $request->supplierID;

		$payment->paymentAmount = $request->paymentAmount;
		$payment->paymentTypeID = $request->paymentTypeID;
		$payment->documentID = 5;
		$payment->documentAutoID = $request->jobcardID;
		$payment->paymentTypeID = $request->paymentTypeID;
		$payment->lastUpdatedByUserID = Sentinel::getUser()->id;
		$payment->save();

		return Redirect::to('jobcard/edit/'.$request->jobcardID.'/payment');
	}

	function index($jobcard){
		$jobcard = JobCard::find($jobcard);
		$suppliers = Supplier::all();
		$payments = Payment::where('documentID', 5)->where('documentAutoID', $jobcard->jobcardID)->get();
		$paymentTypes = PaymentType::all();
		return view('jobcard_payment', [
            'jobcard' => $jobcard,
            'suppliers' => $suppliers,
            'payments' => $payments,
            'paymentTypes' => $paymentTypes,
            
	    ]);
	}

	function getInvoiceItems(Request $request){
		$invoice = SupplierInvoice::where('supplierID', $request->supplier)->where('jobcardID', $request->jobcard)->get();
		return $invoice;
	}

	function getInvoiceAmount($invoice){
		// Check if payment has been made before
		$invoiceAmount = SupplierInvoice::find($invoice)->amount;
		$paidAmount = 0;
		if(Payment::where('supplierInvoiceID', $invoice)){
			$paidAmount = Payment::where('supplierInvoiceID', $invoice)->sum('paymentAmount');
		}
		$finalAmount = $invoiceAmount - $paidAmount;
		return $finalAmount;		
	}

	function generatePDF($id){
		$pdf = App::make('dompdf.wrapper');
		$payment = Payment::find($id);
		$jobcard = JobCard::find($payment->documentAutoID);
    	$company = Company::find(Sentinel::getUser()->companyID);
		$data = array(
			'jobcard' => $jobcard,
            'company' => $company,
            'payment' => $payment,
		);

		$pdf->loadView('pdf/jobcard_payment_pdf', $data , $data);
		return $pdf->stream();
	}


	function delete($paymentID){
		$payment = Payment::find($paymentID);
		$jobcardID = $payment->documentAutoID;

		$payment->delete();
		return Redirect::to('jobcard/edit/'.$jobcardID.'/payment');
	}
}