@extends('admin_template')

@section('content')

<div class="container-fluid">
<br>
</br>

<section id="printSection" class="invoice">

      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap data tables -->
        <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap X-Editable -->
        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/css/components.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/custom.css")}}" rel="stylesheet" type="text/css" />

      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Supplier Statement
            <small class="pull-right">Date: {{ date("Y/m/d")}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Invoice Code</th>
              <th>Invoice Date</th>
              <th>Supplier Name</th>
              <th>Job Card</th>
              <th>Currency</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($supplierStatements as $supplierStatement)
            <tr>
              <td>{{$supplierStatement->invoiceSystemCode}}</td>
              <td>{{$supplierStatement->invoiceDate}}</td>
              <td>{{$supplierStatement->supplierName}}</td>
              <td>{{$supplierStatement->jobCardCode}}</td>
              <td>OMR</td>
              <td>{{number_format($supplierStatement->amount,3)}}</td>
            </tr>
           @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
         
          
      </div>
      <!-- /.row -->

     
    </section>


</div>


@endsection

@push('printScripts')
<script>
 // window.onload = function() { window.print(); }

var prtContent = document.getElementById("printSection");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();

</script>

@endpush