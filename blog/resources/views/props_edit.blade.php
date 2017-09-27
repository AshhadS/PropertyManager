@extends('admin_template')

@section('content')
<title>IBSS | Properties</title>
  <section class="content-header">
      <h4><b>PROPERTY</b></h4>
  </section>
  <br /><br />
    
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">Summary</a></li>
    <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#propertyImages" aria-controls="edit" role="tab" data-toggle="tab">Images</a></li>
    <li role="presentation"><a href="#units" aria-controls="units" role="tab" data-toggle="tab">Units</a></li>
    <li role="presentation"><a href="#jobcards" aria-controls="jobcards" role="tab" data-toggle="tab">Jobs</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="view">
     <div class="row">
        <div class="col-md-12">
            <div class=""> 
                <!-- /.box-header -->
                <!-- form start -->
                    
                  <div class="box-body">
                    <div class="image-column col-md-4">
                      <h2 class='conrol-label'>{{ $props->pPropertyName}}</h2>
                      <div id="myCarousel" class="carousel slide" data-ride="carousel">
                          
                          <!-- Wrapper for slides -->
                          <div class="carousel-inner">
                            <div class="carousel-inner">
                              @foreach ($propertyImages as $index => $image)
                                <div class="item <?php ($index == 0)? print 'active' : ''?>">
                                  <img src="/blog/storage/app/uploads/images/{{$image->fileNameSlug}}" alt="{{$image->fileName}}">
                                </div>
                              @endforeach
                            </div>
                          </div>

                          <!-- Left and right controls -->
                          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                          </a>
                        </div>
                      <br />
                      <br />
                      <p class='description'>{{ $props->description}}</p>
                    </div>
                    <div class="details col-md-4">
                      <br /><br />
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
                    <div class="col-md-3 att-column">
                      <br/> <br/>  
                      @component('attachments', ['entity_id' => $props->PropertiesID, 'document_id' => $props->documentID, 'attachments' => $attachments])

                      @endcomponent
                    </div>
                  </div>
            </div>
        </div>
      </div>

      @component('notes', ['documentID' => $props->documentID, 'documentAutoID' => $props->PropertiesID, 'notes' => $notes])

      @endcomponent
    </div>
    <div role="tabpanel" class="tab-pane" id="edit">
     <div class="row">
        <div class="col-md-12">
            <div class=""> 
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
                <input type="number" class="form-control input-req" id="inputEmail3" value="{{ $props->numberOfUnits}}" name="numberOfUnits" placeholder="Number of units">
              </div>
            </div>  

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Property Type</label>
              <div class="col-sm-10">
                <select class="form-control selection-parent-item input-req" name="propertyTypeID">
                        <option value="">Select a type</option>
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
                <select class="form-control selection-child-item input-req" name="propertySubTypeID" >
                        <option value="">Select a type</option>
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
                <select class="form-control input-req" name="forRentOrOwn">
                    <option value="">Select an ownership type</option>
                    <option value="1" {{ $props->forRentOrOwn == 1 ? "Selected='selected'" : "" }}>Rent</option>
                    <option value="2" {{ $props->forRentOrOwn == 2 ? "Selected='selected'" : "" }}>Own</option>
                </select>
              </div>
            </div>             
            <div class="form-group">
              <label name="tenant"  class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control input-req" name="rentalOwnerID" value="{{ $props->rentalOwnerID }}">
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
              <button type="submit" class="btn bg-green pull-right">Update</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
            </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="propertyImages">
        <div class="container-fluid">
          <h4><b>PROPERTY IMAGES</b></h4>
            <hr/>
            <form action="/image/create" class="attachments-drop-box" id="images-dropzone">
              {{ csrf_field() }}
              <input type="hidden" name="documentAutoID" value="{{$props->PropertiesID}}">
              <input type="hidden" name="documentID" value="1">
              <div class="dz-message"><h4>Drop files here to upload</h4></div>
                <!-- <input type="file" name="file-upload"> -->
                <br/>
              <div class="">
                @if($propertyImages->first())
                  @foreach ($propertyImages as $image)
                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                      <div class="dz-image">
                        <span class="file-type"></span>
                        @if(substr(File::mimeType(storage_path('app/uploads/images/' . $image->fileNameSlug)), 0, 5) == 'image')
                          <img class="dz-server-file" data-dz-remove src="/blog/storage/app/uploads/images/{{$image->fileNameSlug}}">
                        @endif
                      </div>
                      <div class="dz-details">
                          <div class="dz-size"><span data-dz-size="{{File::size(storage_path('app/uploads/images/' . $image->fileNameSlug))}}"></span></div>
                          <div class="dz-filename"><span data-dz-name="">{{$image->fileName}}</span></div>
                      </div>
                      <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div>
                      <a href="#" attachemnt-id="{{$image->fileID}}" class="jc-attachment">Remove</a>
                    </div>
                  @endforeach
                @endif
              </div>
            </form>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="units">
        <div class="container-fluid">
          <h4><b>UNITS</b></h4>
            <hr/>
            <div class="unit-item">
              @foreach ($property_units as $unit)
                  <h3>{{$unit->unitNumber}}</h3>
                  <p>{{$unit->description}}</p>
                  <p><b>Size:</b> {{$unit->size}}  <b>| Market Rent:</b> {{$unit->size}}</p>
                  <hr/>
              @endforeach
            </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="jobcards">
        <div class="container-fluid">
          <h4><b>JOBCARDS</b></h4>
          <hr/>
            <div class="jobcard-item">
              @foreach ($property_jobcards as $jobcard)
                  <h3>{{$jobcard->subject}}</h3>
                  <p>{{$jobcard->description}}</p>
                  @isset($jobcard->jobcardStatusID)
                    <h4><span class="label label-warning">{{App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription }}</span></h4>
                  @endisset

                  <p>
                    @isset($jobcard->rentalOwnerID)
                      <b>Property Owner:</b> {{ App\Model\RentalOwner::find($jobcard->rentalOwnerID)->firstName}}  
                      <b>|</b>
                    @endisset

                    @isset($jobcard->unitId)
                      <b>Unit:</b> {{App\Model\Unit::find($jobcard->unitId)->unitNumber}} 
                      <b>|</b>
                    @endisset

                    @isset($jobcard->tenantsID)
                      <b>Tenant:</b> {{App\Model\Tenant::find($jobcard->tenantsID)->firstName}}
                    @endisset
                  </p>
                  <hr/>
              @endforeach
            </div>
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

    // The setting up of the dropzone
    // Dropzone.options.imagesDropzone = {
    //   uploadMultiple: true,
    //   parallelUploads: 100,
    //   maxFilesize: 2,
    //   addRemoveLinks: false,
    //   dictRemoveFile: "Remove",
    //   acceptedFiles: 'image/*',
    // }
    $('.jc-attachment').on('click', function(e){
      e.preventDefault();
      // Hide preview to show its deleted
      $(this).closest('.dz-preview').hide();
      // Send request to delete from db
      $.ajax({
        type: 'POST',
        url: '/image/delete/'+ $(this).attr('attachemnt-id'),
        data: { 
          _token: '{{ csrf_token() }}',
          _method: 'delete',
        },
        
      })
    });

    var myDropzone = new Dropzone("#images-dropzone", {
     addRemoveLinks: true,
     dictRemoveFile: 'Tets',
     acceptedFiles: 'image/*',
   });
});
</script>
@endpush
