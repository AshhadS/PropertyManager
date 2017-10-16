<section class="">

<section id="printSection">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Revenue by Unit
            <small class="pull-right">Date: {{ date("Y/m/d")}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">

       <div class="form-group col-xs-3">
            <label for="">Filter By Year</label>

            <select class="form-control input-sm" id="unit-state" name="state" >
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
            @foreach ($monthlyRevenueArray as $index=>$unit)
            
            <tr>
              <td>{{$index}}</td>
              <td>OMR</td>
              <td>{{number_format($unit[1],3)}}</td>
              <td>{{number_format($unit[2],3)}}</td>
              <td>{{number_format($unit[3],3)}}</td>
              <td>{{number_format($unit[4],3)}}</td>
              <td>{{number_format($unit[5],3)}}</td>
              <td>{{number_format($unit[6],3)}}</td>
              <td>{{number_format($unit[7],3)}}</td>
              <td>{{number_format($unit[8],3)}}</td>
              <td>{{number_format($unit[9],3)}}</td>
              <td>{{number_format($unit[10],3)}}</td>
              <td>{{number_format($unit[11],3)}}</td>
              <td>{{number_format($unit[12],3)}}</td>
                              
              
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
          <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          
        </div>
      </div>
    </section>


