@extends('admin_template')

@section('content')
<title>IBSS | Dashboard</title>
<br />
<div class="container-fluid dashboard-page">

<div class="row">
	<div class="col-lg-5ths col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-aqua">
		    <div class="inner">
		      <h3>{{ $propCount }}</h3>

		      <p>Properties</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-building"></i>
		    </div>
		    <a href="/props" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
	</div>
	<!-- ./col -->
	<div class="col-lg-5ths col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-green">
		    <div class="inner">
		      <h3>{{ $propOwnerCount }}</h3>

		      <p>Property Owners</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-user-secret"></i>
		    </div>
		    <a href="/rentalowners" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
	</div>
	<!-- ./col -->
	<div class="col-lg-5ths col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-yellow">
		    <div class="inner">
		      <h3>{{ $unitCount }}</h3>

		      <p>Units</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-university"></i>
		    </div>
		    <a href="/units" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->

		<div class="col-lg-5ths col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-red">
		    <div class="inner">
		      <h3>{{ $tenantsCount }}</h3>

		      <p>Tenants</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-users"></i>
		    </div>
		    <a href="/tenants" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		<!-- ./col -->

		<div class="col-lg-5ths col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-light-purple">
		    <div class="inner">
		      <h3>{{ $jobcardsCount }}</h3>

		      <p>JobCards</p>
		    </div>
		    <div class="icon">
		      <i class="fa fa-book"></i>
		    </div>
		    <a href="/jobcards" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
</div>

<div class="row"><!-- /2nd row starting -->	

	<div class="col-md-4">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title text-green"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;Monthly Revenue</h3>
				<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="col-md-12">
					 <select class="form-control input-sm" id="year-state" name="state" >
              						<option value="{{date("Y")}}" selected="selected">{{date("Y")}}</option>
             						@foreach ($monthlyRevenueYear as $revYear)
                  						<option value="{{$revYear->revYear}}">{{$revYear->revYear}}</option>
            						@endforeach
                  
            		</select>

					<div class="chart-responsive">
		                <canvas id="revenuChart" height="160" width="328" style="width: 328px; height: 160px;"></canvas>
		        	</div>
	        	</div>
	        </div>

		</div>

	</div>

	<div class="col-md-4">

			<div class="box box-warning">		
				<div class="box-header with-border">
					<h3 class="box-title text-yellow"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;PAYABLES</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<ul class="nav nav-stacked">
						@foreach($TopFivePayables as $payable)
						<li>  					
							<a href="#">
								{{$payable->supplierName}}
								<span class="pull-right">OMR {{number_format($payable->outstandingAmount,3)}}</span>
							</a>
						</li>
						@endforeach 	
					</ul><!-- list -->
				</div><!-- /.box-body -->
				<div class="box-footer text-center">
					<a target="_blank" href="/reports_suppliersummary" class="uppercase">View All</a>
				</div>
				<!-- /.box-footer -->
			</div><!-- /.box -->
		</div><!-- /.col -->

	
<!-- /.Payables -->
		<div class="col-md-4">
			<div class="box box-success">		
				<div class="box-header with-border">
					<h3 class="box-title text-green"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;RECEIVABLES</h3>
					<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<!-- <ul class="products-list product-list-in-box"> -->
					<ul class="nav nav-stacked">
						@foreach($TopFiveReceivables as $receivable)
							<li>  					
								<a href="#">
									{{$receivable->customerName}}
									<span class="pull-right">OMR {{number_format($receivable->outstandingAmount,3)}}</span>
								</a>
							</li>
						@endforeach
					</ul><!-- list -->
				</div><!-- /.box-body -->
				<div class="box-footer text-center">
					<a target="_blank" href="/reports_customersummary" class="uppercase">View All</a>
				</div>
				<!-- /.box-footer -->
			</div><!-- /.box -->
		</div><!-- /.col -->

<!-- /Receivable -->
		
</div>	 <!-- /.row -->	
<div class="row"><!-- /2nd row starting -->	
	<div class="col-md-4">
		<div class="box box-primary">		
			<div class="box-header with-border">
				<h3 class="box-title text-light-blue"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;EXPIRING AGREEMENTS</h3>
				<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				<ul class="nav nav-stacked">
					<li class>
						
							<a href="#">
							Agreements Expiring in 30 days
							<span class="label label-danger pull-right">{{ $ExpiringAgreemntsOneMonthCount }}</span></a>
						
					</li>
					
					<li>
						
							<a href="#">
							Agreements Expiring in 31-60 days
							<span class="label label-danger pull-right">{{ $ExpiringAgreemntsTwoMonthCount }}</span></a>
						
					</li>
					<li>
						
							<a href="#">
							Agreements Expiring in 61-90 days
							<span class="label label-danger pull-right">{{ $ExpiringAgreemntsThreeMonthCount }}</span></a>
						
					</li>
				</ul>
			</div><!-- /.box-body -->

			<div class="box-footer text-center">
				<a target="_blank" href="/agreements" class="uppercase">View All Agreements</a>
			</div>
			<!-- /.box-footer -->
		</div><!-- /.box -->
		<!-- Expire Agreements -->
	</div><!-- /Coloumn -->

	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title text-aqua"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;CASH/BANK POSITION</h3>
				<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body table-responsive">

			  	<table id="tblbankpos" class="table table-striped table-bordered" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Bank Name</th>
				                <th>Account No</th>
				                <th>Currency</th>
				                <th>Book Balance</th>
				             
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($clearedAmounts as $clearedAmount)
				        		@if ($clearedAmount->bankName!=null)
				            		<tr>				            
					                	<td>{{$clearedAmount->bankName}}</td>
					                	<td>{{$clearedAmount->accountNumber}}</td>
					                	<td>OMR</td>
					                	<td>{{number_format($clearedAmount->totalclearedPaymentAmount + $clearedAmount->totalclearedReceiptAmount)}}</td>
					           
				            		</tr>
				            	@endif
				            @endforeach
				        </tbody>
				</table>

			</div>

		</div>

	</div>

	<div class="col-md-4">
	     <div class="box box-danger">

			<div class="box-header with-border">
			  <h3 class="box-title text-red"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;&nbsp;JOBCARD SUMMARY</h3>
			</div>	        
	        <!-- /.box-header -->
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-7">
	              <div class="chart-responsive">
	                <canvas id="pieChart" height="160" width="328" style="width: 328px; height: 160px;"></canvas>
	              </div>
	              <!-- ./chart-responsive -->
	            </div>
	            <!-- /.col -->
	            <div class="col-md-5">
	              <ul class="chart-legend clearfix">
	                <li><i class="fa fa-circle-o text-red"></i> New</li>
	                <li><i class="fa fa-circle-o text-green"></i> In Progress</li>
	                <li><i class="fa fa-circle-o text-yellow"></i> Resolved</li>
	                <li><i class="fa fa-circle-o text-aqua"></i> Completed</li>
	                <li><i class="fa fa-circle-o text-light-blue"></i> Differed</li>
	                <li><i class="fa fa-circle-o text-gray"></i> Pending For Clarification From Reporter</li>
	              </ul>
	            </div>
	            <!-- /.col -->
	          </div>
	          <!-- /.row -->
	        </div>
	        <!-- /.box-body -->
	     </div>
	    </div><!-- /.col -->

	
		
</div>	 <!-- /.row -->	



<div class="row">
	
 </div><!-- /Row -->
</div><!-- /container-fluid -->

@endsection

@push('scripts')
<script>
$(function() {

	var ctx = document.getElementById('pieChart');
	var options = {
		legend: {
		    display: false,
		}
	};
	var data = {
	  datasets: [{
	      data: [
	      @foreach($jobCardStatusCount as $key => $status)
	        {{$status}},
	      @endforeach
	      ],
	      backgroundColor: [
	        'rgba(221, 75, 57, 1)', //Red
	        'rgb(0, 166, 90)', //Green
	        'rgb(243, 156, 18)', //Yellow
	        'rgb(0, 192, 239)', //Acqua
	        'rgb(60, 141, 188)', //Light Blue
	        'rgb(60, 141, 188)', //Grey
	      ]
	  }],
	  // These labels appear in the legend and in the tooltips when hovering different arcs
	  labels: [
	      'New',
	      'In Progress',
	      'Resolved',
	      'Completed',
	      'Differed',
	      'Pending For Clarification From Reporter',
	  ]
	};
	var myChart = new Chart(ctx, {
		type: 'doughnut',
		data: data,
		options: options
	});
	calculate(150, 200);
	function calculate(actual, total){
	  var perc="";
	  if(isNaN(total) || isNaN(actual)){
	      perc=" ";
	     }else{
	     perc = ((actual/total) * 100).toFixed(3);
	     }
	  
	  console.log(perc);
	}



});

$(document).ready(function() {
    $('#tblbankpos').DataTable({

    	searching: false,
    	lengthChange: false

    });

      

} );

$( "#year-state" ).change(function() {
        //this is the #state dom element
        var state = $(this).val();
        
        // parameter 1 : url
        // parameter 2: post data
        //parameter 3: callback function 
        $.get( '/dasboard_rev' , { state : state } , function(response){ 
        //htmlCode is the code retured from your controller
        	
            var ctx = document.getElementById("revenuChart");
		var myChart = new Chart(ctx, {
				    type: 'bar',
				    data: {
				        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				       
				        datasets: [{
				            label: 'Amount in OMR',
				            data: response,
				            backgroundColor: [
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(75, 192, 192, 0.2)'
				            ],
				            borderColor: [
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(75, 192, 192, 1)'
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				        scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});

        });
      });


var ctx = document.getElementById("revenuChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
       
        datasets: [{
            label: 'Amount in OMR',
            data: [
            	
	        	@foreach($monthlyRevenueArray as $key => $value)
	        			{{$value}},
	      		@endforeach
	        		   		

            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>
@endpush