<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attachment;
use App\Model\DocumentMaster;
use App\Model\Note;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
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

        $supplierSummaryTotal = DB::table('supplierinvoice')
            ->where('supplierinvoice.paymentPaidYN','=',0)
            ->sum('supplierinvoice.amount');

        return view('reports',[

        	'supplierStatementCount' => $supplierStatementCount,
            'supplierSummaryTotal' => $supplierSummaryTotal,

        	]) ;
    }


    function getSupplierStatement(){


        $supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
        ->selectRaw('supplier.supplierID, 
                    supplierinvoice.supplierInvoiceID,
                    supplier.supplierName, 
                    supplierinvoice.invoiceSystemCode, 
                    supplierinvoice.supplierInvoiceCode,
                    supplierinvoice.amount as supplierInvoiceAmount,
                    supplierinvoice.invoiceDate,
                    payment.totalpaidAmount')
        ->get();
        //dd($supplierStatements);

      //  $supplierStatements =

 

        return view('reports_supplierstatement',[
        	'supplierStatements' => $supplierStatements,

        	]);

        


    }



    function printSupplierStatement(){

        $supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
        ->selectRaw('supplier.supplierID, 
                    supplierinvoice.supplierInvoiceID,
                    supplier.supplierName, 
                    supplierinvoice.invoiceSystemCode, 
                    supplierinvoice.supplierInvoiceCode,
                    supplierinvoice.amount as supplierInvoiceAmount,
                    supplierinvoice.invoiceDate,
                    payment.totalpaidAmount')
        ->get();



        	return view('supplierstatement-print',[
        	'supplierStatements' => $supplierStatements,
			]);
        }


        function pdfSupplierStatement(){

    	 $supplierStatements = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
        ->selectRaw('supplier.supplierID, 
                    supplierinvoice.supplierInvoiceID,
                    supplier.supplierName, 
                    supplierinvoice.invoiceSystemCode, 
                    supplierinvoice.supplierInvoiceCode,
                    supplierinvoice.amount as supplierInvoiceAmount,
                    supplierinvoice.invoiceDate,
                    payment.totalpaidAmount')
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
        ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
        ->selectRaw('supplier.supplierID, 
                    supplierinvoice.supplierInvoiceID,
                    supplier.supplierName, 
                    supplierinvoice.invoiceSystemCode, 
                    supplierinvoice.supplierInvoiceCode,
                    supplierinvoice.amount as supplierInvoiceAmount,
                    supplierinvoice.invoiceDate,
                    payment.totalpaidAmount')
        ->get();

        	// Initialize the array which will be passed into the Excel
    // generator.
    $supplierStatementsArray = []; 

    // Define the Excel spreadsheet headers
    $supplierStatementsArray[] = ['Supplier_name','Invoice_code','Invoice_date','Invoice_No','Invoice_Amount','Balance_Amount','Currency'];

    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
    foreach ($supplierStatements as $supplierStatement) {
        if ($supplierStatement->supplierInvoiceAmount - $supplierStatement->totalpaidAmount > 0){

            $supplierStatementsArray[]=array($supplierStatement->supplierName,$supplierStatement->supplierInvoiceCode,$supplierStatement->invoiceDate,$supplierStatement->supplierInvoiceCode,$supplierStatement->supplierInvoiceAmount,($supplierStatement->supplierInvoiceAmount-$supplierStatement->totalpaidAmount),"OMR");
            
        }
       // $supplierStatementsArray[] = $supplierStatement->toArray();
    	//$supplierStatementsArray[] = (array) $supplierStatement;
    	
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

        function getSupplierSummary(){


        $supplierSummary = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierID) payment'),'supplierinvoice.supplierID','=', 'payment.supplierID')
        ->Groupby('supplierID','supplierName','payment.totalpaidAmount')
        ->selectRaw('supplier.supplierID,                    
                    supplier.supplierName,
                    sum(supplierinvoice.amount) as supplierInvoiceAmount,
                    payment.totalpaidAmount')
        
        ->get();


            return view('reports_suppliersummary',[

            'supplierSummary' => $supplierSummary,

            ]) ;

            


        }

        function getCustomerStatement(){

          
            $customerStatements = DB::table('customerinvoice')
            ->leftJoin('rentalowners','rentalowners.rentalOwnerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('rentalowners.firstName', 'rentalowners.lastName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode')
            ->selectRaw('rentalowners.firstName, 
                    rentalowners.lastName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();

           // dd($customerStatements);


            return view('reports_customerstatement',[

            'customerStatements' => $customerStatements,

            ]) ;

            


        }


         function getCustomerSummary(){

            
             $customerSummary = DB::table('customerinvoice')
            ->leftJoin('rentalowners','rentalowners.rentalOwnerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,sum(receipt.receiptAmount) as totalReceived FROM receipt GROUP BY customerID) received'),'customerinvoice.propertyOwnerID','=', 'received.customerID')
            ->Groupby('rentalowners.firstName', 'rentalowners.lastName','customerinvoice.propertyOwnerID','received.totalReceived')
            ->selectRaw('rentalowners.firstName, 
                    rentalowners.lastName,
                    customerinvoice.propertyOwnerID,
                    Sum(customerinvoice.amount) AS totalInvoiceAmount,
                    received.totalReceived')
            ->get();
            return view('reports_customersummary',[

            'customerSummary' => $customerSummary,

            ]) ;




        }



    
    
}