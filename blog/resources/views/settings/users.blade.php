<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
        
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal ajax-process" action="/users" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">First Name</label>
              <div class="col-sm-10">
                <input type="text" name="first_name" class="form-control input-req" required placeholder="First Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Last Name</label>
              <div class="col-sm-10">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" name="password" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" name="confirm" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="text" name="email" class="form-control" required placeholder="Email">
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
            <div class="form-buttons">
              <input type="reset" class="btn btn-default" value="Reset" />
              <button type="submit" data-section="users" class="btn btn-info pull-right">Save</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
      </div>
    </div>
  </div>
</div>
<h3 class="title">Users</h3>
<button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> Add User
  </button>
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Last login</th>
        <th>Created On</th>
        <th>Actions </th>
      </tr>
      @foreach ($user as $single_user)
      <tr>
        <td  class='user item-editable' data-type="text" data-name="id" data-pk="{{$single_user->id}}">{{$single_user->id}}</td>
        <td  class='user item-editable' data-type="text" data-name="first_name" data-pk="{{$single_user->id}}">{{$single_user->first_name}}</td>
        <td  class='user item-editable' data-type="text" data-name="last_name" data-pk="{{$single_user->id}}">{{$single_user->last_name}}</td>
        <td  class='user item-editable' data-type="text" data-name="email" data-pk="{{$single_user->id}}">{{$single_user->email}}</td>
        <!-- <td></td> -->
        <td>{{$single_user->last_login}}</td>
        <td>{{$single_user->created_at}}</td>
        <td>
          <!-- <button class="btn btn-info btn-sm edit-settings" data-id="{{$single_user->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button> -->

          <form class="delete-form clearfix ajax-process" method="POST" action="user/{{$single_user->id}}">
            <a href="#" class="delete-btn-ajax btn btn-danger btn-sm button--winona" >
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button data-section="users" class="hide-element"></button>
          </form>
        </td>
      </tr>
      @endforeach
      <p class="text-muted">Click the table cell to edit an item</p>
      
    </tbody>
  </table>
</div>

