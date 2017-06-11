@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Jobcards</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add Jobcard</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/jobcards" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" name="subject" class="form-control input-req" required placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" placeholder="Description"></textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Property Name</label>
              <div class="col-sm-10">
                <select name="PropertiesID" class="form-control selection-parent-item" >
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
                <select class="form-control" name="tenantsID">
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
                <select class="form-control selection-child-item" name="unitID">
                        <option value="0">Select a unit</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                    @endforeach
                </select>
                <p class="no-units">No units belonging to this property</p>
              </div>
            </div>

            <div class="form-group">
              <label name="jobcardStatusID" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control" name="jobcardStatusID">
                  @foreach ($jobcardstatuss as $jobcardstatus)
                      <option value="{{$jobcardstatus->jobcardStatusID}}">{{ $jobcardstatus->statusDescription }}</option>
                  @endforeach
                </select>
              </div>
            </div>                               
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <input type="reset" class="btn btn-default" value="Reset" />
            <button type="submit" class="btn btn-info pull-right">Save</button>
          </div>
          <!-- /.box-footer -->
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
<div class="page-header container-fluid">
  <section class="content-header pull-left">
      <h1>Jobcards</h1>
  </section>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Jobcard</b>
  </button>
</div>

<div class="panel panel-default give-space">
    <div class="panel-body">
            <table class="table table-bordered table-striped" id="jobcards-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>Subject</th>
                          <th>Description</th> 
                          <th>Property Name</th>
                          <th>Status</th>
                          <th>Tenant Name</th>
                          <th>Unit</th>
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
    $('#jobcards-table').DataTable({
        processing: true,
        ordering: false,
        serverSide: true,
        ajax: {
          'url' : 'jobcards/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "initComplete": function(settings, json) {
         $('.delete-btn').on('click', function(e){
          e.preventDefault();
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

         })
        },
        "columnDefs": [
          { "width": "10%", "targets": 6 }
        ],
        columns: [
            { data: 'subject', name: 'jobcard.subject'},  
            { data: 'description', name: 'jobcard.description'},  
            { data: 'pPropertyName', name: 'Properties.pPropertyName'},  
            { data: 'statusDescription', name: 'jobcardstatus.statusDescription'},  
            { data: 'firstName', name: 'tenats.firstName'},  
            { data: 'unitNumber', name: 'units.unitNumber'},  
            {
                data: 'jobcardID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<center><span class="inner"><a class="btn btn-info btn-sm" href="jobcard/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="jobcard/'+data+'">';
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
                        output += '<option value="'+data[element].unitID+'">'+data[element].unitNumber+'</option>';
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
});
</script>
@endpush
