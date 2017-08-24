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

class ReportsController extends Controller
{
    function index(){    

        return view('dashboard') ;
    }


    
    
}