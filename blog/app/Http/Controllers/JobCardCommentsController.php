<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobCard;
use App\Model\JobCardStatus;
use App\Model\JobCardComment;
use App\Model\JobCardLog;
use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Redirect;
use Sentinel;
use Carbon\Carbon;

class JobCardCommentsController extends Controller
{

    function create(Request $request) {
	    $jc = new JobCardComment;
        $jc->jobcardID = $request->jobcardID;
        $jc->comments = $request->comments;
        $jc->commentedByID = Sentinel::getUser()->id;
        $jc->commentedByName = Sentinel::getUser()->first_name;
        $jc->commentedDateTime = Carbon::now();
        $jc->timestamp = Carbon::now();

        $log = new JobCardLog;
        $log->field = "Comment";
        $log->originalValue = 0; 
        $log->newValue = 0;
        $log->jobCardID = $request->jobcardID;
        $log->updatedByEmpID = Sentinel::getUser()->id;
        $log->updatedByEmpName = Sentinel::getUser()->first_name;
        $log->timestamp = Carbon::now(); //formatted date time
        $log->updatedTime = Carbon::now(); //formatted date time
        $log->pageLink = 'jobcard/edit/' . $request->jobcardID; //formatted date time
        $log->history = $request->comments;

	    $log->save();
	    $jc->save();

	    return Redirect::to('/jobcard/edit/'.$request->jobcardID);
    }



    function update(Request $request){	
    	
    }

 

    function delete(JobCard $jobcardcomment){
	    $jobcardcomment->delete();
        return Redirect::to('/jobcard/edit/'+$request->jobcardID);
    }
}

