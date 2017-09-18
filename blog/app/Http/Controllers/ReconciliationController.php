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
use App\Model\Reconciliation;
use App\Model\Receipt;
use Debugbar;
use App\Model\PaymentType;
use Redirect;
use Sentinel;
use Carbon\Carbon;
use App;

class ReconciliationController extends Controller{
	

		function showAll($bankAcccountID){

			$banks = Bank::all();
			$accounts = BankAccount::all();
			$reconciliaions = Reconciliation::where('bankAccountID', $bankAcccountID)->get();
			$thisAccount = BankAccount::find($bankAcccountID);

			return view('reconciliations', [
				'banks' => $banks,
				'accounts' => $accounts,
				'thisAccount' => $thisAccount,
				'reconciliaions' => $reconciliaions,
			]);
		}

		function allAccounts(){
			$accounts = BankAccount::orderBy('bankMasterID', 'desc')->get();

			return view('allaccounts', [
				'accounts' => $accounts,
			]);
		}

		function createItem(Request $request){
			$reconciliaion = new Reconciliation();
			// dd($request->bankAccountID);
			$date = date_create_from_format("j/m/Y", $request->reconciliationDate);
			$reconciliaion->asOfDate = $date->format('Y-m-d');
			$reconciliaion->month = $date->format('m');
			$reconciliaion->year = $date->format('y');

			$reconciliaion->bankMasterID = $request->bankMasterID ;
			$reconciliaion->bankAccountID = $request->bankAccountID ;
			$reconciliaion->narration = $request->narration ;
			$reconciliaion->createdUserID = Sentinel::getUser()->id ;
			$reconciliaion->createdDate = Carbon::now() ;
			$reconciliaion->timestamp = Carbon::now() ;
			$reconciliaion->createdDate = Carbon::now() ;
			$reconciliaion->submittedYN = 0;
			$reconciliaion->submittedByUserID = 0;
			$reconciliaion->save();

			return Redirect::to($request->bankAccountID.'/reconciliation');
		}

		function showItems($reconciliation){			
			$reconciliation = Reconciliation::find($reconciliation);

			if($reconciliation->submittedYN == 1){ //Reconciliation submitted - show only cleared items
				$receipts = Receipt::where('bankAccountID', $reconciliation->bankAccountID)->where('clearedYN','1')->get();
				$payments = Payment::where('bankAccountID', $reconciliation->bankAccountID)->where('clearedYN','1')->get();
			}else{ //Reconciliation not submitted - show all items
				$receipts = Receipt::where('bankAccountID', $reconciliation->bankAccountID)->get();
				$payments = Payment::where('bankAccountID', $reconciliation->bankAccountID)->get();
			}
			$thisAccount = BankAccount::find($reconciliation->bankAccountID);
			return view('reconciliationsitems', [
				'reconciliation' => $reconciliation,
				'thisAccount' => $thisAccount,
				'receipts' => $receipts,
				'payments' => $payments,
			]);
		}


		function clearCheque(Request $request){
			if($request->type == 'receipt'){
				$receipt = Receipt::find($request->id);
				if($receipt->clearedYN != '1'){
					$receipt->clearedYN = '1';
					$receipt->clearedDate = Carbon::now();
					$receipt->clearedAmount = $receipt->receiptAmount;
					$receipt->bankReconciliationID = $request->reconciliation;
					$receipt->clearedUserID = Sentinel::getUser()->id;
				}else{
					$receipt->clearedYN = '0';
					$receipt->clearedDate = NULL;
					$receipt->clearedAmount = '0';
					$receipt->bankReconciliationID = '0';
					$receipt->clearedUserID = NULL;
				}
				$receipt->save();
			}


			if($request->type == 'payment'){
				$payment = Payment::find($request->id);
				if($payment->clearedYN != '1'){
					$payment->clearedYN = '1';
					$payment->clearedDate = Carbon::now();
					$payment->clearedAmount = $payment->paymentAmount;
					$payment->bankReconciliationID = $request->reconciliation;
					$payment->clearedUserID = Sentinel::getUser()->id;
				}else{
					$payment->clearedYN = '0';
					$payment->clearedDate = NULL;
					$payment->clearedAmount = '0';
					$payment->bankReconciliationID = '0';
					$payment->clearedUserID = NULL;
				}
				$payment->save();

			}			
			return 'true';			
		}

		function submitHandler(Request $request){
			$reconciliation = Reconciliation::find($request->reconciliation);
			$reconciliation->submittedYN = '1';
			$reconciliation->submittedByUserID = Sentinel::getUser()->id;
			$reconciliation->save();

			return Redirect::to('/reconciliation/'.$request->reconciliation.'/items');
		}

		function editItem(Request $request){
			$reconciliaion = Reconciliation::find($reconciliation);
		}

		function deleteItem($reconciliation){
			$reconciliaion = Reconciliation::find($reconciliation);
			$bankAccountID = $reconciliaion->bankAccountID;
			$reconciliaion->delete();
			return Redirect::to($bankAccountID.'/reconciliaion');
		}
}