<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\Supplier;
use App\Model\Maintenance;
use App\Model\Company;
use Redirect;
use Sentinel;
use App;

class JobCardsMaintenanceController extends Controller
{
	function index(JobCard $jobcard){
    	$jobcard = JobCard::find($jobcard->jobcardID);
    	$maintenanceItensMaterial = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 1)->get();
    	$maintenanceItensLabour = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 2)->get();
    	$maintenanceItensTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('netTotal');
    	$maintenanceItensMeterialsTotal = Maintenance::where('itemType', 1)->where('jobcardID', $jobcard->jobcardID)->sum('netTotal');
    	$maintenanceItensLabourTotal = Maintenance::where('itemType', 2)->where('jobcardID', $jobcard->jobcardID)->sum('netTotal');

    	$jobcardsAll = JobCard::all();
    	$suppliers = Supplier::all();

		return view('jobcard_maintenance', [
            'jobcard' => $jobcard,
            'jobcardsAll' => $jobcardsAll,
            'suppliers' => $suppliers,
            'maintenanceItensMaterial' => $maintenanceItensMaterial,
            'maintenanceItensLabour' => $maintenanceItensLabour,
            'maintenanceItensTotal' => $maintenanceItensTotal,
            'maintenanceItensMeterialsTotal' => $maintenanceItensMeterialsTotal,
            'maintenanceItensLabourTotal' => $maintenanceItensLabourTotal,
	    ]);
	}

	function create(Request $request){
		$maintenanceItem = New Maintenance();
		$maintenanceItem->description = $request->description;
		$maintenanceItem->GLCode = $request->GLCode;
		$maintenanceItem->comments = $request->comments;
		$maintenanceItem->supplierID = $request->supplierID;
		$maintenanceItem->units = $request->units;
		$maintenanceItem->cost = $request->cost;
		$maintenanceItem->total = $request->cost * $request->units;
		$maintenanceItem->margin = $request->margin;
		$maintenanceItem->netTotal = $request->netTotal;
		$maintenanceItem->itemType = $request->itemType;
		$maintenanceItem->jobcardID = $request->jobcardID;


		/*Total calculation*/
		// Total = cost + percentage of cost 
		// => Therefoe 1 + 0.20 is totalPercentage assuming margin given was 20%
		$totalPercentage = 1 + (intval($request->margin) / 100);
		$maintenanceItem->netTotal =  $maintenanceItem->total * $totalPercentage;

		$maintenanceItem->save();

	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');
	}

	function update(Request $request){
		$maintenanceItem = Maintenance::find($request->itemID);
		$maintenanceItem->description = $request->description;
		$maintenanceItem->GLCode = $request->GLCode;
		$maintenanceItem->comments = $request->comments;
		$maintenanceItem->supplierID = $request->supplierID;
		$maintenanceItem->units = $request->units;
		$maintenanceItem->cost = $request->cost;
		$maintenanceItem->total = $request->cost * $request->units;
		$maintenanceItem->margin = $request->margin;
		$maintenanceItem->netTotal = $request->netTotal;
		$maintenanceItem->itemType = $request->itemType;
		$maintenanceItem->jobcardID = $request->jobcardID;


		/*Total calculation*/
		// Total = cost + percentage of cost 
		// => Therefoe 1 + 0.20 is totalPercentage assuming margin given was 20%
		$totalPercentage = 1 + (intval($request->margin) / 100);
		$maintenanceItem->netTotal =  $maintenanceItem->total * $totalPercentage;

		$maintenanceItem->save();
	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');
	}

	function delete($maintenanceItem){
		$item = Maintenance::find($maintenanceItem);
		$jobcardid = $item->jobcardID;
		$item->delete();

	    return Redirect::to('jobcard/edit/'.$jobcardid.'/maintenance');
	}

	function submitMaintenance(Request $request){
		$jobcard = JobCard::find($request->jobcardID);
		$jobcard->isSubmitted = ($request->flag == '1') ? '0' : '1';
		$jobcard->save();
	    return Redirect::to('jobcard/edit/'.$request->jobcardID.'/maintenance');
		
	}

	function generatePDF($jobcardID){
		$pdf = App::make('dompdf.wrapper');
		$jobcard = JobCard::find($jobcardID);
    	$maintenanceItensMaterial = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 1)->get();
    	$maintenanceItensLabour = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 2)->get();
    	$maintenanceItensTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('netTotal');
    	$maintenanceItensCostTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('total');
    	$maintenanceItensProfit = $maintenanceItensTotal - $maintenanceItensCostTotal;
    	$company = Company::find(Sentinel::getUser()->companyID);
		$data = array(
			'jobcard' => $jobcard,
            'maintenanceItensMaterial' => $maintenanceItensMaterial,
            'maintenanceItensLabour' => $maintenanceItensLabour,
            'maintenanceItensTotal' => $maintenanceItensTotal,
            'maintenanceItensCostTotal' => $maintenanceItensCostTotal,
            'maintenanceItensProfit' => $maintenanceItensProfit,
            'company' => $company,
		);

		$pdf->loadView('maintainence_pdf', $data , $data);
		return $pdf->stream();
	}

	function displaypdf($jobcardID){
		$jobcard = JobCard::find($jobcardID);
    	$maintenanceItensMaterial = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 1)->get();
    	$maintenanceItensLabour = Maintenance::where('jobcardID', $jobcard->jobcardID)->where('itemType', 2)->get();
    	$maintenanceItensTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('netTotal');
    	$maintenanceItensCostTotal = Maintenance::where('jobcardID', $jobcard->jobcardID)->sum('total');
    	$maintenanceItensProfit = $maintenanceItensTotal - $maintenanceItensCostTotal;
    	$company = Company::find(Sentinel::getUser()->companyID);
		$data = array(
			'jobcard' => $jobcard,
            'maintenanceItensMaterial' => $maintenanceItensMaterial,
            'maintenanceItensLabour' => $maintenanceItensLabour,
            'maintenanceItensTotal' => $maintenanceItensTotal,
            'maintenanceItensCostTotal' => $maintenanceItensCostTotal,
            'maintenanceItensProfit' => $maintenanceItensProfit,
            'company' => $company,
		);

		return view('maintainence_pdf', $data);
	}
}