@extends('admin_template')

@section('content')
  <section class="content-header">
      <h1>Property</h1>
  </section>
  <br /><br />
    
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">Summary</a></li>
    <li role="presentation"><a href="#units" aria-controls="units" role="tab" data-toggle="tab">Units</a></li>
    <li role="presentation"><a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">Jobs</a></li>
    <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="view">
     <div class="row">
        <div class="col-md-12">
            <div class="box box-info"> 
                <!-- /.box-header -->
                <!-- form start -->
                    
                  <div class="box-body">
                    <div class="image-column col-md-3">
                      <div class="row">
                        <b><p class="col-md-6 control-label">Name</p></b>
                        <p class='col-md-6 conrol-label'>{{ $props->pPropertyName}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Description</p></b>
                        <p class='col-md-6 conrol-label'>{{ $props->description}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Property Sub Type</p></b>
                        <p class='col-md-6 conrol-label'>{{ $property_type_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Property Type</p></b>
                        <p class='col-md-6 conrol-label'>{{ $property_parent_type_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Number of units</p></b>
                        <p class='col-md-6 conrol-label'>{{ $props->numberOfUnits}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Property Owner name</p></b>
                        <p class='col-md-6 conrol-label'>{{ $rental_owner_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Address</p></b>
                        <p class='col-md-6 conrol-label'>{{ $props->address}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Country</p></b>
                        <p class='col-md-6 conrol-label'>{{ $countryName}}</p>
                      </div><br/> 
                      <div class="row">
                        <b><p class="col-md-6 control-label">City</p></b>
                        <p class='col-md-6 conrol-label'>{{ $props->city}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-md-6 control-label">Rent / Own</p></b>
                        <p class='col-md-6 conrol-label'>{{ $rent_or_own }}</p>
                      </div>
                    </div>
                      <div class="image-column col-md-4">
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Property Image</p></b>
                          <img class='show-image' src="/blog/storage/app/uploads/{{$props->propertyImage}}" alt="Property Image">
                        </div>
                      </div>

                      <div class="col-md-3 att-column">
                        @component('attachments', ['props' => $props, 'attachments' => $attachments])

                        @endcomponent
                      </div>
                      <br/> <br/>  
                    
                  </div>
            </div>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="edit">
     <div class="row">
        <div class="col-md-12">
            <div class="box box-info"> 
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="/props/update" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
          <div class="box-body">
                <input type="hidden" name="PropertiesID" class="form-control" value="{{ $props->PropertiesID}}"  placeholder="Subject">
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" name="pPropertyName" class="form-control input-req" value="{{ $props->pPropertyName}}"  placeholder="Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" value="" placeholder="Description">{{ $props->description}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Country</label>
              <div class="col-sm-10">
                <select name="country" class='form-control' value="{{ $props->country}}" >
                  @foreach ($countries as $country)
                      @if($props->country == $country->id)
                        <option value="{{$country->id}}" selected="selected">{{ $country->countryName }}</option>
                      @else
                        <option value="{{$country->id}}">{{ $country->countryName }}</option>
                      @endif
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="2" name="address" placeholder="Address">{{ $props->address}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">City</label>
              <div class="col-sm-10">
                <input type="text" name="city" class="form-control" value="{{ $props->city}}" placeholder="City">
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Number of units</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" value="{{ $props->numberOfUnits}}" name="numberOfUnits" placeholder="Number of units">
              </div>
            </div>  

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Property Type</label>
              <div class="col-sm-10">
                <select class="form-control selection-parent-item" name="propertyTypeID">
                        <option value="0">Select a type</option>
                    @foreach ($propTypes as $prop)
                        @if ($props->propertyTypeID == $prop->propertyTypeID)
                          <option value="{{$prop->propertyTypeID}}" selected="selected">{{ $prop->propertyDescription }}</option>
                        @else
                          <option value="{{$prop->propertyTypeID}}">{{ $prop->propertyDescription }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Property Sub Type</label>
              <div class="col-sm-10">
                <select class="form-control selection-child-item" name="propertySubTypeID" >
                        <option value="0">Select a type</option>
                    @foreach ($propSubTypes as $prop)
                        @if ($props->propertySubTypeID == $prop->propertySubTypeID)
                          <option value="{{$prop->propertySubTypeID}}" selected="selected">{{ $prop->propertySubTypeDescription }}</option>
                        @else
                          <option value="{{$prop->propertySubTypeID}}">{{ $prop->propertySubTypeDescription }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label for="inputEmail3" name="forRentOrOwn" value="{{ $props->forRentOrOwn }}" class="col-sm-2 control-label">Rent / Own</label>
              <div class="col-sm-10">
                <select class="form-control" name="forRentOrOwn">
                    <option value="">Select an ownership type</option>
                    <option value="1" {{ $props->forRentOrOwn == 1 ? "Selected='selected'" : "" }}>Rent</option>
                    <option value="2" {{ $props->forRentOrOwn == 2 ? "Selected='selected'" : "" }}>Own</option>
                </select>
              </div>
            </div>             
                    

            <div class="form-group">
              <label name="tenant"  class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control" name="rentalOwnerID" value="{{ $props->rentalOwnerID }}">
                    <option value="">Select a rental owner</option>
                    @foreach ($rentalowners as $rentalowner)
                        @if ($props->rentalOwnerID == $rentalowner->rentalOwnerID)
                          <option value="{{$rentalowner->rentalOwnerID}}" selected="selected" >{{ $rentalowner->firstName }}</option>
                        @else
                          <option value="{{$rentalowner->rentalOwnerID}}">{{ $rentalowner->firstName }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Property Image</label>
              <div class="col-sm-10 image-edit  {{ ($props->propertyImage) ? 'image-true' : 'image-false' }}">
                <p class="image-exists">Image has already been added</p>
                <span class='remove-image btn btn-danger btn-sm'>Remove</span>
                <div class="file-input">
                  <input type="file" name="propertyImage" accept="image/*">
                </div>
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
    <div role="tabpanel" class="tab-pane" id="attachments">
    <br/>
      <div class="container-fluid">
        
      </div>
    </div>
    </div>
    
  </div>

@endsection
@push('scripts')
<script>
$(function() {
    // filter child selection on page load
    childSelection($('.selection-parent-item'));
    
    // Load content based on previous selection
    $('.selection-parent-item').on('change', function(){
      childSelection(this);
    });

    function childSelection(elem){
      var prev_selection = $('.selection-child-item').val();
      if($(elem).val() != 0){
        $('.selection-child-item').parent().parent('.form-group').show();
        $.ajax({
            url: "/prop/subtypelist/"+$(elem).val()+"",
            context: document.body,
            method: 'POST',
            headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        })
        .done(function(data) {            
          $('.selection-child-item').html(function(){
              // Generate the seletect list
              var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
              data.forEach(function( index, element ){
                  if(prev_selection == data[element].propertySubTypeID){
                    output += '<option value="'+data[element].propertySubTypeID+'" selected="selected">'+data[element].propertySubTypeDescription+'</option>';
                  }else{
                    output += '<option value="'+data[element].propertySubTypeID+'">'+data[element].propertySubTypeDescription+'</option>';
                  }
              });
              output += '</select>';
              return output;
          });
        });
      }else {
        $('.selection-child-item').parent().parent('.form-group').hide();
      }
    }
});
</script>
@endpush
