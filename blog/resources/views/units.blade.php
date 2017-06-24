@extends('admin_template')

@section('content')

    <meta name="_token_del" content="{{ csrf_token() }}">
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog wide" role="document">
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
                      <textarea class="form-control input-req" name="description" rows="2" placeholder="Description"></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Size</label>
                    <div class="col-sm-10">
                      <input type="text" name="size" class="form-control input-req" id="inputEmail3" placeholder="Size">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Market Rent</label>
                    <div class="col-sm-10">
                      <input type="text" name="marketRent" class="form-control input-req" id="inputEmail3" placeholder="Market Rent">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Property Name </label>
                    <div class="col-sm-10">
                      <select name="PropertiesID" class="form-control input-req" >
                          <option value="">Select an property</option>
                          @foreach ($properties as $property)
                              <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>    

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Curreny</label>
                    <div class="col-sm-10">
                      <select name="currencyID" class="form-control input-req" >
                          <option value="">Select a currency</option>
                          @foreach ($currencies as $currency)
                              <option value="{{$currency->currencyID}}">{{ $currency->currencyCode }}</option>
                          @endforeach
                      </select>
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
    
<div class="page-header container-fluid">
  <section class="content-header pull-left">
      <h1>Units</h1>
  </section>


  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Unit</b>
  </button>
</div>

<div class="panel panel-default give-space">
    <div class="panel-body">
      <table class="table table-bordered table-striped" id="units-table">

          <!-- Table Headings -->
          <thead>
            <tr>
              <th>Unit Number</th>
              <th>Description</th>
              <th>Size</th>
              <th>Market Rent</th>
              <th>Currency</th>
              <th>Property Name</th>
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
    $('#units-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          'url' : 'unit/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columnDefs": [
          { "width": "10%", "targets": 6 }
        ],
        columns: [
            { data: 'unitNumber', name: 'unitNumber' },
            { data: 'description', name: 'units.description' },
            { data: 'size', name: 'size' },
            { data: 'marketRent', name: 'marketRent' },
            { data: 'currencyCode', name: 'currencymaster.currencyCode' },
            { data: 'pPropertyName', name: 'properties.pPropertyName'},
            {  
                data: 'unitID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<div class="inner"><a class="btn btn-info btn-sm" href="unit/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="unit/'+data+'">';
                  action += '<a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>';
                  action += '<i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span></a>';
                  action += '<input type="hidden" name="_method" value="DELETE"> ';
                  action += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
                  action += '</form></div>';
                  return action;
                }
            }     
        ]
    });
});
</script>
@endpush