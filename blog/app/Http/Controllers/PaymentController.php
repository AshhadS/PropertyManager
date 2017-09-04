<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\RentalOwner;
use App\Model\Maintenance;
use App\Model\Company;
use App\Model\Property;
use App\Model\CustomerInvoice;
use App\Model\Payment;
use App\Model\PaymentType;
use Redirect;
use Sentinel;
use App;

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
		$payment->save();

		return Redirect::back();
	}


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