<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Debugbar;
use Redirect;
use Response;
use File;
use Sentinel;
use URL;
    	// Debugbar::info($property); 

class AttachmentsController extends Controller
{
	function getFile($slugName){
	    $path = storage_path('app\\uploads\\attachments\\' . $slugName);

	    // if the images does not exist => 404
	    if (!File::exists($path)) {
	        abort(404);
	    }

	    // Output the file
	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}

	function create(Request $request){
		$attachment = new Attachment();
		$attachment->attachmentDescription = $request->description;
		$attachment->documentID  = $request->documentID;
		$attachment->documentAutoID = $request->documentAutoID;
		$attachment->fileNameCustom = $request->fileNameCustom;
		$attachment->uploadedByUserID = Sentinel::getUser()->id;
		$attachment->companyID = Sentinel::getUser()->companyID;

		// File upload
	    if($request->hasFile('attachmentFile')){
		    $file = $request->file('attachmentFile');
		    $attachment->fileName = $file->getClientOriginalName();
			$attachment->fileNameSlug = $request->documentID . '_' . $request->documentAutoID .'_'.time().'.' . $file->getClientOriginalExtension();
		    Storage::put('uploads/attachments/'.$attachment->fileNameSlug, file_get_contents($file));
		}

		$attachment->save();

		return Redirect::to($this->getEditUrl($request->documentAutoID, $request->documentID));
	}

	function edit(Attachment $attachment){
    	$attachment = Attachment::find($attachment->attachmentID);
    	$documentmaster = DocumentMaster::all();

    	
	    return view('attachments_edit', [
	        'attachments' => $attachment,	        
	        'documentmaster' => $documentmaster,	        
	    ]);
    }

    function update(Request $request){
    	$attachment = Attachment::find($request->attachmentID);
    	$attachment->attachmentDescription = $request->description;
		$attachment->documentID  = $request->documentID;
		$attachment->fileNameCustom = $request->fileNameCustom;

		// New file has been uploaded
	    if($request->hasFile('attachmentFile')){
	    	Storage::delete('uploads/attachments/'.$attachment->fileNameSlug);
		    $file = $request->file('attachmentFile');
		    $attachment->fileName = $file->getClientOriginalName();
			$attachment->fileNameSlug = $request->documentID . '_' . $request->documentAutoID .'_'.time().'.' . $file->getClientOriginalExtension();
		    Storage::put('uploads/attachments/'.$attachment->fileNameSlug, file_get_contents($file));
		}

		$attachment->save();

		return Redirect::to($this->getEditUrl($request->documentAutoID, $request->documentID));


    }


    function delete(Attachment $attachment){
    	$documentID = $attachment->documentID;
    	$documentAutoID = $attachment->documentAutoID;

    	$fileNameSlug = $attachment->fileNameSlug;


    	// Delete row from db
    	$attachment->delete();
    	
    	// Delete the file associated with it
    	Storage::delete('uploads/attachments/'.$fileNameSlug);   
		return Redirect::to($this->getEditUrl($documentAutoID, $documentID));
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