@extends('admin_template') 

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Properties</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add Properties</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/props" method="POST" enctype="multipart/form-data">
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
              <label class="col-sm-2 control-label">Country</label>
              <div class="col-sm-10">
                <select name="country" class='form-control' >
                  @foreach ($countries as $country)
                        <option value="{{$country->id}}" >{{ $country->countryName }}</option>                     
                  @endforeach
                </select>
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
                <select class="form-control selection-parent-item" name="propertyTypeID" ">
                      <option value="0">Select a type</option>
                    @foreach ($propTypes as $prop)
                      <option value="{{$prop->propertyTypeID}}">{{ $prop->propertyDescription }}</option>
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Property Sub Type</label>
              <div class="col-sm-10">
                <select class="form-control selection-child-item" name="propertySubTypeID">
                      <option value="0">Select a type</option>
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
                    <option value="">Select an ownership type</option>
                    <option value="1">Rent</option>
                    <option value="2">Own</option>
                </select>
              </div>
            </div>             

            <div class="form-group">
              <label class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control" name="rentalOwnerID" >
                    <option value="">Select a rental owner</option>
                    @foreach ($rentalowners as $rentalowner)
                      <option value="{{$rentalowner->rentalOwnerID}}">{{ $rentalowner->firstName }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Property Image</label>
              <div class="col-sm-10">
                <input type="file" name="propertyImage" accept="image/*">
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
      <h1>Properties</h1>
  </section>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Property</b>
  </button>
</div>
<div class="panel panel-default give-space">
    
    <div class="panel-body">
        @if (count($props) > 0)
            <table class="table table-bordered table-striped" id="props-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>Name</th>
                          <th>Description</th> 
                          <th>Property Type</th>
                          <th>Rental Owner</th>
                          <th>Number Of Units</th>
                          <th>Country</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Rent/Own</th>
                          <th>Actions</th>
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
        ordering: false,
        ajax: {
          'url' : 'props/all',
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
          { "width": "10%", "targets": 9 }
        ],
        columns: [
            { data: 'pPropertyName', name: 'pPropertyName'},  
            { data: 'description', name: 'description'},  
            { data: 'propertySubTypeDescription', name: 'propertysubtypeid.propertySubTypeDescription'},  
            { data: 'firstName', name: 'rentalowners.firstName'},  
            { data: 'numberOfUnits', name: 'numberOfUnits'},  
            { data: 'countryName', name: 'countries.countryName'},  
            { data: 'address', name: 'address'},  
            { data: 'city', name: 'city'},  
            { 
              data: 'forRentOrOwn',
              name: 'forRentOrOwn',
              render: function ( data, type, full, meta ) {
                if(data == 1)
                  return 'Rent';

                if(data == 2)
                  return 'Own';
              }
            },
            {
                data: 'PropertiesID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<div class="inner"><a class="btn btn-info btn-sm" href="prop/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="prop/'+data+'">';
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

    $('.selection-child-item').parent().parent('.form-group').hide();
  
    // Load content based on previous selection
    $('.selection-parent-item').on('change', function(){
      $('.selection-child-item').parent().parent('.form-group').show();
      $.ajax({
          url: "/prop/subtypelist/"+$(this).val()+"",
          context: document.body,
          method: 'POST',
          headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
      })
      .done(function(data) {            
        $('.selection-child-item').html(function(){
            // Generate the seletect list
            var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
            data.forEach(function( index, element ){
                output += '<option value="'+data[element].propertySubTypeID+'">'+data[element].propertySubTypeDescription+'</option>';
            });
            output += '</select>';
            return output;
        });
      });
    });
});
</script>
@endpush
