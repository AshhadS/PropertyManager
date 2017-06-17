@extends('admin_template')

@section('content')
<div class="container-fluid">
	<h2>Administrator</h2>
	<br />
	<div class="row">
		<div class="col-md-4">
			<div class="box simple-list">
			    <div class="box-header">
			      <h3 class="box-title">Configuration</h3>
			      <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div>
			    </div>
			    <!-- /.box-header -->
			    <div class="box-body no-padding">
			      <table class="table table-striped">
			        <tbody>
			        <tr>
			          <td><a href="#">Company Infomation</a></td>
			        </tr>
			        <tr>
			          <td><a href="/users">Users</a></td>
			        </tr>
			        <tr>
			          <td><a href="#">Roles</a></td>
			        </tr>
			        <tr>
			          <td><a href="#">Supplier</a></td>
			        </tr>
			      </tbody></table>
			    </div>
			    <!-- /.box-body -->
			</div>
		</div>
		<div class="col-md-4">
			<div class="box simple-list">
			    <div class="box-header">
			      <h3 class="box-title">Property Configuration</h3>
			      <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div>
			    </div>
			    <!-- /.box-header -->
			    <div class="box-body no-padding" >
			      <table class="table table-striped">
			        <tbody >
			        <tr>
			          <td><a class='link' href="#properytype" data-section="propertytypes">Property Type</a></td>
			        </tr>
			        <tr>
			          <td><a href="#propertysubtypes" data-section="propertysubtypes" class="link">Property Sub Type</a></td>
			        </tr>
			        <tr>
			          <td><a href="/maintainancetypes">Maintenance Type</a></td>
			        </tr>
			      </tbody></table>
			    </div>
			    <!-- /.box-body -->
			</div>
		</div>
		<div class="col-md-4">
			<div class="box simple-list">
			    <div class="box-header">
			      <h3 class="box-title">Finance Configuration</h3>
			      <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div>
			    </div>
			    <!-- /.box-header -->
			    <div class="box-body no-padding">
			      <table class="table table-striped">
			        <tbody>
			        <tr>
			          <td><a href="#">Chart of Accounts</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' data-section="currency" href="#">Currency</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' data-section="paymenttype" href="#">Payment Type</a></td>
			        </tr>
			      </tbody></table>
			    </div>
			    <!-- /.box-body -->
			</div>
		</div>
		<div class="page-content-wrapper">
			<br/>
			<br/>
			<div class="container">
				<div class="page-content"  style="display: none">
					<div class="load-container" style="">
						<div class="loader">Loading...</div>
					</div>		
					<div class="body"></div>	
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



@push('scripts')
<script>
  $(function() {
    $('.link').on('click', function(event){
      event.preventDefault();
      $('.page-content').show();
      $('.load-container').fadeIn();
      $('.page-content .body').load( "/"+$(this).data('section')+"/");
    });
   

    $( document ).ajaxComplete(function() {
    	$('.load-container').fadeOut();
      $('.delete-btn' ).on('click', function(event){
        event.preventDefault();
        btn = this;
        if($(btn).hasClass('activate')){
          console.log('Now delete!'); 
          $(btn).closest('form.delete-form').submit();
        } else{
        $(btn).addClass('activate');
          setTimeout(function(){
            $(btn).removeClass('activate');
          }, 5000);
        }
      });
    });
  });
</script>
@endpush