@extends('admin_template')

@section('content')
<div class="container-fluid">
	<h2>Administrator</h2>
	<br />
	<div class="row">
		<div class="col-md-2">
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
			          <td><a class='link' href="#company" data-section="company/edit/{{ Sentinel::getUser()->companyID }}">Company Infomation</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' href="#users" data-section="users">Users</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' href="#roles" data-section="roles" >Roles</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' href="#supplier" data-section="supplier">Supplier</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' href="#customer" data-section="customer">Customer</a></td>
			        </tr>
			      </tbody>
			      </table>
			    </div>
			    <!-- /.box-body -->
			</div>
		
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
			          <td><a href="#maintainancetypes">Maintenance Type</a></td>
			        </tr>
			      </tbody></table>
			    </div>
			    <!-- /.box-body -->
			</div>
		
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
			          <td><a href="#accounts" data-section="accounts" class="link">Chart of Accounts</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' data-section="currency" href="#currency">Currency</a></td>
			        </tr>
			        <tr>
			          <td><a class='link' data-section="paymenttype" href="#paymenttype">Payment Type</a></td>
			        </tr>
			      </tbody></table>
			    </div>
			    <!-- /.box-body -->
			</div>
		</div>
		<div class="col-md-9">
			
			<div class="page-content-wrapper">
				<div class="">
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



    $('.proptype.item-editable').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
        method: 'POST',
        url:'/jobcards/update',  
        title: 'Edit',
        send:'always',   
        params: function(params) {
            //originally params contain pk, name and value
            params.field = $(this).attr('jcfield');
            params._token = '{{ csrf_token() }}';
            return params;
        }         
    });
   

    $( document ).ajaxComplete(function() {
    	$('.load-container').fadeOut();
	      $('.delete-btn-ajax').on('click', function(event){
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

	       $('.delete-btn-ajax').closest('form').on('submit', function(e) {
	       	e.preventDefault();
	        var section = $(this).data('section');
	        $.ajax({
	            url : $(this).attr('action'),
	            type: "POST",
	            data: $(this).serialize(),
	            success: function (data) {
	                console.info('success');
					$('.page-content').show();
					$('.load-container').fadeIn();
					$('.page-content .body').load( "/"+section+"/");

	            },
	            error: function (jXHR, textStatus, errorThrown) {
	                console.info(errorThrown);
	            }
	        });
	       });


	    $('.ajax-process').on('submit', function(e) {
	        e.preventDefault();
	        $('#myModal').modal('hide');
	        var section = $(this).find('button').data('section');
	        $.ajax({
	            url : $(this).attr('action'),
	            type: "POST",
	            data: $(this).serialize(),
	            success: function (data) {
	                console.info('success');
					$('.page-content').show();
					$('.load-container').fadeIn();
					$('.page-content .body').load( "/"+section+"/");

	            },
	            error: function (jXHR, textStatus, errorThrown) {
	                console.info(errorThrown);
	            }
	        });
	    });

	    $('.proptype.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/propertytype',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        }         
	    });
	    $('.propsubtype-parent.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'/update/propertysubtype',  
	        title: 'Edit',
	        send:'always',
	        type: "select",
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	        source : [
	        @foreach ($propertytypes as $propertytype)
	          {value: "{{$propertytype->propertyTypeID}}", text:"{{ $propertytype->propertyDescription }}"},
	        @endforeach
	        ],
	    });
	    $('.propsubtype.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'/update/propertysubtype',  
	        title: 'Edit',
	        send:'always',
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	    }); 
	    $('.currency.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'/update/currency',  
	        title: 'Edit',
	        send:'always',
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	    });
	    $('.paymenttype.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'/update/paymenttype',  
	        title: 'Edit',
	        send:'always',
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	    });
	    $('.supplier.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/supplier',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        }         
	    });
	    $('.accounts.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/account',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        }         
	    });
	    $('.accounts-type.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/account',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	        source : [
              {value: "1", text:"Expense"},
              {value: "2", text:"Income"},
              {value: "3", text:"Current Asset"},
              {value: "4", text:"Fixed Asset"},
              {value: "5", text:"Current Liability"},
              {value: "6", text:"Long Term Liability"},
              {value: "7", text:"Equity"},
              {value: "8", text:"Non-Operating Income"},
              {value: "9", text:"Non-Operating Expense"},
            ],       
	    });
	    $('.user.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/account',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        },
	        source : [
              {value: "1", text:"Expense"},
              {value: "2", text:"Income"},
            ],       
	    });
		$('.customer.item-editable').editable({
	        validate: function(value) {
	            if($.trim(value) == '') 
	                return 'Value is required.';
	        },
	        method: 'POST',
	        url:'update/customer',  
	        title: 'Edit',
	        send:'always',   
	        params: function(params) {
	            //originally params contain pk, name and value
	            params._token = '{{ csrf_token() }}';
	            return params;
	        }         
	    });
    });
  });
</script>
@endpush

