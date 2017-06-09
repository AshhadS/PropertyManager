@extends('admin_template')

@section('content')

<section class="content-header">
      <h1>User</h1>
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
                      <div class="row">
                        <b><p class="col-sm-2 control-label">First Name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $user->first_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Last Name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $user->last_name}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Email</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $user->email}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Created On</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $user->created_at}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Last Logged In</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $user->last_login}}</p>
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
                <form class="form-horizontal" action="/users/update" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
                <input type="hidden" name="id" value='{{$user->id}}' class="form-control">
            <div class="form-group">
              <label class="col-sm-2 control-label">First Name</label>
              <div class="col-sm-10">
                <input type="text" name="first_name" value='{{$user->first_name}}' class="form-control input-req" required placeholder="First Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Last Name</label>
              <div class="col-sm-10">
                <input type="text" name="last_name" value='{{$user->last_name}}' class="form-control" placeholder="Last Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" name="password" class="form-control pass" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" name="" class="form-control confirm" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="text" name="email"  value='{{$user->email}}' class="form-control" required placeholder="Email">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">User Role</label>
              <div class="col-sm-10">
                <select name="roles" class="form-control" >
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{ $role->name }}</option>
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
    <div role="tabpanel" class="tab-pane" id="attachments">
      <h2>Attachments</h2>
    </div>
  </div>

@endsection