<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Note;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Model\Company;
use Debugbar;
use Redirect;
use Response;
use File;
use Sentinel;
use URL;
use Carbon;
use App;

class ReportsController extends Controller
{
    function index(){    

    	$supplierStatementCount = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin('jobcard','supplierinvoice.jobCardID','=','jobcard.jobCardID')
        ->leftJoin('properties','supplierinvoice.PropertiesID','=','properties.PropertiesID')
        ->leftJoin('units','supplierinvoice.unitID','=','units.unitID')
        ->where('supplierinvoice.paymentPaidYN','=',0)
        ->Select('supplierinvoice.supplierInvoiceID',
        		'supplierinvoice.invoiceSystemCode', 
        		'supplierinvoice.supplierInvoiceCode', 
        		'supplier.supplierName', 
        		'jobcard.jobCardCode',
        		'jobcard.jobcardID', 
        		'supplierinvoice.amount', 
        		'supplierinvoice.paymentPaidYN', 
        		'supplierinvoice.invoiceDate', 
        		'supplierinvoice.description', 
        		'properties.pPropertyName', 
        		'units.unitNumber')
        ->count();

        return view('reports',[

        	'supplierStatementCount' => $supplierStatementCount,

        	]) ;
    }


    function getSupplierStatement(){


    	$supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin('jobcard','supplierinvoice.jobCardID','=','jobcard.jobCardID')
        ->leftJoin('properties','supplierinvoice.PropertiesID','=','properties.PropertiesID')
        ->leftJoin('units','supplierinvoice.unitID','=','units.unitID')
        ->where('supplierinvoice.paymentPaidYN','=',0)
        ->Select('supplierinvoice.supplierInvoiceID',
        		'supplierinvoice.invoiceSystemCode', 
        		'supplierinvoice.supplierInvoiceCode', 
        		'supplier.supplierName', 
        		'jobcard.jobCardCode',
        		'jobcard.jobcardID', 
        		'supplierinvoice.amount', 
        		'supplierinvoice.paymentPaidYN', 
        		'supplierinvoice.invoiceDate', 
        		'supplierinvoice.description', 
        		'properties.pPropertyName', 
        		'units.unitNumber')
        ->get();

        return view('reports_supplierstatement',[
        	'supplierStatements' => $supplierStatements,

        	]);

        


    }

    function printSupplierStatement(){

    	$supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin('jobcard','supplierinvoice.jobCardID','=','jobcard.jobCardID')
        ->leftJoin('properties','supplierinvoice.PropertiesID','=','properties.PropertiesID')
        ->leftJoin('units','supplierinvoice.unitID','=','units.unitID')
        ->where('supplierinvoice.paymentPaidYN','=',0)
        ->Select('supplierinvoice.supplierInvoiceID',
        		'supplierinvoice.invoiceSystemCode', 
        		'supplierinvoice.supplierInvoiceCode', 
        		'supplier.supplierName', 
        		'jobcard.jobCardCode',
        		'jobcard.jobcardID', 
        		'supplierinvoice.amount', 
        		'supplierinvoice.paymentPaidYN', 
        		'supplierinvoice.invoiceDate', 
        		'supplierinvoice.description', 
        		'properties.pPropertyName', 
        		'units.unitNumber')
        ->get();


        	return view('supplierstatement-print',[
        	'supplierStatements' => $supplierStatements,
			]);
        }


        function pdfSupplierStatement(){

    	$supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin('jobcard','supplierinvoice.jobCardID','=','jobcard.jobCardID')
        ->leftJoin('properties','supplierinvoice.PropertiesID','=','properties.PropertiesID')
        ->leftJoin('units','supplierinvoice.unitID','=','units.unitID')
        ->where('supplierinvoice.paymentPaidYN','=',0)
        ->Select('supplierinvoice.supplierInvoiceID',
        		'supplierinvoice.invoiceSystemCode', 
        		'supplierinvoice.supplierInvoiceCode', 
        		'supplier.supplierName', 
        		'jobcard.jobCardCode',
        		'jobcard.jobcardID', 
        		'supplierinvoice.amount', 
        		'supplierinvoice.paymentPaidYN', 
        		'supplierinvoice.invoiceDate', 
        		'supplierinvoice.description', 
        		'properties.pPropertyName', 
        		'units.unitNumber')
        ->get();
        $company = Company::find(Sentinel::getUser()->companyID);

        $pdf = App::make('dompdf.wrapper');

        $data = array(
            'supplierStatements' => $supplierStatements,
            'company' => $company,
            
        );

            $pdf->loadView('supplierStatement_pdf',$data,$data);
            return $pdf->stream();
        
        }

        function excelSupplierStatement(){


        	$supplierStatements = DB::table('supplierinvoice')
        	->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        	->leftJoin('jobcard','supplierinvoice.jobCardID','=','jobcard.jobCardID')
       		->leftJoin('properties','supplierinvoice.PropertiesID','=','properties.PropertiesID')
        	->leftJoin('units','supplierinvoice.unitID','=','units.unitID')
        	->where('supplierinvoice.paymentPaidYN','=',0)
        	->Select(
        		'supplierinvoice.supplierInvoiceCode',
        		'supplierinvoice.invoiceDate', 
        		'supplier.supplierName', 
        		'jobcard.jobCardCode',
        		'supplierinvoice.amount'
        		)
        	->get();

        	// Initialize the array which will be passed into the Excel
    // generator.
    $supplierStatementsArray = []; 

    // Define the Excel spreadsheet headers
    $supplierStatementsArray[] = ['Invoice_code', 'Invoice_date','Supplier_name','Job_card','Amount','Currency'];

    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
    foreach ($supplierStatements as $supplierStatement) {
       // $supplierStatementsArray[] = $supplierStatement->toArray();
    	//$supplierStatementsArray[] = (array) $supplierStatement;
    	$supplierStatementsArray[]=array($supplierStatement->supplierInvoiceCode,$supplierStatement->invoiceDate,$supplierStatement->supplierName,$supplierStatement->jobCardCode,$supplierStatement->amount,"OMR");
    	
    }

    // Generate and return the spreadsheet
    return \Excel::create('supplierStatements', function($excel) use ($supplierStatementsArray)  {

        // Set the spreadsheet title, creator, and description
        $excel->setTitle('Supplier Statements');
        $excel->setCreator('System')->setCompany('IDSS, LLC');
        $excel->setDescription('Currency : OMR');

        // Build the spreadsheet, passing in the payments array
        $excel->sheet('sheet1', function($sheet) use ($supplierStatementsArray) {
            
            $sheet->fromArray($supplierStatementsArray);
        });


    })->download('xlsx');



        }


    
    
}