@extends('admin_template')

@section('content')


  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">View</a></li>
    <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Tab 3</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Tab 4</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="view">
     <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tenant</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                    
                  <div class="box-body">
                      <div class="row">
                        <b><p class="col-sm-2 control-label">First name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->firstName}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Last name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->lastName}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Date of birth</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->dateOfBirth}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Email</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->email}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Phone</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->phoneNumber}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Office Phone</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->officeNumber}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Country</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->country}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Address</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->address}}</p>
                      </div><br/>  
                    
                      <div class="row">
                        <b><p class="col-sm-2 control-label">City</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->city}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Comments</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant->comments}}</p>
                      </div><br/>  
                    
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
                <form class="form-horizontal" action="/tenants/update" method="POST">
                    {{ csrf_field() }}
                  <div class="box-body">
                  <input type="hidden" name="tenantsID" value="{{ $tenant->tenantsID}}">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">First name</label>
                      <div class="col-sm-10">
                        <input type="text" name="fname" value="{{ $tenant->firstName}}" class="form-control input-req"  placeholder="First name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Last name</label>
                      <div class="col-sm-10">
                        <input type="text" name="lname" value="{{ $tenant->lastName}}" class="form-control input-req"  placeholder="Last name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Date of birth</label>
                      <div class="col-sm-10">
                        <input type="text" name="dob" value="{{ $tenant->dateOfBirth}}" class="form-control"  placeholder="tenant Number">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" name="email" value="{{ $tenant->email}}" class="form-control"  placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Phone</label>
                      <div class="col-sm-10">
                        <input type="tel" name="phone" value="{{ $tenant->phoneNumber}}" class="form-control"  placeholder="Phone">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Office Phone</label>
                      <div class="col-sm-10">
                        <input type="tel" name="officephone" value="{{ $tenant->officeNumber}}" class="form-control"  placeholder="Office Phone">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10">
                        <select name="country" class="form-control">
                          @foreach ($countries as $country)
                              <option value="{{$country->id}}">{{ $country->countryName }}</option>
                          @endforeach
                      </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="address" rows="2" placeholder="Address"> {{ $tenant->address}}</textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">City</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $tenant->city}}" name="city" class="form-control"  placeholder="City">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Comments</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="comments"  rows="2" placeholder="Comments">{{ $tenant->comments}}</textarea>
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
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
  </div>

@endsection