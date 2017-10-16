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
use App\Model\Customer;
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

         $suppliers= DB::table('supplier')->get();
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
       // dd($suppliers);

      //  $supplierStatements =

 

        return view('reports_supplierstatement',[
            'supplierStatements' => $supplierStatements,
            'suppliers' => $suppliers,

            ]);

        


    }

    public function getFilteredStatements(Request $request){

            $state = $request->state;
            //dd($state); 
           // $supplierStatements = DB::table('domains')->where('state' ,'=', $state )->get();

            if ($state == 0){

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


            }
            else{

                 $supplierStatements = DB::table('supplierinvoice')
                    ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
                    ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
                    ->where('supplierinvoice.supplierID' ,'=', $state )
                    ->selectRaw('supplier.supplierID, 
                            supplierinvoice.supplierInvoiceID,
                    supplier.supplierName, 
                    supplierinvoice.invoiceSystemCode, 
                    supplierinvoice.supplierInvoiceCode,
                    supplierinvoice.amount as supplierInvoiceAmount,
                    supplierinvoice.invoiceDate,
                    payment.totalpaidAmount')
            ->get(); 

            }

           

           // dd($supplierStatements); 
            $html = view('reports_supplierstatement_data', compact('supplierStatements'))->render();

            return  $html;
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

        function excelSupplierStatement($param){

        // Initialize the array which will be passed into the Excel
        // generator.
         $reportArray = []; 
         $report = "";

        if ($param == "SST"){

                $report="Supplier Statement";

                 $supplierStatements = DB::table('supplierinvoice')
                ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
                ->leftJoin(DB::raw('(SELECT supplierInvoiceID,sum(payments.paymentAmount) as totalpaidAmount 
                    FROM payments 
                    where payments.documentID=5       
                    GROUP BY supplierInvoiceID,SupplierInvoiceDate,supplierID) payment'),
                    'supplierinvoice.supplierInvoiceID','=', 'payment.supplierInvoiceID')
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
     
               

                // Define the Excel spreadsheet headers
                $reportArray[] = ['Supplier_Name','Invoice_Code','Invoice_Date','Invoice_No','Invoice_Amount','Balance_Amount','Currency'];

                // Convert each member of the returned collection into an array,
                // and append it to the payments array.
                foreach ($supplierStatements as $supplierStatement) {
                        if ($supplierStatement->supplierInvoiceAmount - $supplierStatement->totalpaidAmount > 0){

                    $reportArray[]=array($supplierStatement->supplierName,$supplierStatement->invoiceSystemCode,$supplierStatement->invoiceDate,$supplierStatement->supplierInvoiceCode,$supplierStatement->supplierInvoiceAmount,($supplierStatement->supplierInvoiceAmount-$supplierStatement->totalpaidAmount),"OMR");
            
                }
                
                //dd($reportArray);
        }


        }else if ($param == "SSU"){

            $report="Supplier Summary";

               $supplierSummary = DB::table('supplierinvoice')
                ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
                ->leftJoin(DB::raw('(SELECT supplierID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierID) payment'),'supplierinvoice.supplierID','=', 'payment.supplierID')
                ->Groupby('supplierID','supplierName','payment.totalpaidAmount')
                ->selectRaw('supplier.supplierID,                    
                    supplier.supplierName,
                    sum(supplierinvoice.amount) as supplierInvoiceAmount,
                    payment.totalpaidAmount')        
                ->get();

                $reportArray[] = ['Supplier_Name','Total_Invoice_Amount','Balance_Amount','Currency'];

                foreach ($supplierSummary as $supplier) {
                        if ($supplier->supplierInvoiceAmount - $supplier->totalpaidAmount > 0){

                            $reportArray[]=array($supplier->supplierName,$supplier->supplierInvoiceAmount,($supplier->supplierInvoiceAmount-$supplier->totalpaidAmount),"OMR");

                        }
                }



        }else if ($param == "CST"){

                $report="Customer Statement";

               $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();

                $reportArray[] = ['Customer_Name','Invoice_Code','Invoice_Date','Invoice_Amount','Balance_Amount','Currency'];

                foreach ($customerStatements as $customerStatement) {
                        if ($customerStatement->customerInvoiceAmount - $customerStatement->totalReceived > 0){

                            $reportArray[]=array($customerStatement->customerName,$customerStatement->invoiceSystemCode,$customerStatement->customerInvoiceDate,$customerStatement->customerInvoiceAmount,($customerStatement->customerInvoiceAmount-$customerStatement->totalReceived),"OMR");

                        }
                }





        }else if ($param == "CSU"){

            $report="Customer Summary";

            $customerSummary = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,sum(receipt.receiptAmount) as totalReceived FROM receipt GROUP BY customerID) received'),'customerinvoice.propertyOwnerID','=', 'received.customerID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    Sum(customerinvoice.amount) AS totalInvoiceAmount,
                    received.totalReceived')
            ->get();


            $reportArray[] = ['Supplier_Name','Total_Invoice_Amount','Balance_Amount','Currency'];

                foreach ($customerSummary as $customer) {
                        if ($customer->totalInvoiceAmount - $customer->totalReceived > 0){

                            $reportArray[]=array($customer->customerName,$customer->totalInvoiceAmount,($customer->totalInvoiceAmount-$customer->totalReceived),"OMR");

                        }
                }

            
        }

       
  //  dd($supplierStatementsArray);

    // Generate and return the spreadsheet
    return \Excel::create($report, function($excel) use ($reportArray,$report)  {

        // Set the spreadsheet title, creator, and description
        $excel->setTitle($report);
        $excel->setCreator('System')->setCompany('IDSS, LLC');
        $excel->setDescription('Currency : OMR');

        // Build the spreadsheet, passing in the payments array
        $excel->sheet('sheet1', function($sheet) use ($reportArray) {
            
            $sheet->fromArray($reportArray);
        });


    })->export('xlsx');



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

        function printSupplierSummary(){

         $supplierSummary = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierID) payment'),'supplierinvoice.supplierID','=', 'payment.supplierID')
        ->Groupby('supplierID','supplierName','payment.totalpaidAmount')
        ->selectRaw('supplier.supplierID,                    
                    supplier.supplierName,
                    sum(supplierinvoice.amount) as supplierInvoiceAmount,
                    payment.totalpaidAmount')
        
        ->get();



            return view('supplierSummary-print',[
            'supplierSummary' => $supplierSummary,
            ]);
        }


        function pdfSupplierSummary(){

          $supplierSummary = DB::table('supplierinvoice')
        ->leftJoin('supplier','supplierinvoice.supplierID','=','supplier.supplierID')
        ->leftJoin(DB::raw('(SELECT supplierID,sum(payments.paymentAmount) as totalpaidAmount FROM payments where payments.documentID=5       GROUP BY supplierID) payment'),'supplierinvoice.supplierID','=', 'payment.supplierID')
        ->Groupby('supplierID','supplierName','payment.totalpaidAmount')
        ->selectRaw('supplier.supplierID,                    
                    supplier.supplierName,
                    sum(supplierinvoice.amount) as supplierInvoiceAmount,
                    payment.totalpaidAmount')
        
        ->get();

        $company = Company::find(Sentinel::getUser()->companyID);

        $pdf = App::make('dompdf.wrapper');

        $data = array(
            'supplierSummary' => $supplierSummary,
            'company' => $company,
            
        );

            $pdf->loadView('supplierSummary_pdf',$data,$data);
            return $pdf->stream();
        
        }

        function getCustomerStatement(){

          //comehere
            $customers= DB::table('customer')->orderby('CustomerName','ASC')->get();
            $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode','customerinvoice.CustomerInvoiceSystemCode','customerinvoice.amount')
            ->selectRaw('customer.customerName,
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
            'customers' => $customers,

            ]) ;

            


        }


        public function getCustomerFilteredStatements(Request $request){

            $state = $request->state;
            //dd($state); 
           // $supplierStatements = DB::table('domains')->where('state' ,'=', $state )->get();

            if ($state==0){

                 $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode','customerinvoice.CustomerInvoiceSystemCode','customerinvoice.amount')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();


            }
            else{

       $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
    ->where('customerinvoice.propertyOwnerID' ,'=', $state )
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode','customerinvoice.CustomerInvoiceSystemCode','customerinvoice.amount')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();

                
                        

            }

            

        

           // dd($supplierStatements); 
            $html = view('reports_customerstatement_data', compact('customerStatements'))->render();

            return  $html;
    }

       

        function printCustomerStatement(){

           $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode','customerinvoice.CustomerInvoiceSystemCode','customerinvoice.amount')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();



            return view('customerstatement-print',[
            'customerStatements' => $customerStatements,
            ]);
        }

         function pdfCustomerStatement(){

            $customerStatements = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,invoiceSystemCode,customerInvoiceID, sum(receiptAmount) as totalReceived,customerInvoiceCode FROM receipt GROUP BY customerID,invoiceSystemCode,customerInvoiceID,customerInvoiceCode) received'),'customerinvoice.customerInvoiceID','=', 'received.customerInvoiceID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived','customerinvoice.invoiceDate','customerinvoice.customerInvoiceID','received.customerInvoiceCode','customerinvoice.CustomerInvoiceSystemCode','customerinvoice.amount')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    customerinvoice.CustomerInvoiceSystemCode AS invoiceSystemCode,
                    customerinvoice.invoiceDate AS customerInvoiceDate,
                    received.customerInvoiceCode,
                    amount AS customerInvoiceAmount,
                    received.totalReceived')
            ->get();
            $company = Company::find(Sentinel::getUser()->companyID);

            $pdf = App::make('dompdf.wrapper');

            $data = array(
                'customerStatements' => $customerStatements,
                'company' => $company,
                
            );

            $pdf->loadView('customerStatement_pdf',$data,$data);
            return $pdf->stream();
        
        }


         function getCustomerSummary(){

            
             $customerSummary = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,sum(receipt.receiptAmount) as totalReceived FROM receipt GROUP BY customerID) received'),'customerinvoice.propertyOwnerID','=', 'received.customerID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    Sum(customerinvoice.amount) AS totalInvoiceAmount,
                    received.totalReceived')
            ->get();

            return view('reports_customersummary',[

            'customerSummary' => $customerSummary,

            ]) ;




        }

        function pdfCustomerSummary(){

            $customerSummary = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,sum(receipt.receiptAmount) as totalReceived FROM receipt GROUP BY customerID) received'),'customerinvoice.propertyOwnerID','=', 'received.customerID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    Sum(customerinvoice.amount) AS totalInvoiceAmount,
                    received.totalReceived')
            ->get();
            $company = Company::find(Sentinel::getUser()->companyID);

            $pdf = App::make('dompdf.wrapper');

            $data = array(
                'customerSummary' => $customerSummary,
                'company' => $company,
                
            );

            $pdf->loadView('customerSummary_pdf',$data,$data);
            return $pdf->stream();
        
        }


        function printCustomerSummary(){

           $customerSummary = DB::table('customerinvoice')
            ->leftJoin('customer','customer.customerID','=','customerinvoice.propertyOwnerID')
            ->leftJoin(DB::raw('(SELECT customerID,sum(receipt.receiptAmount) as totalReceived FROM receipt GROUP BY customerID) received'),'customerinvoice.propertyOwnerID','=', 'received.customerID')
            ->Groupby('customer.customerName','customerinvoice.propertyOwnerID','received.totalReceived')
            ->selectRaw('customer.customerName,
                    customerinvoice.propertyOwnerID,
                    Sum(customerinvoice.amount) AS totalInvoiceAmount,
                    received.totalReceived')
            ->get();

            $company = Company::find(Sentinel::getUser()->companyID);



            return view('customerSummary-print',[
            'customerSummary' => $customerSummary,
            'company' => $company,
            ]);
        }


        function getRevenueReport(){

             $monthlyRevenueYear=DB::table('receipt')
            ->Orderby('revYear', 'DESC')
            ->selectRaw('DISTINCT Year(receiptDate) as revYear')
            ->get();

            $query='(select supplierOrCustomerID as customerID,sum(amount) as totalReceived, MONTH(documentDate) as receiptMonth,Year(documentDate) as receiptYear 
                    FROM generalledger
                    left join chartofaccounts ON 
                    generalledger.accountCode = chartofaccounts.chartOfAccountID
                    WHERE Year(documentDate) = Year(now()) AND chartofaccounts.type=2
                    GROUP BY supplierOrCustomerID,receiptMonth,receiptYear, chartofaccounts.type)received';
            
            $revenueByCustomer = DB::table('customer')
            ->leftJoin (DB::raw($query),'customer.customerID','=', 'received.customerID')
            ->selectRaw('customer.customerName,customer.customerID, received.receiptMonth, received.receiptYear,
                    received.totalReceived as receiptAmount')
            ->get();

            $customers = DB::table('customer')
            ->select('customerID','customerName')
            ->get();

        
             $monthlyRevenueArray = $this->getMonthlyView($customers,$revenueByCustomer);

            //dd($monthlyRevenueArray);

            return view ('reports_revenuebycustomer',[
            'monthlyRevenueArray' => $monthlyRevenueArray,
            'monthlyRevenueYear' => $monthlyRevenueYear,
            ]);




        }
     

        function getfilteredRevenueReport(Request $request){

            $state = $request->state;

         
            $query='(select supplierOrCustomerID as customerID,sum(amount) as totalReceived, MONTH(documentDate) as receiptMonth,Year(documentDate) as receiptYear 
                    FROM generalledger
                    left join chartofaccounts ON 
                    generalledger.accountCode = chartofaccounts.chartOfAccountID
                    WHERE Year(documentDate) = '.$state.' AND chartofaccounts.type=2
                    GROUP BY supplierOrCustomerID,receiptMonth,receiptYear, chartofaccounts.type)received';

                    
            
            $revenueByCustomer = DB::table('customer')
            ->leftJoin (DB::raw($query),'customer.customerID','=', 'received.customerID')
            ->selectRaw('customer.customerName,customer.customerID, received.receiptMonth, received.receiptYear,
                    received.totalReceived as receiptAmount')
            ->get();

            $customers = DB::table('customer')
            ->select('customerID','customerName')
            ->get();

             $monthlyRevenueArray = $this->getMonthlyView($customers,$revenueByCustomer);
        

            

            return view ('reports_revenuebycustomer_data',[
            'monthlyRevenueArray' => $monthlyRevenueArray
            ]);




        }


        function getRevenueReportbyUnit(){

             $monthlyRevenueYear=DB::table('receipt')
            ->Orderby('revYear', 'DESC')
            ->selectRaw('DISTINCT Year(receiptDate) as revYear')
            ->get();

            $query='(select unitID,sum(amount) as totalReceived, MONTH(documentDate) as receiptMonth,Year(documentDate) as receiptYear 
                    FROM generalledger
                    left join chartofaccounts ON 
                    generalledger.accountCode = chartofaccounts.chartOfAccountID
                    WHERE Year(documentDate) = Year(now()) AND chartofaccounts.type=2
                    GROUP BY unitID,receiptMonth,receiptYear, chartofaccounts.type)received';
            
            $revenueByUnit = DB::table('units')
            ->leftJoin (DB::raw($query),'units.unitID','=', 'received.unitID')
            ->leftJoin('properties','units.PropertiesID','=', 'properties.PropertiesID')
            ->selectRaw('units.unitNumber,units.unitID,properties.pPropertyName, received.receiptMonth, received.receiptYear,
                    received.totalReceived as receiptAmount')
            ->get();
           // dd($revenueByUnit);

            $units = DB::table('units')
            ->leftJoin('properties','units.PropertiesID','=', 'properties.PropertiesID')
            ->select('unitNumber','unitID','properties.pPropertyName')
            ->get();
            
            //dd($units);
            
             $monthlyRevenueArray = $this->getMonthlyViewunit($units,$revenueByUnit);

           // dd($monthlyRevenueArray);

            return view ('reports_revenuebyunit',[
            'monthlyRevenueArray' => $monthlyRevenueArray,
            'monthlyRevenueYear' => $monthlyRevenueYear,
            ]);




        }

        


         function getfilteredRevenueReportbyUnit(Request $request){

            $state = $request->state;

            
            $query='(select unitID,sum(amount) as totalReceived, MONTH(documentDate) as receiptMonth,Year(documentDate) as receiptYear 
                    FROM generalledger
                    left join chartofaccounts ON 
                    generalledger.accountCode = chartofaccounts.chartOfAccountID
                    WHERE Year(documentDate) = '.$state.' AND chartofaccounts.type=2
                    GROUP BY unitID,receiptMonth,receiptYear, chartofaccounts.type)received';
            
            $revenueByUnit = DB::table('units')
            ->leftJoin (DB::raw($query),'units.unitID','=', 'received.unitID')
            ->selectRaw('units.unitNumber,units.unitID, received.receiptMonth, received.receiptYear,
                    received.totalReceived as receiptAmount')
            ->get();

            $units = DB::table('units')
            ->leftJoin('properties','units.PropertiesID','=', 'properties.PropertiesID')
            ->select('unitNumber','unitID','properties.pPropertyName')
            ->get();
            
             $monthlyRevenueArray = $this->getMonthlyViewunit($units,$revenueByUnit);
        

            
            return view ('reports_revenuebyunit_data',[
            'monthlyRevenueArray' => $monthlyRevenueArray
            ]);




        }


        public function getMonthlyView(Collection $customers,Collection $revenueByCustomer){

            $monthlyRevenueArray=[];

            foreach ($customers as $customer) {

                for ($i=0; $i<13 ; $i++) { 

                        foreach ($revenueByCustomer as $value) {

                            if ($customer->customerID == $value->customerID){

                                if ($value->receiptMonth==$i){
                                    

                                        $monthlyRevenueArray[$customer->customerName][$i]=$value->receiptAmount *-1;
                                }  

                            }
                                                 
                        }

                                 if (empty($monthlyRevenueArray[$customer->customerName][$i])){

                                     $monthlyRevenueArray[$customer->customerName][$i]=0;
                                 }
                    
                }
            }

            return $monthlyRevenueArray;

        }

        public function getMonthlyViewunit(Collection $customers,Collection $revenueByCustomer){

            $monthlyRevenueArray=[];

            foreach ($customers as $customer) {
                $unitName=$customer->pPropertyName." (Flat ".$customer->unitNumber.")";
                for ($i=0; $i<13 ; $i++) { 

                        foreach ($revenueByCustomer as $value) {

                            if ($customer->unitID == $value->unitID){

                                if ($value->receiptMonth==$i){
                                    

                                        $monthlyRevenueArray[$unitName][$i]=$value->receiptAmount*-1;
                                }  

                            }
                                                 
                        }

                                 if (empty($monthlyRevenueArray[$unitName][$i])){

                                     $monthlyRevenueArray[$unitName][$i]=0;
                                 }
                    
                }
            }

            return $monthlyRevenueArray;

        }




    
    
}
?>