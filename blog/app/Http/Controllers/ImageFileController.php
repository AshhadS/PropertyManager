<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\ImageFile;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Debugbar;
use Redirect;
use Response;
use File;
use Sentinel;
use Log;
use URL;
use Carbon\Carbon;
    	// Debugbar::info($property); 

class ImageFileController extends Controller
{
	function getFile($slugName){
	    // $path = storage_path('app/uploads/images/' . $slugName);
	    $path = storage_path('app/uploads/images/' . $slugName);
	    // dd($path);
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
		$imageFile = new ImageFile();
		$imageFile->documentID  = $request->documentID;
		$imageFile->documentAutoID = $request->documentAutoID;
		$imageFile->uploadedByUserID = Sentinel::getUser()->id;
		$imageFile->createdDateTime = Carbon::now();

		// File upload
        if($request->hasFile('file')){
        	// dd($request->file('file'));
            $file = $request->file('file');
            $imageFile->fileName = $file->getClientOriginalName();
            $imageFile->fileNameSlug = $request->documentID . '_' . $request->documentAutoID .'_'.time().'.' . $file->getClientOriginalExtension();
            Storage::put('uploads/images/'.$imageFile->fileNameSlug, file_get_contents($file));
        }else{
        	Log::error('file size is too large');
        	return 'false';
        }

		$imageFile->save();

		return Redirect::to($this->getEditUrl($request->documentAutoID, $request->documentID));
	}



    function delete($fileid){
    	$file = ImageFile::find($fileid);
    	$documentID = $file->documentID;
    	$documentAutoID = $file->documentAutoID;

    	$fileNameSlug = $file->fileNameSlug;


    	// Delete row from db
    	$file->delete();
    	
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