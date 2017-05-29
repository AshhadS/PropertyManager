@extends('admin_template')

@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add tenants</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/tenants" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">First name</label>
              <div class="col-sm-10">
                <input type="text" name="fname" class="form-control input-req"  placeholder="First name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Last name</label>
              <div class="col-sm-10">
                <input type="text" name="lname" class="form-control input-req"  placeholder="Last name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Date of birth</label>
              <div class="col-sm-10">
                <input type="text" name="dob" class="form-control"  placeholder="tenant Number">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control"  placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Phone</label>
              <div class="col-sm-10">
                <input type="tel" name="phone" class="form-control"  placeholder="Phone">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Office Phone</label>
              <div class="col-sm-10">
                <input type="tel" name="officephone" class="form-control"  placeholder="Office Phone">
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
                <textarea class="form-control" name="address" rows="2" placeholder="Address"></textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">City</label>
              <div class="col-sm-10">
                <input type="text" name="city" class="form-control"  placeholder="City">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Comments</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="comments" rows="2" placeholder="Comments"></textarea>
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

    
<div class="panel panel-default">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#myModal">
      <i class="fa fa-plus"> Add Tenants</i>
    </button>
    <div class="panel-heading">
        Tenants
    </div>
    <div class="panel-body">
        @if (count($tenants) > 0)
            <table class="table table-striped task-table" id="tenants-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                          <th>First ame</th>
                          <th>Last Name</th> 
                          <th>dateOfBirth</th>
                          <th>Email</th>
                          <th>Phone Number</th>
                          <th>Office Number</th>
                          <th>Country</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Comments</th>
                          <th>View</th>
                        </tr>
                </thead>

                       
            </table>
        @endif
    </div>
</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#tenants-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          'url' : 'tenants/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        columns: [
            { data: 'firstName', name: 'firstName'},  
            { data: 'lastName', name: 'lastName'},  
            { data: 'dateOfBirth', name: 'dateOfBirth'},  
            { data: 'email', name: 'email'},  
            { data: 'phoneNumber', name: 'phoneNumber'},  
            { data: 'officeNumber', name: 'officeNumber'},  
            { data: 'countryName', name: 'countries.countryName'},  
            { data: 'address', name: 'address'},  
            { data: 'city', name: 'city'},  
            { data: 'comments', name: 'comments'},  
            {
                data: 'tenantsID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  return '<a href="tenant/edit/'+data+'">View</a>';
                }
            }      
        ]
    });
});
</script>
@endpush
