<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Property;
use App\Model\PropertyType;
use App\Model\PropertySubType;
use App\Model\RentalOwner;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Debugbar;
use Redirect;
use Response;
use File;
    	// Debugbar::info($property); 

class FilesController extends Controller
{
	function getFile($filename){
	    $path = storage_path('app/uploads/' . $filename);

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
}

