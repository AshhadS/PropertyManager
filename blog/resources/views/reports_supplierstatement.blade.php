@extends('admin_template')

@section('content')

<div class="container-fluid">
<br>
</br>

<br>
</br>

<section class="invoice table-responsive">
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

      <div class="form-group col-xs-3">
            <label for="">Filter By Supplier</label>

            <select class="form-control input-sm" id="state" name="state" >
            <option value="0">Please select a supplier</option>
             @foreach ($suppliers as $supplier)
                  <option value="{{$supplier->supplierID}}">{{$supplier->supplierName}}</option>
            @endforeach
                  
            </select>

      </div>  
      	
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="domains_table" class="table table-striped">
            <thead>
            <tr>
              <th>Supplier Name</th>
              <th>Invoice Code</th>
              <th>Invoice Date</th>
              <th>Invoice No</th>
              <th>Currency</th>
              <th>Invoice Amount</th>
              <th>Balance Amount</th>
            </tr>
            </thead>
            <tbody>
        
             @include('reports_supplierstatement_data')
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
          <a href="/supplierstatement-print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <a href="/supplierstatement-excel">
          	<button type="button" class="btn btn-success pull-right">
          		<i class="fa fa-file-excel-o"></i> Export to Excel
          	</button>
          </a>
          <a href="/supplierStatement_pdf">
          	<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            	<i class="fa fa-download"></i> Generate PDF 
          	</button>
          </a>
        </div>
      </div>
    </section>


</div>


@endsection

@push('scripts')
<script>
  
$( "#state" ).change(function() 
  {
    //this is the #state dom element
    var state = $(this).val();
    
    // parameter 1 : url
        // parameter 2: post data
        //parameter 3: callback function 
    $.get( '/reports_supplierstatement_data' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
        $("#domains_table tbody").html(htmlCode);
    });
  });


</script>>


@endpush