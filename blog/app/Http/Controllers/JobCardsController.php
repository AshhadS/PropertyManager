<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use App\Model\JobCardComment;
use App\Model\JobCardType;
use App\Model\JobCardLog;
use App\Model\JobCardPriority;
use App\Model\Unit;
use App\Model\Property;
use App\Model\Tenant;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\User;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;
use File;
use Storage;
use Carbon\Carbon;

class JobCardsController extends Controller
{
    function index() {
        $openJobcards = JobCard::where('jobcardStatusID', '!=' , 4)->orderBy('lastUpdatedDateTime', 'ASC')->get();
        $closedJobcards = JobCard::where('jobcardStatusID', 4)->orderBy('lastUpdatedDateTime', 'ASC')->get();
        $myJobcards = JobCard::where('assignedToID', Sentinel::getUser()->id)->orderBy('lastUpdatedDateTime', 'ASC')->get();

        $openCount = JobCard::where('jobcardStatusID', '!=' , 4)->count();
        $closedCount = JobCard::where('jobcardStatusID', 4)->count();
        $myCount = JobCard::where('assignedToID', Sentinel::getUser()->id)->count();
        $pendingCount = JobCard::where('jobcardStatusID', 6)->count();

    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
    	$jobcardstatuss = JobCardStatus::all();
        $jobcardcomments = JobCardComment::all();//---------------
        $jobcardlog = JobCardLog::all();//-------------------
        $jobcardprioritys = JobCardPriority::all();
        $jobcardtypes = JobCardType::all();
    	
    	// Debugbar::info($tenants);
	    return view('jobcards', [
            'openJobcards' => $openJobcards,
            'closedJobcards' => $closedJobcards,
            'myJobcards' => $myJobcards,
            'openCount' => $openCount,
            'closedCount' => $closedCount,
            'pendingCount' => $pendingCount,
            'myCount' => $myCount,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
            'jobcardstatuss' => $jobcardstatuss,
            'jobcardcomments' => $jobcardcomments,
            'jobcardlog' => $jobcardlog,
            'jobcardprioritys' => $jobcardprioritys,
	        'jobcardtypes' => $jobcardtypes,
	    ]);
    }
    
    function data(){
    	$t = DB::table('jobcard')
    		->leftJoin('tenants', 'jobcard.tenantsID', '=', 'tenants.tenantsID')
    		->leftJoin('units', 'jobcard.unitID', '=', 'units.unitID')
    		->leftJoin('properties', 'jobcard.PropertiesID', '=', 'properties.PropertiesID')
    		->leftJoin('jobcardstatus', 'jobcard.jobcardStatusID', '=', 'jobcardstatus.jobcardStatusID')
    		->leftJoin('users', 'jobcard.createdByUserID', '=', 'users.id')
    		->select('jobcard.jobcardID', 'jobcard.subject', 'jobcard.description', 'properties.pPropertyName', 'jobcardstatus.statusDescription', 'units.unitNumber' , 'tenants.firstName', 'jobcard.createdDateTime', 'users.first_name');
    		// Debugbar::info($t);
    	return Datatables::of($t)->make(true);

    }

    function create(Request $request) {
	    $jobcard = new JobCard;
	    // dd(Sentinel::getUser()->companyID);
	    $jobcard->subject = $request->subject;
	    $jobcard->description = $request->description;
	    $jobcard->jobcardStatusID = $request->jobcardStatusID;
	    ($request->PropertiesID != 0) ? $jobcard->PropertiesID = $request->PropertiesID : false; // do not save if 0 was selected
	    $jobcard->rentalOwnerID = $request->rentalOwnerID;
	    $jobcard->tenantsID = $request->tenantsID;
	    $jobcard->unitID =$request->unitID;
	    $jobcard->companyID = Sentinel::getUser()->companyID;
	    $jobcard->documentID = 5;
        $jobcard->serialNo = 0;
        $jobcard->jobCardCode = '#JC-4002';
        $jobcard->priorityID = null;
        $jobcard->jobcardTypeID = null;
        $jobcard->createdByUserName = Sentinel::getUser()->first_name;

	
	    $jobcard->save();

	    return Redirect::to('jobcards');
    }

    function edit(JobCard $jobcard){
    	$jobcard = JobCard::find($jobcard->jobcardID);
    	$units = Unit::all();
    	$properties = Property::all();
    	$tenants = Tenant::all();
    	$jobcardstatuss = JobCardStatus::all();
    	$documentmaster = DocumentMaster::all();
    	$attachments = Attachment::where('documentAutoID', $jobcard->jobcardID)->where('documentID', 5)->get();
    	$tenant_name = ($jobcard->tenantsID ) ? Tenant::find($jobcard->tenantsID)->firstName : '';
    	$unit_number = (Unit::find($jobcard->unitID)) ? Unit::find($jobcard->unitID)->unitNumber : '';
    	$property_name = (Property::find($jobcard->PropertiesID) ) ? Property::find($jobcard->PropertiesID)->pPropertyName : '';
    	$created_at = $jobcard->createdDateTime;
    	$created_by = Sentinel::findById($jobcard->createdByUserID)->first_name;
        $jobcardtypes = JobCardType::all();
        $jobcardpriority = JobCardPriority::all();


        $users = User::where('companyID', Sentinel::getUser()->companyID)->get();

        $logs = JobCardLog::where('jobCardID', $jobcard->jobcardID)->get();
	    return view('jobcards_edit', [
	        'jobcard' => $jobcard,
	        'units' => $units,
	        'properties' => $properties,
	        'tenants' => $tenants,
	        'attachments' => $attachments,
	        'documentmaster' => $documentmaster,
	        'tenant_name' => $tenant_name,
	        'unit_number' => $unit_number,
	        'property_name' => $property_name,
	        'jobcardstatuss' => $jobcardstatuss,
	        'created_at' => $created_at,
            'created_by' => $created_by,
            'logs' => $logs,
            'jobcardtypes' => $jobcardtypes,
            'jobcardprioritys' => $jobcardpriority,
	        'users' => $users,
	    ]);
    }

    function update(Request $request){  
        $jobcard = JobCard::find($request->pk);

        $log = new JobCardLog;
        $log->originalValue = ($jobcard->{$request->name}) ? $jobcard->{$request->name} : 0; //old value
        $log->field = $request->field;
        $log->newValue = $request->value;
        $log->jobCardID = $request->pk;
        $log->updatedByEmpID = Sentinel::getUser()->id;
        $log->updatedByEmpName = Sentinel::getUser()->first_name;
        $log->timestamp = Carbon::now(); //formatted date time
        $log->updatedTime = Carbon::now(); //formatted date time
        $log->pageLink = 'jobcard/edit/' . $request->pk; //formatted date time
        $log->history = $this->getFinalMessage($request->field, $request->value);

        $jobcard->{$request->name} = $request->value;

        $jobcard->save();
        $log->save();
        dd($jobcard);

        return $log;

    }


    function old_update(Request $request){	
        // dd($request);
    	$jobcard = JobCard::find($request->jobcardID);
    	$jobcard->subject = $request->subject;
	    $jobcard->description = $request->description;
	    $jobcard->jobcardStatusID = $request->jobcardStatusID;
	    $jobcard->PropertiesID = $request->PropertiesID;
	    $jobcard->rentalOwnerID = $request->rentalOwnerID;
	    $jobcard->tenantsID = $request->tenantsID;
	    $jobcard->unitID = $request->unitID;

	    $jobcard->save();
	    return Redirect::to('jobcards');
    }

    function getUnitsForProperty($propertyId){
    	$units = Unit::where('propertiesID', $propertyId)->get(['unitID', 'unitNumber']);
    	return $units;
    }


    function saveAttachment(Request $request){
        // return 'Blocked Uploads' ;
        $attachment = new Attachment();
        $attachment->documentID  = $request->documentID;
        $attachment->documentAutoID = $request->documentAutoID;
        $attachment->uploadedByUserID = Sentinel::getUser()->id;
        $attachment->companyID = Sentinel::getUser()->companyID;

        // File upload
        if($request->hasFile('file')){
            $file = $request->file('file')[0]; //using [0] to get the first item
            $attachment->fileName = $file->getClientOriginalName();
            $attachment->fileNameSlug = $request->documentID . '_' . $request->documentAutoID .'_'.time().'.' . $file->getClientOriginalExtension();
            Storage::put('uploads/attachments/'.$attachment->fileNameSlug, file_get_contents($file));
        }

        $attachment->save();

        return 'File Saved';
    }

    function getAttachements($jobcardid){
        $attachemnts = Attachment::where("documentAutoID", $jobcardid)->where("documentID", 5)->get();
        $imageAnswer = [];

        foreach ($attachemnts as $attachemnt) {
            $imageAnswer[] = [
                'original' => $attachemnt->fileNameSlug,
                'server' => $attachemnt->fileNameSlug,
                'size' => File::size(storage_path('app\\uploads\\attachments\\' . $attachemnt->fileNameSlug)),
            ];
        }
        // dd($imageAnswer);

        return response()->json([
            'images' => $imageAnswer
        ]);
    }

    function getFinalMessage($field, $value){
        switch ($field) {
            case "Status":
                $value = JobCardStatus::find($value)->statusDescription;
                break;
            case "Type":
                $value = JobCardType::find($value)->jobcardTypeDescription;
                break;
            case "Priority":
                $value = JobCardPriority::find($value)->priorityDescription;
                break;
            case "Property":
                $value = Property::find($value)->pPropertyName;
                break;
            case "Tenant":
                $value = Tenant::find($value)->firstName;
                break;
            case "Unit":
                $value = Unit::find($value)->unitNumber;
                break;
            case "Assigned To":
                $value = User::find($value)->first_name;
                break;
            default:
                $value = $value; // Subject, Description
                break;
        }

        $message = " has changed the " . $field . " to " . $value;
        return $message;
    }   

    function delete($jobcard){
        $jobcard = JobCard::find($jobcard);
	    $jobcard->delete();
        return Redirect::to('jobcards');
    }
}

