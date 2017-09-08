@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="">
        <div class="box box-info">
        <!-- form start -->
        <form class="form-horizontal" action="/agreement" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Property Name</label>
              <div class="col-sm-10">
                <select name="PropertiesID" class="form-control selection-parent-item input-req" >
                        <option value="0">Select a property</option>
                    @foreach ($properties as $property)
                        <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Tenant Name</label>
              <div class="col-sm-10">
                <select class="form-control  input-req" name="tenantsID">
                        <option value="">Select a tenant</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-10">
                <select class="form-control selection-child-item input-req" name="unitID">
                        <option value="0">Select a unit</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                    @endforeach
                </select>
                <p class="no-units">No units belonging to this property</p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Rent Amount</label>
              <div class="col-sm-10">
                <input type="tel" name="marketRent" class="form-control input-req" placeholder="Market Rent">
              </div>
            </div>
             <div class="form-group">
              <label class="col-sm-2 control-label">Rent Cost</label>
              <div class="col-sm-10">
                <input type="tel" name="actualRent" class="form-control input-req"  placeholder="Actual Rent">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">From</label>
              <div class="col-sm-10">
                <input type="text" name="dateFrom" class="form-control datepicker input-req" placeholder="Agreement start date">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">To</label>
              <div class="col-sm-10">
                <input type="text" name="dateTo" class="form-control datepicker input-req" placeholder="Agreement end date">
              </div>
            </div>
            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Payment Type</label>
              <div class="col-sm-10">
                <select class="form-control input-req" name="paymentTypeID">
                        <option value=''>Select a payment type</option>
                    @foreach ($paymentypes as $paymenttype)
                        <option value="{{$paymenttype->paymentTypeID}}">{{ $paymenttype->paymentDescription }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label"> PDCYN</label>
              <div class="col-sm-10">
                <div class="checkbox"> <label> <input type="checkbox" name="pdcyn" value="1"> Available </label> 
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <div class="form-buttons">
              <input type="reset" class="btn btn-default" value="Reset" />
              <button type="submit" class="btn btn-info pull-right">Save</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
     
<div class="panel panel-default give-space">
    <div class="panel-body">
      <div class="page-header container-fluid">
        <section class="content-header pull-left">
            <h4><b>AGREEMENT</b></h4>
        </section>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> Add Agreement
        </button>
      </div>
            <table class="table table-bordered table-striped" id="agreements-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>Property Name</th>
                          <th>Unit</th> 
                          <th>Tenant Name</th>
                          <th>Rent Amount</th>
                          <th>Rent Cost</th>
                          <th>Payment Type</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                </thead>

                       
            </table>
    </div>
</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#agreements-table').DataTable({
        processing: true,
        ordering: false,
        serverSide: true,
        ajax: {
          'url' : 'agreement/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "initComplete": function(settings, json) {
         $('.attachment-edit-btn').on('click', function(){
            var id = $(this).data('id');
            $.ajax({
                  url: "/agreement/getfields/"+id+"",
                  context: document.body,
                  method: 'GET',
                  // headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
              })
              .done(function(data) {
                var agreement = data[0]; 
                var f_from = new Date(agreement.dateFrom);
                f_from = ("0" + f_from.getDate()).slice(-2) +'/'+ ("0" + (f_from.getMonth() + 1)).slice(-2) +'/'+ f_from.getFullYear();

                var f_to = new Date(agreement.dateTo);
                f_to = ("0" + f_to.getDate()).slice(-2) +'/'+ ("0" + (f_to.getMonth() + 1)).slice(-2) +'/'+ f_to.getFullYear();

                $('.agreement-edit [name="agreementID"]').val(agreement.agreementID);
                $('.agreement-edit [name="PropertiesID"] option[value='+ agreement.PropertiesID +']').attr('selected', 'selected');
                $('.agreement-edit [name="tenantsID"] option[value='+ agreement.tenantID +']').attr('selected', 'selected');
                $('.agreement-edit [name="actualRent"]').val(agreement.actualRent);
                $('.agreement-edit [name="marketRent"]').val(agreement.marketRent);
                $('.agreement-edit [name="dateFrom"]').val(f_from);
                $('.agreement-edit [name="dateTo"]').val(f_to);
                $('.agreement-edit [name="paymentTypeID"] option[value='+ agreement.paymentTypeID +']').attr('selected', 'selected');
                (agreement.isPDCYN ) ? $('.agreement-edit [name="pdcyn"]').prop('checked', true) : false;
                $('.agreement-edit [name="unitID"] option[value='+ agreement.unitID +']').attr('selected', 'selected');

                 childSelection($('.agreement-edit .selection-parent-item'))

                $('#agreement-editModal').modal('show');
              });
            });



        },
        "columnDefs": [
          { "width": "10%", "targets": 8 }
        ],
        columns: [
            { data: 'pPropertyName', name: 'Properties.pPropertyName'},  
            { data: 'unitNumber', name: 'units.unitNumber'},  
            { data: 'firstName', name: 'tenants.firstName'},  
            { data: 'marketRent', name: 'agreement.marketRent'},  
            { data: 'actualRent', name: 'agreement.actualRent'},  
            { data: 'paymentDescription', name: 'paymenttype.paymentDescription'},  
            { 
              data: 'dateFrom',
              name: 'agreement.dateFrom',
              render: function( data, type, full, meta ){
                var date = new Date(data);
                if(!isNaN(date.getTime())){
                  // return the two digit date and month
                  return ("0" + date.getDate()).slice(-2) +'/'+ ("0" + (date.getMonth() + 1)).slice(-2) +'/'+ date.getFullYear();
                }else{
                  // retun empty string if not selected
                  return data;
                }
              }
            },
            { 
              data: 'dateTo',
              name: 'agreement.dateTo',
              render: function( data, type, full, meta ){
                var date = new Date(data);
                if(!isNaN(date.getTime())){
                  // return the two digit date and month
                  return ("0" + date.getDate()).slice(-2) +'/'+ ("0" + (date.getMonth() + 1)).slice(-2) +'/'+ date.getFullYear();
                }else{
                  // retun empty string if not selected
                  return data;
                }
              }
            },  
            { 
              data: 'isSubmitted',
              name: 'agreement.isSubmitted',
              render: function(data){
                return (data == 1) ? "Submitted" : "Not Submitted";
              }
            },
            {
                data: 'agreementID',
                name: 'agreement.agreementID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<center><span class="inner"><a class="btn bg-green btn-sm attachment-edit-btn" href="/agreement/getfields/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';

                  action += '<form class="delete-form" method="POST" action="agreement/'+data+'">';
                  action += '<a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>';
                  action += '<i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span></a>';
                  action += '<input type="hidden" name="_method" value="DELETE"> ';
                  action += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
                  action += '</form></span></center>';
                  return action;
                }
            }      
        ]
    });
      // filter child selection on page load
      childSelection($('.selection-parent-item'));
      

      // $('.no-units').hide();
      // Load content based on previous selection
      $('.selection-parent-item').on('change', function(){
        childSelection(this)
      });

      function childSelection(elem){
        var prev_selection = $('.selection-child-item.edit').val();
        console.log(prev_selection); 
        if ($(elem).val() != 0) {
          $('.selection-child-item').show();
          $('.no-units').hide();
          $.ajax({
              url: "/jobcard/getunit/"+$(elem).val()+"",
              context: document.body,
              method: 'POST',
              headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
          })
          .done(function(data) {
              // show message if no units for the selected property
              if(data.length){
                $('.selection-child-item').html(function(){
                    // Generate the seletect list
                    var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
                    output += '<option value="">Select a unit</option>';
                    data.forEach(function( index, element ){
                        if(prev_selection == data[element].unitID){
                          output += '<option value="'+data[element].unitID+'" selected="selected">'+data[element].unitNumber+'</option>';
                        }else{
                          output += '<option value="'+data[element].unitID+'">'+data[element].unitNumber+'</option>';
                        }
                    });
                    output += '</select>';
                    return output;
                });
              }else{
                $('.selection-child-item').hide();
                $('.no-units').show();
              }         
          });
        }else{
          $('.selection-child-item').hide();
          $('.no-units').show();
        }      

      }

      
      $('#agreement-editModal').modal({ show: false})

      

      

});

// function prefil_form(id) {
        
//       }
</script>
@endpush
