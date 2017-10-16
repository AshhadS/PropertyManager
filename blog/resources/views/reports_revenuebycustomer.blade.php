<section class="">

<section id="printSection">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Revenue by Customer
            <small class="pull-right">Date: {{ date("Y/m/d")}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">

       <div class="form-group col-xs-3">
            <label for="">Filter By Year</label>

            <select class="form-control input-sm" id="rev-state" name="state" >
            <option value="0">Please select a Year</option>
             @foreach ($monthlyRevenueYear as $year)
                  <option value="{{$year->revYear}}">{{$year->revYear}}</option>
            @endforeach
                  
            </select>

      </div>  

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
          <table id="rev_table"  class="table table-striped" width="50%">
            <thead>
            <tr>
              <th>Customer</th>
              <th>Currency</th>
              <th>Jan</th>
              <th>Feb</th>
              <th>Mar</th>
              <th>Apr</th>
              <th>May</th>
              <th>Jun</th>
              <th>July</th>
              <th>Aug</th>
              <th>Sep</th>
              <th>Oct</th>
              <th>Nov</th>
              <th>Dec</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($monthlyRevenueArray as $index=>$customer)
            
            <tr>
              <td>{{$index}}</td>
              <td>OMR</td>
              <td>{{number_format($customer[1],3)}}</td>
              <td>{{number_format($customer[2],3)}}</td>
              <td>{{number_format($customer[3],3)}}</td>
              <td>{{number_format($customer[4],3)}}</td>
              <td>{{number_format($customer[5],3)}}</td>
              <td>{{number_format($customer[6],3)}}</td>
              <td>{{number_format($customer[7],3)}}</td>
              <td>{{number_format($customer[8],3)}}</td>
              <td>{{number_format($customer[9],3)}}</td>
              <td>{{number_format($customer[10],3)}}</td>
              <td>{{number_format($customer[11],3)}}</td>
              <td>{{number_format($customer[12],3)}}</td>
                              
              
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
