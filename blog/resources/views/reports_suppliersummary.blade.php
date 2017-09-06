@extends('admin_template')

@section('content')

<div class="container-fluid">
<br>
</br>

<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Supplier Summary
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
        <div class="col-xs-12 table-responsive" >
          <table class="table table-striped" width="50%">
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
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
         
          
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="/suppliersuppliersummary-print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <a href="/suppliersuppliersummary-excel">
          	<button type="button" class="btn btn-success pull-right">
          		<i class="fa fa-file-excel-o"></i> Export to Excel
          	</button>
          </a>
          <a href="/supplierSummary_pdf">
          	<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            	<i class="fa fa-download"></i> Generate PDF 
          	</button>
          </a>
        </div>
      </div>
    </section>


</div>






@endsection