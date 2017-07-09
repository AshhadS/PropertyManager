
<h3 class="title">Roles</h3>
<div class="col-md-6">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
      @foreach ($roles as $role)
      <tr>
        <td>{{$role->id}}</td>
        <td class='roles item-editable' data-type="text" data-name="name" data-pk="{{$role->id}}}" >{{$role->name}}</td>
        <td>

          <form class="delete-form clearfix" data-section="roles" method="POST" action="role/{{$role->id}}">
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
<div class="col-md-6">
  <h4>Add role</h4>
  <form class="form-horizontal ajax-process  pull" action="/role" method="POST">
      {{ csrf_field() }}
      <div class="simple-add-textbox-wrapper pull-left">
        <input type="text" name="roleCode" class="pull-left simple-add-textbox input-req">
        
      </div>
      <button type="submit" class="btn btn-info simple-add-btn pull-left " data-section="roles"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>
