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
use App\Model\Bank;
use App\Model\BankAccount;
use Debugbar;
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

			$duePayment = $invoice->amount - Payment::where('supplierInvoiceID', $invoice->supplierInvoiceID)->where('documentID', 5)->where('documentAutoID', $request->jobcardID)->sum('paymentAmount');

			// Payment Made Y/N
			if($request->paymentAmount && $duePayment > $request->paymentAmount){
				// partially paid
				$invoice->paymentPaidYN = 1;
			}else{
				// fully paid
				$invoice->paymentPaidYN = 2;
			}
			$invoice->save();

		}
		if($request->supplierID)
			$payment->supplierID = $request->supplierID;

		$payment->paymentAmount = $request->paymentAmount;
		$payment->paymentTypeID = $request->paymentTypeID;
		$payment->documentID = 5;
		$payment->documentAutoID = $request->jobcardID;
		$payment->paymentTypeID = $request->paymentTypeID;
		
		$payment->chequeNumber = $request->chequeNumber;
		if($request->chequeNumber == '')
			$payment->chequeNumber = 0;

		if($request->chequeDate)
			$payment->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');	
		if($request->paymentDate)
			$payment->paymentDate = date_create_from_format("j/m/Y", $request->paymentDate)->format('Y-m-d');	

		$payment->bankAccountID = $request->bankAccountID;
		$payment->bankmasterID = $request->bankmasterID;
		
		$payment->lastUpdatedByUserID = Sentinel::getUser()->id;
		$payment->save();

		return Redirect::to('jobcard/edit/'.$request->jobcardID.'/payment');
	}

	function index($jobcard){
		$jobcard = JobCard::find($jobcard);
		$suppliers = Supplier::all();
		$payments = Payment::where('documentID', 5)->where('documentAutoID', $jobcard->jobcardID)->get();
		$paymentTypes = PaymentType::all();
		$banks = Bank::all();
		$accounts = BankAccount::all();
		return view('jobcard_payment', [
            'jobcard' => $jobcard,
            'suppliers' => $suppliers,
            'payments' => $payments,
            'paymentTypes' => $paymentTypes,
            'banks' => $banks,
            'accounts' => $accounts,
            
	    ]);
	}

	function getInvoiceItems(Request $request){
		$invoice = SupplierInvoice::where('supplierID', $request->supplier)->where('jobcardID', $request->jobcard)->where('paymentPaidYN', '!=', 2)->get();
		return $invoice;
	}

	function getInvoiceAmount($invoice){
		// Check if payment has been made before
		$invoiceAmount = SupplierInvoice::find($invoice)->amount;
		$supplierInvoice = SupplierInvoice::find($invoice);
		$paidAmount = 0;
		if(Payment::where('supplierInvoiceID', $invoice)){
			$paidAmount = Payment::where('supplierID', $supplierInvoice->supplierID)->where('supplierInvoiceID', $invoice)->where('documentID', 5)->where('documentAutoID', $supplierInvoice->jobCardID)->sum('paymentAmount');
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

		if(isset($payment->supplierInvoiceID)){
			$invoice = SupplierInvoice::find($payment->supplierInvoiceID);
			
			// All payments for invoice - this payment
			$thisPaymentAmount = Payment::where('supplierInvoiceID', $payment->supplierInvoiceID)->first()->paymentAmount;
			$allPaymentAmount = Payment::where('supplierInvoiceID', $payment->supplierInvoiceID)->sum('paymentAmount');
			$balence = $allPaymentAmount - $thisPaymentAmount;

			if($balence > 0){
				$invoice->paymentPaidYN = 1;
			}else{
				$invoice->paymentPaidYN = 0;
			}
			$invoice->save();				
		}

		$payment->delete();
		return Redirect::to('jobcard/edit/'.$jobcardID.'/payment');
	}
}