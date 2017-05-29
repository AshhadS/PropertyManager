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
          <h3 class="box-title">Add prop</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/props" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" name="pPropertyName" class="form-control input-req"  placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" placeholder="Description"></textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="2" name="address" placeholder="Address"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">City</label>
              <div class="col-sm-10">
                <input type="text" name="city" class="form-control"  placeholder="City">
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Number of units</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" name="numberOfUnits" placeholder="Number of units">
              </div>
            </div>  

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Property Type</label>
              <div class="col-sm-10">
                <select class="form-control" name="propertySubTypeID">
                    @foreach ($propSubTypes as $prop)
                        <option value="{{$prop->propertySubTypeID}}">{{ $prop->propertySubTypeDescription }}</option>
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label for="inputEmail3" name="forRentOrOwn" class="col-sm-2 control-label">Rent / Own</label>
              <div class="col-sm-10">
                <select class="form-control" name="forRentOrOwn">
                    <option value="1">Rent</option>
                    <option value="2">Own</option>
                </select>
              </div>
            </div>             

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control" name="rentalOwnerID">
                  @foreach ($rentalowners as $rentalowner)
                        <option value="{{$rentalowner->RentalOwnerID}}">{{ $rentalowner->firstName }}</option>
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

    
<div class="panel panel-default">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#myModal">
      <i class="fa fa-plus"> Add Property</i>
    </button>
    <div class="panel-heading">
        prop
    </div>
    <div class="panel-body">
        @if (count($props) > 0)
            <table class="table table-striped task-table" id="props-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>Name</th>
                          <th>Description</th> 
                          <th>Property Type</th>
                          <th>Rental Owner</th>
                          <th>Number Of Units</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Rent/Own</th>
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
    $('#props-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          'url' : 'props/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        columns: [
            { data: 'pPropertyName', name: 'pPropertyName'},  
            { data: 'description', name: 'description'},  
            { data: 'propertySubTypeID', name: 'propertySubTypeID'},  
            { data: 'rentalOwnerID', name: 'rentalOwnerID'},  
            { data: 'numberOfUnits', name: 'numberOfUnits'},  
            { data: 'address', name: 'address'},  
            { data: 'city', name: 'city'},  
            { data: 'forRentOrOwn', name: 'forRentOrOwn'},  
            {
                data: 'PropertiesID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  return '<a href="prop/edit/'+data+'">View</a>';
                }
            }      
        ]
    });
});
</script>
@endpush
