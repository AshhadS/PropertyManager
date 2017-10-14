<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\RentalOwner;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\CustomerInvoice;
use App\Model\SupplierInvoice;
use App\Model\Payment;
use App\Model\PaymentType;
use App\Model\GeneralLedger;
use App\Model\BankAccount;
use Redirect;
use Sentinel;
use App;
use Carbon\Carbon;

class PaymentController extends Controller
{
	function createPayment(Request $request){
		$payment = new Payment();
		$payment->paymentAmount = $request->amount;
		$payment->paymentTypeID = $request->paymentTypeID;
		$payment->chequeNumber = $request->chequeNumber;
		if($request->chequeDate)
			$payment->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');
		if($request->paymentDate)
			$payment->paymentDate = date_create_from_format("j/m/Y", $request->paymentDate)->format('Y-m-d');
		$payment->lastUpdatedByUserID = Sentinel::getUser()->id;
		$payment->documentID = $request->documentID;
		$payment->documentAutoID = $request->documentAutoID;

		$payment->bankAccountID = $request->bankAccountID;
		$payment->bankmasterID = $request->bankmasterID;
		
		$payment->save();

		return Redirect::back();
	}

	function updatePayment(Request $request){
		$payment = Payment::find($request->paymentID);
		$payment->paymentAmount = $request->amount;
		$payment->paymentTypeID = $request->paymentTypeID;
		$payment->chequeNumber = $request->chequeNumber;
		if($request->chequeDate)
			$payment->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');
		if($request->paymentDate)
			$payment->paymentDate = date_create_from_format("j/m/Y", $request->paymentDate)->format('Y-m-d');
		$payment->lastUpdatedByUserID = Sentinel::getUser()->id;

		$payment->bankAccountID = $request->bankAccountID;
		$payment->bankmasterID = $request->bankmasterID;
		
		$payment->save();

		return Redirect::back();
	}

	function submitHandler(Request $request){
        $payment = Payment::find($request->paymentID);
        $paymentCode = sprintf("PAY%'05d\n", $request->paymentID);
		// Manually populate jobcard 
        $GLCredit = BankAccount::find($payment->bankAccountID)->chartOfAccountID; // get the dynamic gl code from 
		$jobcardID = -1; // getting property data from agreement when payment does not belong to a jobcard

		//From Jobcard 
		if($payment->documentID == '5')
	        $GLDebit = 1;			
		
		//From Agreement 
		if($payment->documentID == '8')
	        $GLDebit = 5;			
		
		// Check if jobcard has invoice and get data from that or else get from agreemnt -----/\
		if(SupplierInvoice::find($payment->supplierInvoiceID))
			$jobcardID = SupplierInvoice::find($payment->supplierInvoiceID)->jobCardID;

        GeneralLedger::addEntry($payment->paymentID, 10, $paymentCode, $payment->paymentDate, $jobcardID, $payment->supplierID, 1, $payment->invoiceSystemCode, $GLDebit, $GLCredit, $payment->paymentAmount);

        $payment->submittedYN = ($request->flag == '1') ? '0' : '1';
        $payment->submittedDate = Carbon::now();
        $payment->submittedUserID = Sentinel::getUser()->id;
        $payment->save();

        return Redirect::back();
    }


	//From Agreements 


	// function generatePDF($id){
	// 	$pdf = App::make('dompdf.wrapper');
	// 	$payment = Receipt::find($id);
	// 	$jobcard = JobCard::find($payment->jobCardID);
 //    	$company = Company::find(Sentinel::getUser()->companyID);
	// 	$data = array(
	// 		'jobcard' => $jobcard,
 //            'company' => $company,
 //            'receipt' => $payment,
	// 	);

	// 	$pdf->loadView('pdf/jobcard_receipt_pdf', $data , $data);
	// 	return $pdf->stream();
	// }

	function delete($paymentID){
		$payment = Payment::find($paymentID);
		$payment->delete();
		return Redirect::back();
	}
}