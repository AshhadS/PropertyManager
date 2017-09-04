<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unit;
use App\Model\Property;
use App\Model\RentalOwner;
use App\Model\Tenant;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use App\Model\Agreement;
use App\Model\PaymentType;
use Debugbar;
use Datatables;
use Sentinel;
use Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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


        //Payables

        $TopFivePayables = DB::table('supplier')
        ->Join ( 'supplierinvoice','supplier.supplierID', '=','supplierinvoice.supplierID')
        ->where('supplierinvoice.paymentPaidYN','=',0)
        ->selectRaw('supplier.supplierID, 
            supplier.supplierName, 
            sum(supplierinvoice.amount) AS outstandingAmount')
        ->Orderby('outstandingAmount','DESC')
        ->Groupby('supplier.supplierID', 'supplier.supplierName')
        ->limit(5)
        ->get();

           //Receivables

        $TopFiveReceivables = DB::table('customerinvoice')
        ->Join ( 'rentalowners','customerinvoice.propertyOwnerID', '=','rentalowners.rentalOwnerID')
        ->where('customerinvoice.paymentReceivedYN','=',0)
        ->selectRaw('rentalowners.rentalOwnerID, 
            rentalowners.firstName,
            rentalowners.lastName, 
            sum(customerinvoice.amount) AS outstandingAmount')
        ->Orderby('outstandingAmount','DESC')
        ->Groupby('rentalowners.rentalOwnerID', 'rentalowners.firstName','rentalowners.lastName')
        ->limit(5)
        ->get();


        //Expire Agreements
        $ExpiringAgreemntsOneMonth = DB::table('agreement')
        ->leftJoin('rentalowners','agreement.rentalOwnerID','=','rentalowners.rentalOwnerID')
        ->leftJoin('tenants','agreement.tenantID','=','tenants.tenantsID')
        ->leftJoin('properties','agreement.PropertiesID','=','properties.PropertiesID')
        ->leftJoin('units','agreement.unitID','=','units.unitID')
        ->leftJoin('paymenttype','agreement.paymentTypeID','=','paymenttype.paymentTypeID')
        ->whereBetween('agreement.dateTo', array(Carbon::now(), Carbon::now()->addMonths(1)))
        ->select('agreement.agreementID AS agreementID',
        'agreement.dateTo AS dateTo',
        'agreement.companyID AS companyID',
        'agreement.isPDCYN AS isPDCYN',
        'agreement.dateFrom AS dateFrom',
        'agreement.marketRent AS marketRent',
        'agreement.actualRent AS actualRent',
        'paymenttype.paymentDescription AS paymentDescription',
        'properties.pPropertyName AS pPropertyName',
        'units.unitNumber AS unitNumber',
        'rentalowners.firstName AS rentalOwner',
        'rentalowners.phoneNumber AS rentalOwnerphoneNumber',
        'tenants.phoneNumber AS tenantsphoneNumber',
        'tenants.firstName AS tenantsfirstName')
        ->get();
        $ExpiringAgreemntsOneMonthCount = DB::table('agreement')->whereBetween('dateTo', array(Carbon::now(), Carbon::now()->addMonths(1)))->count();
    
        $ExpiringAgreemntsTwoMonthCount = DB::table('agreement')->whereBetween('dateTo', array(Carbon::now()->addMonths(1), Carbon::now()->addMonths(2)))->count();
        $ExpiringAgreemntsThreeMonthCount = DB::table('agreement')->whereBetween('dateTo', array(Carbon::now()->addMonths(2), Carbon::now()->addMonths(3)))->count();


       // BETWEEN (CURDATE() + INTERVAL 1 MONTH) AND (CURDATE() + INTERVAL 2 MONTH)

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
	        'ExpiringAgreemntsOneMonth' => $ExpiringAgreemntsOneMonth,
            'ExpiringAgreemntsOneMonthCount'=> $ExpiringAgreemntsOneMonthCount,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'paymentypes' => $paymentypes,
	        'agreements' => $agreements,
            'TopFivePayables' => $TopFivePayables,
            'TopFiveReceivables' => $TopFiveReceivables,

            
            
	    ]);
	}

	 function getFields($agreementid){
        $agreement = Agreement::where('agreementID', $agreementid)->get();
        return $agreement;
    }
}