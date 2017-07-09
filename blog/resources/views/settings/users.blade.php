
<h3 class="title">Users</h3>
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
        <td>{{$single_user->id}}</td>
        <td>{{$single_user->first_name}}</td>
        <td>{{$single_user->last_name}}</td>
        <td>{{$single_user->email}}</td>
        <td>{{$single_user->last_login}}</td>
        <td>{{$single_user->created_at}}</td>
        <td>
          <button class="btn btn-info btn-sm edit-settings" data-id="{{$single_user->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

          <form class="delete-form clearfix" method="POST" action="user/{{$single_user->id}}">
            <a href="#" class="delete-btn-ajax btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
      <p class="text-muted">Click the table cell to edit an item</p>
      
    </tbody>
  </table>
</div>
<div class="col-md-12">
  <h4>Add User</h4>
  <form class="form-horizontal ajax-process  pull add-user" data-section="users" action="/users" method="POST">
      {{ csrf_field() }}
        <input type="text" name="first_name" placeholder="First Name" class="input-req">
        <input type="text" name="last_name" placeholder="Last Name" >
        <select name="roles" class="" >
            @foreach ($roles as $role)
                <option value="{{$role->id}}">{{ $role->name }}</option>
            @endforeach
        </select>
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        
      <button type="submit" class="btn btn-info " data-section="users"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>
