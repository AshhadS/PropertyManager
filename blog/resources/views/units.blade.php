@extends('admin_template')

@section('content')

    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#myModal">
      <i class='fa fa-plus'></i> Add
    </button>

    <br />
    <br />

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Unit</h4>
          </div>
          <div class="modal-body">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Description</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="/units" method="POST">
                  {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Unit Number</label>
                    <div class="col-sm-10">
                      <input type="text" name="unitNumber" class="form-control input-req" id="inputEmail3" placeholder="Unit Number">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="description" rows="2" placeholder="Description"></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Size</label>
                    <div class="col-sm-10">
                      <input type="text" name="size" class="form-control" id="inputEmail3" placeholder="Size">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Market Rent</label>
                    <div class="col-sm-10">
                      <input type="text" name="marketRent" class="form-control" id="inputEmail3" placeholder="Market Rent">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Property Name </label>
                    <div class="col-sm-10">
                      <select name="PropertiesID" class="form-control" >
                          @foreach ($properties as $property)
                              <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
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

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="units-table">
            <thead>
                <tr>
                    <th>Unit Number</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Market Rent</th>
                    <th>Property Name</th>
                    <th>View</th>

                </tr>
            </thead>
        </table>
    </div>
    @foreach ($properties as $property)
      <p>{{ $property->PropertiesID}} - {{ $property->pPropertyName}}</p>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#units-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          'url' : 'unit/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        columns: [
            { data: 'unitNumber', name: 'unitNumber' },
            { data: 'description', name: 'units.description' },
            { data: 'size', name: 'size' },
            { data: 'marketRent', name: 'marketRent' },
            { data: 'pPropertyName', name: 'properties.pPropertyName'},
            {  
                data: 'unitID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  return '<a href="unit/edit/'+data+'">View</a>';
                }
            }     
        ]
    });
});
</script>
@endpush