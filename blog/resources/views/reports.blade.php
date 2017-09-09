@extends('admin_template')

@section('content')

<div class="container-fluid">
 <h2>Reports</h2>
  <br />
   <br/>
</div>

<div class="row">
    <div class="col-md-2">
      <div class="box simple-list">
          <div class="box-header">
            <h3 class="box-title">Supplier</h3>
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
                <td><a class='link' href="#reports_supplierstatement" data-section="reports_supplierstatement">Supplier Statement</a></td>
              </tr>
              <tr>
                <td><a class='link' href="#reports_suppliersummary" data-section="reports_suppliersummary">Supplier Summary</a></td>
              </tr>
            </tbody>
            </table>
          </div>
          <!-- /.box-body -->
      </div>

      <div class="box simple-list">
          <div class="box-header">
            <h3 class="box-title">Customer</h3>
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
                <td><a class='link' href="#reports_customerstatement" data-section="reports_customerstatement">Customer Statement</a></td>
              </tr>
              <tr>
                <td><a href="#reports_customersummary" data-section="reports_customersummary" class="link">Customer Summary</a></td>
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

      $( "#supplier-state" ).change(function() {
        //this is the #state dom element
        var state = $(this).val();
        
        // parameter 1 : url
        // parameter 2: post data
        //parameter 3: callback function 
        $.get( '/reports_supplierstatement_data' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
            $("#domains_table tbody").html(htmlCode);
        });
      });

      $( "#customer-state" ).change(function() {
        //this is the #state dom element
        var state = $(this).val();
        
        // parameter 1 : url
        // parameter 2: post data
        //parameter 3: callback function 
        $.get( '/reports_customerstatement_data' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller
            $("#domains_table tbody").html(htmlCode);
        });
      });
    });
});

</script>
@endpush