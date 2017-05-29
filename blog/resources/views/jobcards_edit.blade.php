@extends('admin_template')

@section('content')


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
                  <h3 class="box-title">jobcard</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                    
                  <div class="box-body">
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Subject</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->subject}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Description</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->description}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Status</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->jobcardStatusID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Property name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->PropertiesID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Property Owner name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->rentalOwnerID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Tenant name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->tenantsID}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Unit</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->unitID}}</p>
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
                <form class="form-horizontal" action="/jobcards/update" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
                <input type="hidden" name="jobcardID" class="form-control" value="{{ $jobcard->jobcardID}}"  placeholder="Subject">
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" name="subject" class="form-control input-req" value="{{ $jobcard->subject}}"  placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" value="" placeholder="Description">{{ $jobcard->description}}</textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Property Name</label>
              <div class="col-sm-10">
                <select class="form-control" name="PropertiesID" value="{{ $jobcard->PropertiesID}}" >
                    @foreach ($properties as $property)
                        <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Tenant Name</label>
              <div class="col-sm-10">
                <select class="form-control" name="tenantsID" value="{{ $jobcard->tenantsID}}">
                    @foreach ($tenants as $tenant)
                        <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-10">
                <select class="form-control" name="unitID" value="{{ $jobcard->unitID}}">
                    @foreach ($units as $unit)
                        <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="propertyType" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control" name="jobcardStatusID" value="{{ $jobcard->jobcardStatusID}}">
                  <option value="1">In Progress</option>
                  <option value="2">Completed</option>
                  <option value="3">deffered</option>
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
    <div role="tabpanel" class="tab-pane" id="attachments">
      <h2>Attachments</h2>
    </div>
  </div>

@endsection