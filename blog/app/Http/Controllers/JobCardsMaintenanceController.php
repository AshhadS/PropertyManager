<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\Supplier;
use App\Model\Maintenance;
use Redirect;

class JobCardsMaintenanceController extends Controller
{
	function index(JobCard $jobcard){
    	$jobcard = JobCard::find($jobcard->jobcardID);
    	$maintenanceItensMaterial = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 1)->get();
    	$maintenanceItensLabour = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 2)->get();
    	$maintenanceItensTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('totalAmount');
    	$maintenanceItensCostTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('costAmount');
    	$maintenanceItensProfit = $maintenanceItensTotal - $maintenanceItensCostTotal;
    	$jobcardsAll = JobCard::all();
    	$suppliers = Supplier::all();
		return view('jobcard_maintenance', [
            'jobcard' => $jobcard,
            'jobcardsAll' => $jobcardsAll,
            'suppliers' => $suppliers,
            'maintenanceItensMaterial' => $maintenanceItensMaterial,
            'maintenanceItensLabour' => $maintenanceItensLabour,
            'maintenanceItensTotal' => $maintenanceItensTotal,
            'maintenanceItensCostTotal' => $maintenanceItensCostTotal,
            'maintenanceItensProfit' => $maintenanceItensProfit,
	    ]);
	}

	function create(Request $request){
		$maintenanceItem = New Maintenance();
		$maintenanceItem->description = $request->description;
		$maintenanceItem->GLCode = $request->GLCode;
		$maintenanceItem->comments = $request->comments;
		$maintenanceItem->supplierID = $request->supplierID;
		$maintenanceItem->costAmount = $request->costAmount;
		$maintenanceItem->margin = $request->margin;
		$maintenanceItem->totalAmount = $request->totalAmount;
		$maintenanceItem->itemType = $request->itemType;
		$maintenanceItem->jobcardID = $request->jobcardID;


		/*Total calculation*/
		// Total = cost + percentage of cost 
		// => Therefoe 1 + 0.20 is totalPercentage assuming margin given was 20%
		$totalPercentage = 1 + (intval($request->margin) / 100);
		$maintenanceItem->totalAmount =  $request->costAmount * $totalPercentage;

		$maintenanceItem->save();

	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');
	}

	function update(Request $request){
		$maintenanceItem = Maintenance::find($request->itemID);
		$maintenanceItem->description = $request->description;
		$maintenanceItem->GLCode = $request->GLCode;
		$maintenanceItem->comments = $request->comments;
		$maintenanceItem->supplierID = $request->supplierID;
		$maintenanceItem->costAmount = $request->costAmount;
		$maintenanceItem->margin = $request->margin;
		$maintenanceItem->totalAmount = $request->totalAmount;
		$maintenanceItem->itemType = $request->itemType;
		$maintenanceItem->jobcardID = $request->jobcardID;


		/*Total calculation*/
		// Total = cost + percentage of cost 
		// => Therefoe 1 + 0.20 is totalPercentage assuming margin given was 20%
		$totalPercentage = 1 + (intval($request->margin) / 100);
		$maintenanceItem->totalAmount =  $request->costAmount * $totalPercentage;

		$maintenanceItem->save();
	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');
	}

	function delete($maintenanceItem){
		$item = Maintenance::find($maintenanceItem);
		$jobcardid = $item->jobcardID;
		$item->delete();

	    return Redirect::to('jobcard/edit/'.$jobcardid.'/maintenance');
	}
}