@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Users</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add User</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/users" method="POST">
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
              <button type="submit" class="btn btn-info pull-right">Save</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
<div class="page-header container-fluid">
  <section class="content-header pull-left">
      <h1>Users</h1>
  </section>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add User</b>
  </button>
</div>

<div class="panel panel-default give-space">
    <div class="panel-body">
    {{--$user--}}
    {{--$roles1--}}
            <table class="table table-bordered table-hover table-striped" id="users-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>First Name</th>
                          <th>Last Name</th> 
                          <th>Email</th>
                          <th>Created</th>
                          <th>Last Login</th>
                          <th>Action</th>
                        </tr>
                </thead>

                       
            </table>
    </div>
</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          'url' : 'user/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "initComplete": function(settings, json) {
         $('.delete-btn').on('click', function(e){
          e.preventDefault();
          btn = this;
          if($(btn).hasClass('activate')){
            console.log('Now delete!'); 
            $(btn).closest('form.delete-form').submit();
          } else{
            $(btn).addClass('activate');
            setTimeout(function(){
              $(btn).removeClass('activate');
            }, 5000);

          }

         })
        },
        "columnDefs": [
          { "width": "10%", "targets": 5 }
        ],
        columns: [
            { data: 'first_name', name: 'first_name'},  
            { data: 'last_name', name: 'last_name'},  
            { data: 'email', name: 'email'},  
            { 
              data: 'created_at',
              render: function( data, type, full, meta ){
                var date = new Date(data);
                if(!isNaN(date.getTime())){
                  // return the two digit date and month
                  return ("0" + date.getDate()).slice(-2) +'/'+ ("0" + (date.getMonth() + 1)).slice(-2) +'/'+ date.getFullYear();
                }else{
                  // retun empty string if not selected
                  return data;
                }
              }
            },  
            { 
              data: 'last_login',
              render: function( data, type, full, meta ){
                var date = new Date(data);
                if(!isNaN(date.getTime())){
                  // return the two digit date and month
                  return ("0" + date.getDate()).slice(-2) +'/'+ ("0" + (date.getMonth() + 1)).slice(-2) +'/'+ date.getFullYear();
                }else{
                  // retun empty string if not selected
                  return data;
                }
              }
            },  
            {
                data: 'id',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<div class="inner"><a class="btn btn-info btn-sm" href="user/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="user/'+data+'">';
                  action += '<a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>';
                  action += '<i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span></a>';
                  action += '<input type="hidden" name="_method" value="DELETE"> ';
                  action += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
                  action += '</form></div>';
                  return action;
                }
            }      
        ]
    });
});
</script>
@endpush
