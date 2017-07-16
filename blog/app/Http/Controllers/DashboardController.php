<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\RentalOwner;
use App\Model\Tenant;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use Debugbar;
use Datatables;
use Sentinel;
use Redirect;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

	function index(){
		$propCount = Property::count();
		$propOwnerCount = RentalOwner::count();
		$unitCount = Unit::count();
		$tenantsCount = Tenant::count();
		$jobcardsCount = JobCard::count();

		$jobCardStatusAll = JobCardStatus::all();
        $jobCardStatusCount = array();

        foreach ($jobCardStatusAll as $status) {
            $count = JobCard::where('jobcardStatusID', $status->jobcardStatusID)->count();
            $jobCardStatusCount[$status->jobcardStatusID] = $count;
        }

		return view('dashboard', [
	        'propCount' => $propCount,
	        'propOwnerCount' => $propOwnerCount,
	        'unitCount' => $unitCount,
	        'tenantsCount' => $tenantsCount,
	        'jobcardsCount' => $jobcardsCount,
	        'jobCardStatusCount' => $jobCardStatusCount,
	    ]);
	}
}