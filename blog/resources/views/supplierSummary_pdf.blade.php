<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Supplier Summary</title>
         <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       
        <!-- Bootstrap data tables -->
        <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap X-Editable -->
        <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/> -->
        <!-- Ionicons -->
        <!-- <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/css/components.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/custom.css")}}" rel="stylesheet" type="text/css" />

        <!-- <link href="{{ asset("/css/pdf-print.css")}}" rel="stylesheet" type="text/css" /> -->

       
    </head>
    <body>

    <div class="container-fluid">

<section id="printSection">

     

      <!-- title row -->
    <div class="row">

      <table class="header-section">
        <tr>
      <td><h2><img src="{{ asset("/images/logosml.jpg") }}" /></h2></td>
      <td class="remove-child-margins">
        <h4>{{$company->companyName}}</h4>
        <br />
        <p>{{$company->address}}</p>
        <p>{{$company->city}}</p>
        <p>Tel: {{$company->telephoneNumber}}</p>
        <p>Fax: {{$company->faxNumber}}</p>
      </td>
    </tr>
  </table>
    
    <br />
    <hr>
      </div>
      <!-- /.col -->
  </div>
      <!-- info row -->
      <div class="row">
      <h2>
            </i> Supplier Summary
            
      </h2>
      <small class="pull-right">Date: {{ date("Y/m/d")}}</small>
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        
          <table class="table table-striped" width="100%">
            <thead>
            <tr>
              <th>Supplier</th>
              <th>Currency</th>
              <th>Invoice Amount</th>
              <th>Balance Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($supplierSummary as $supplier)
            @if($supplier->supplierInvoiceAmount-$supplier->totalpaidAmount > 0)
            <tr>
              <td>{{$supplier->supplierName}}</td>
              <td>OMR</td>
              <td>{{number_format($supplier->supplierInvoiceAmount,3)}}</td>              
              <td>{{number_format($supplier->supplierInvoiceAmount-$supplier->totalpaidAmount,3)}}</td>
            </tr>
            @endif
           @endforeach
            </tbody>
          </table>
        
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
         
          
      </div>
      <!-- /.row -->

     
    </section>


</div>



</body>
</html>
