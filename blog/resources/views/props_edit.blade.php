@extends('admin_template')

@section('content')
  <section class="content-header">
      <h1>Property</h1>
  </section>
  <br /><br />
    
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">View</a></li>
    <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#attachments" aria-controls="messages" role="tab" data-toggle="tab">Attachments</a></li>
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
                    <div class="image-column col-md-4">
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Name</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $props->pPropertyName}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Description</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $props->description}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Property Sub Type</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $property_type_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Property Type</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $property_type_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Number of units</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $props->numberOfUnits}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Property Owner name</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $rental_owner_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Address</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $props->address}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Country</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $countryName}}</p>
                      </div><br/> 
                      <div class="row">
                        <b><p class="col-sm-4 control-label">City</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $props->city}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Rent / Own</p></b>
                        <p class='col-sm-4 conrol-label'>{{ $rent_or_own }}</p>
                      </div>
                    </div>
                      <div class="image-column col-md-6">
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Property Image</p></b>
                          <img class='show-image' src="/blog/storage/app/uploads/{{$props->propertyImage}}" alt="Property Image">
                        </div>
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
                <select class="form-control selection-parent-item" name="propertySubTypeID" value="{{ $props->propertySubTypeID }}">
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
                <select class="form-control selection-child-item" name="propertySubTypeID" value="{{ $props->propertySubTypeID }}">
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
                    <option value="1" {{ $props->forRentOrOwn == 1 ? "Selected='selected'" : "" }}>Rent</option>
                    <option value="2" {{ $props->forRentOrOwn == 2 ? "Selected='selected'" : "" }}>Own</option>
                </select>
              </div>
            </div>             
                    

            <div class="form-group">
              <label name="tenant"  class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control" name="rentalOwnerID" value="{{ $props->rentalOwnerID }}">
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
            <input type="reset" class="btn btn-default" value="Reset" />
            <button type="submit" class="btn btn-info pull-right">Save</button>
          </div>
          <!-- /.box-footer -->
        </form>
            </div>
        </div>
      </div>
    <div role="tabpanel" class="tab-pane" id="attachments">
    <br/>
      <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> <b>Add Attachment</b>
        </button>
        <br/><br/><br/>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Attachment</h4>
              </div>
              <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Attachment</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="/attachment" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="box-body">
                        <input type="hidden" name="documentAutoID" class="form-control" value="{{ $props->PropertiesID}}"  placeholder="Subject">
                        <input type="hidden" name="documentID" class="form-control" value="1" >
                
                        <div class="form-group">
                          <label class="col-sm-2 control-label">File Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="fileNameCustom" class="form-control input-req"  placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">File Description</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="description" rows="2" value="" placeholder="Description"></textarea>
                          </div>
                        </div> 
                        <div class="form-group">
                          <label name="tenant" class="col-sm-2 control-label">Document</label>
                          <div class="col-sm-10">
                            <input type="file" name="attachmentFile" required="required" accept="image/*">
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
        <div class="box box-info attachments-rows">
          @foreach ($attachments as $attachment)
              <div class="attacment-item">
                <a href="/blog/storage/app/uploads/attachments/{{$attachment->fileNameSlug}}">{{$attachment->fileNameCustom}}</a>
                <p>{{$attachment->attachmentDescription}}</p>
                <div class="edit-button">
                  <button class="btn btn-info btn-sm edit-attachment" data-id='{{ $attachment->attachmentID }}' data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

                  <input type="hidden" class='data-defined' data-id='{{ $attachment->attachmentID }}' data-documentAutoID='{{ $props->PropertiesID }}' data-description='{{ $attachment->attachmentDescription }}' data-fileNameCustom='{{ $attachment->fileNameCustom }}' data-fileNameSlug='{{ $attachment->fileNameSlug }}' data-documentID='{{ $attachment->documentID }}'>

                  <form class="delete-form" action="/attachment/{{ $attachment->attachmentID }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <!-- <input type="submit" value="Delete" class="btn btn-danger btn-small"> -->
                    <a href="" class="delete-btn btn btn-danger btn-sm button--winona">
                      <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                      <span class="after">Sure?</span>
                    </a>
                  </form>
                </div>

              </div>
          @endforeach
        </div>
        @component('attachments_edit')

        @endcomponent
      </div>
    </div>
    </div>
    
  </div>

@endsection
@push('scripts')
<script>
$(function() {
    // Load content based on previous selection
    $('.selection-parent-item').on('change', function(){
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
