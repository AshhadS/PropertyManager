<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Note;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Debugbar;
use Redirect;
use Response;
use File;
use Sentinel;
use URL;
use Carbon;

class NotesController extends Controller
{
	function create(Request $request){
		$note = new Note();
		$note->companyID = Sentinel::getUser()->companyID;
		$note->documentID = ($request->documentID) ? $request->documentID : 1;
		$note->documentAutoID = $request->documentAutoID;
		$note->notes = $request->notes;
		$note->updatedDate = Carbon\Carbon::now()->toDateTimeString();
		$note->updatedBy = Sentinel::getUser()->id;		

		$note->save();

		return Redirect::to($this->getEditUrl($note->documentAutoID, $note->documentID));
	}


    function update(Request $request){
    	$note = Note::find($request->notesID);
    	$note->companyID = Sentinel::getUser()->companyID;
		$note->documentID = $request->documentID;
		$note->documentIAutoD = $request->documentAutoID;
		$note->notes = $request->notes;
		$note->updatedDate = Carbon\Carbon::now()->toDateTimeString();
		$note->updatedBy = Sentinel::getUser()->id;	

		$attachment->save();

		return Redirect::to($this->getEditUrl($request->documentAutoID, $request->documentID));
    }


    function delete(Note $attachment){
    	$note = Note::find($request->notesID);
    	$note->delete();    	
    }

    function getEditUrl($documentAutoID, $documentID){
    	$entityType;
    	switch ($documentID) {
		    case 1:
		        $entityType = 'prop';
		        break;
		    case 2:
		        $entityType = 'rentalowner';
		        break;
		    case 3:
		        $entityType = 'unit';
		        break;
		    case 4:
		        $entityType = 'tenant';
		        break;
		    case 5:
		        $entityType = 'jobcard';
		        break;
		}
		return $entityType.'/edit/'.$documentAutoID;
    }
}