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

			return Redirect::to($request->bankAccountID.'/reconciliaion');
		}

		function showItems($reconciliation){			
			$reconciliation = Reconciliation::find($reconciliation);
			$receipts = Receipt::where('bankAccountID', $reconciliation->bankAccountID)->where('clearedYN', "!=" ,'1')->get();
			$payments = Payment::where('bankAccountID', $reconciliation->bankAccountID)->where('clearedYN', "!=" ,'1')->get();
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
				$receipt->clearedYN = '1';
				$receipt->clearedDate = Carbon::now();
				$receipt->clearedAmount = $receipt->receiptAmount;
				$receipt->clearedUserID = Sentinel::getUser()->id;
				$receipt->save();
				return true;

			}else if($request->type == 'payment'){
				$payment = Payment::find($request->id);
				$payment->clearedYN = '1';
				$payment->clearedDate = Carbon::now();
				$payment->clearedAmount = $payment->paymentAmount;
				$payment->clearedUserID = Sentinel::getUser()->id;
				$payment->save();
				return true;

			}
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