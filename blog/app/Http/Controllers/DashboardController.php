<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\RentalOwner;
use App\Model\Tenant;
use App\Model\JobCard;
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

		return view('dashboard', [
	        'propCount' => $propCount,
	        'propOwnerCount' => $propOwnerCount,
	        'unitCount' => $unitCount,
	        'tenantsCount' => $tenantsCount,
	        'jobcardsCount' => $jobcardsCount,
	    ]);
	}
}