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
</div>
@endsection

