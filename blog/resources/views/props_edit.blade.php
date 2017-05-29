@extends('admin_template')

@section('content')

  <div class="container">
    
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
                <div class="box-header with-border">
                  <h3 class="box-title">property</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                    
                  <div class="box-body">
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->pPropertyName}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Description</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->description}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Property Type</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->propertySubTypeID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Number of units</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->numberOfUnits}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Property Owner name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->rentalOwnerID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Address</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->address}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">City</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->city}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Rent / Own</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $props->forRentOrOwn }}</p>
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
                <div class="box-header with-border">
                  <h3 class="box-title">Edit</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="/props/update" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
                <input type="text" name="PropertiesID" class="form-control" value="{{ $props->PropertiesID}}"  placeholder="Subject">
            
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
                <select class="form-control" name="propertySubTypeID" value="{{ $props->propertySubTypeID }}">
                    @foreach ($propSubTypes as $prop)
                        @if ($props->propertySubTypeID === $prop->propertySubTypeID)
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
                    <option value="1" {{ $props->forRentOrOwn === 1 ? "Selected='selected'" : "" }}>Rent</option>
                    <option value="2" {{ $props->forRentOrOwn === 2 ? "Selected='selected'" : "" }}>Own</option>
                </select>
              </div>
            </div>             
                    

            <div class="form-group">
              <label name="tenant"  class="col-sm-2 control-label">Rental Owner</label>
              <div class="col-sm-10">
                <select class="form-control" name="rentalOwnerID" value="{{ $props->rentalOwnerID }}">
                    @foreach ($rentalowners as $rentalowner)
                        <option value="{{$rentalowner->rentalOwnerID}}">{{ $rentalowner->firstName }}</option>
                    @endforeach
                </select>
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
        <h2>Attachments</h2>
      </div>
    </div>
    
  </div>
  </div>

@endsection