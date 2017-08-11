<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\RentalOwner;
use App\Model\Tenant;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use App\Model\ExpiringAgreemntsOneMonth;
use App\Model\ExpiringAgreemntsTwoMonth;
use App\Model\ExpiringAgreemntsThreeMonth;
use App\Model\Agreement;
use App\Model\PaymentType;
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

		$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
        $paymentypes = PaymentType::all();
        $agreements = Agreement::all();

		$jobCardStatusAll = JobCardStatus::all();
        $jobCardStatusCount = array();

        //Expire Agreements
      //  $ExpiringAgreemntsTwoMonthCount=ExpiringAgreemntsTwoMonth::count();
      //  $ExpiringAgreemntsThreeMonthCount=ExpiringAgreemntsThreeMonth::count();
		$ExpiringAgreemntsTwoMonthCount=2;
		$ExpiringAgreemntsThreeMonthCount=1;
	  
      //  $ExpiringAgreemntsOneMonth = ExpiringAgreemntsOneMonth::all();

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
	        'ExpiringAgreemntsThreeMonthCount' => $ExpiringAgreemntsThreeMonthCount,
	        'ExpiringAgreemntsTwoMonthCount' => $ExpiringAgreemntsTwoMonthCount,
	        
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'paymentypes' => $paymentypes,
	        'agreements' => $agreements,
	    ]);
	}

	 function getFields($agreementid){
        $agreement = Agreement::where('agreementID', $agreementid)->get();
        return $agreement;
    }
}