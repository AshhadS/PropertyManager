<section class="">

<section id="printSection">
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

      <a href="/supplierstatement-excel/{{ $param = 'SSU' }}">
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

      <div class="row">
      <br></br>
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
      </section>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="/suppliersuppliersummary-print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          
        </div>
      </div>
    </section>

@push('scripts')
<script>
 // window.onload = function() { window.print(); }


//   $('#print').on('click', function(event){
//       alert("Hello!");
//       var prtContent = document.getElementById("printSection");
      
//       var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
//       WinPrint.document.write(prtContent.innerHTML);
//       WinPrint.document.close();
//       WinPrint.focus();
//       WinPrint.print();
//       WinPrint.close();

// });

</script>

@endpush
