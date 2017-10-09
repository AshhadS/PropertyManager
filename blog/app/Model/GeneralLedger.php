<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Redirect;
use App\Model\JobCard;


class GeneralLedger extends Model
{
    protected $table = 'generalledger';

    protected $primaryKey = 'generalLedgerID';

    // Remove all timestamps
    public $timestamps = false;	

    public static function addEntry($documentAuotID, $documentType, $documentCode, $documentDate, $jobCardID, $supplierOrCustomerID, $currency, $description, $accountCode1, $accountCode2, $amount){
    	if($jobCardID != -1){
		    $jobcard = GeneralLedger::getJobcard($jobCardID, $documentType);
    	}else{
    		// Manually populate
    		$jobcard = new JobCard;
    		if($documentType == '9')
	    		$agreementID = Receipt::find($documentAuotID)->documentAutoID; 

	    	if($documentType == '10')
	    		$agreementID = Payment::find($documentAuotID)->documentAutoID; 

    		$agreement = Agreement::find($agreementID);
    		$jobcard->PropertiesID = $agreement->PropertiesID;
    		$jobcard->tenantsID = $agreement->tenantID;
    		$jobcard->rentalOwnerID = $agreement->rentalOwnerID;
    		$jobcard->unitID = $agreement->unitID;
    	}
    	// Reverese General Ledger
	    if(GeneralLedger::where('documentAuotID', $documentAuotID)->where('documentType', $documentType)->first()){
	    	GeneralLedger::where('documentAuotID', $documentAuotID)->where('documentType', $documentType)->delete();
	        return Redirect::back();	    	
	    }
    	// Update General Ledger
        $gl1 = new GeneralLedger;

        $gl1->documentAuotID = $documentAuotID;
        $gl1->documentType = $documentType;
        $gl1->documentCode =  $documentCode;
        $gl1->documentDate = $documentDate;
        $gl1->propertyOwnerID = $jobcard->rentalOwnerID;
        $gl1->propertyID = $jobcard->PropertiesID;
        $gl1->unitID = $jobcard->unitID;
        $gl1->tenantID = $jobcard->tenantsID;
        $gl1->description = $description;
        $gl1->supplierOrCustomerID = $supplierOrCustomerID;
        $gl1->currency = 1;

        // Copying object since properties are the same
        $gl2 = clone $gl1;

        // Debit
        $gl1->accountCode = $accountCode1;
        $gl1->amount = $amount;

        // Credit
        $gl2->accountCode = $accountCode2;
        $gl2->amount = 0 - $amount;

        $gl1->save();
        $gl2->save();
        return Redirect::back();
    }

    // function reverseEntry($documentID, $documentAuotID){

    // }


    public static function getJobcard($jobcardID, $documentID){
    	if($documentID != 0){
    		// return 
    	}
	    return JobCard::find($jobcardID);

    }


}
