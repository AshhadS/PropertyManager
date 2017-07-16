@extends('admin_template')

@section('content')
<br />
<div class="container-fluid">
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
		<!-- ./col -->
	</div>
	<div class="row">
	    <div class="col-md-4">
	      <div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title text-light-blue"><i class="fa fa-list" aria-hidden="true"></i> <b>Jobcard Card Summary</b></h3>
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
	    </div>
	</div>
</div>
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
</script>
@endpush