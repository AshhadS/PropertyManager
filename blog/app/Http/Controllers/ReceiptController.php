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
use App\Model\Bank;
use App\Model\BankAccount;
use Redirect;
use Sentinel;
use App;
use Carbon\Carbon;

class ReceiptController extends Controller
{
	function createReceipt(Request $request){
		$receipt = new Receipt();
		$receipt->receiptAmount = $request->amount;
		$receipt->paymentTypeID = $request->paymentTypeID;
		$receipt->chequeNumber = $request->chequeNumber;
		if($request->chequeDate)
			$receipt->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');
		if($request->receiptDate)
			$receipt->receiptDate = date_create_from_format("j/m/Y", $request->receiptDate)->format('Y-m-d');
		$receipt->lastUpdatedByUserID = Sentinel::getUser()->id;
		$receipt->documentID = $request->documentID;
		$receipt->documentAutoID = $request->documentAutoID;
		
		$receipt->bankAccountID = $request->bankAccountID;
		$receipt->bankmasterID = $request->bankmasterID;
		
		$receipt->save();

		return Redirect::back();
	}

	function updateReceipt(Request $request){
		$receipt = Receipt::find($request->receiptID);
		$receipt->receiptAmount = $request->amount;
		$receipt->paymentTypeID = $request->paymentTypeID;
		$receipt->chequeNumber = $request->chequeNumber;
		if($request->chequeDate)
			$receipt->chequeDate = date_create_from_format("j/m/Y", $request->chequeDate)->format('Y-m-d');
		if($request->receiptDate)
			$receipt->receiptDate = date_create_from_format("j/m/Y", $request->receiptDate)->format('Y-m-d');
		$receipt->lastUpdatedByUserID = Sentinel::getUser()->id;

		$receipt->bankAccountID = $request->bankAccountID;
		$receipt->bankmasterID = $request->bankmasterID;
		
		$receipt->save();

		return Redirect::back();
	}


	// function generatePDF($id){
	// 	$pdf = App::make('dompdf.wrapper');
	// 	$receipt = Receipt::find($id);
	// 	$jobcard = JobCard::find($receipt->jobCardID);
 //    	$company = Company::find(Sentinel::getUser()->companyID);
	// 	$data = array(
	// 		'jobcard' => $jobcard,
 //            'company' => $company,
 //            'receipt' => $receipt,
	// 	);

	// 	$pdf->loadView('pdf/jobcard_receipt_pdf', $data , $data);
	// 	return $pdf->stream();
	// }

	function submitHandler(Request $request){
        $receipt = Receipt::find($request->receiptID);

        $receipt->submittedYN = ($request->flag == '1') ? '0' : '1';
        $receipt->submittedDate = Carbon::now();
        $receipt->submittedUserID = Sentinel::getUser()->id;
        $receipt->save();

        return Redirect::back();
    }

	function delete($receiptID){
		$receipt = Receipt::find($receiptID);
		$receipt->delete();
		return Redirect::back();
	}
}