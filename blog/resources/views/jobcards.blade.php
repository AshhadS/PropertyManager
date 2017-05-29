@extends('admin_template')

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add jobcard</h3>
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
                <select name="PropertiesID" class="form-control" >
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
                    @foreach ($tenants as $tenant)
                        <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-10">
                <select class="form-control" name="unitID">
                    @foreach ($units as $unit)
                        <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="jobcardStatusID" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control" name="jobcardStatusID">
                  <option value="1">In Progress</option>
                  <option value="2">Completed</option>
                  <option value="3 ">deffered</option>
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

    
<div class="panel panel-default">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#myModal">
      <i class="fa fa-plus"> Add Jobcard</i>
    </button><br /><br />
    <div class="panel-heading">
        jobcard
    </div>
    <div class="panel-body">
        @if (count($jobcards) > 0)
            <table class="table table-striped task-table" id="jobcards-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>Subject</th>
                          <th>Description</th> 
                          <th>Status</th>
                          <th>Property Name</th>
                          <th>Tenant Name</th>
                          <th>Unit</th>
                          <th>View</th>
                        </tr>
                </thead>

                       
            </table>
        @endif
    </div>
</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#jobcards-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          'url' : 'jobcards/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        columns: [
            { data: 'subject', name: 'jobcard.subject'},  
            { data: 'description', name: 'jobcard.description'},  
            { 
              data: 'jobcardStatusID',
              name: 'jobcardStatusID',
              render: function ( data, type, full, meta ) {
                if(data == 1)
                  return 'In Progress';

                if(data == 2)
                  return 'Completed';

                if(data == 3)
                  return 'Deferred';
              }
            },  
            { data: 'pPropertyName', name: 'Properties.pPropertyName'},  
            { data: 'firstName', name: 'tenats.firstName'},  
            { data: 'unitNumber', name: 'units.unitNumber'},  
            {
                data: 'jobcardID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  return '<a href="jobcard/edit/'+data+'">View</a>';
                }
            }      
        ]
    });
});
</script>
@endpush
