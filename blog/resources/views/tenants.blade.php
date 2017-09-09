@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="">
        <div class="box box-info">
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
              <label class="col-sm-2 control-label">Date of Birth</label>
              <div class="col-sm-10">
                <input type="text" name="dob" class="form-control datepicker"  placeholder="Date of birth">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" name="email" class="form-control input-req"  placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Phone</label>
              <div class="col-sm-10">
                <input type="tel" name="phone" class="form-control input-req"  placeholder="Please enter 10 digits">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Office Phone</label>
              <div class="col-sm-10">
                <input type="tel" name="officephone" class="form-control"  placeholder="Please enter 10 digits">
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
            <div class="form-buttons">
              <input type="reset" class="btn btn-default" value="Reset" />
              <button type="submit" class="btn bg-green pull-right">Save</button>
            </div>
          </div>
          <!-- /.box-footer -->
        </form>
    </div>
      </div>
    </div>
  </div>
</div>


    

<div class="panel panel-default give-space">
    <div class="panel-body">
      <div class="page-header container-fluid">
        <section class="content-header pull-left">
            <h4><b>TENANTS</b></h4>
        </section>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> Add Tenants
        </button>
      </div>
        <table class="table table-bordered table-hover table-striped" id="tenants-table">

            <!-- Table Headings -->
            <thead>
                <tr>
                      <th>First Name</th>
                      <th>Last Name</th> 
                      <th>Date of Birth</th>
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Office Number</th>
                      <th>Country</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>Comments</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
            </thead>

                   
        </table>
    </div>
</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#tenants-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          'url' : 'tenants/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columnDefs": [
          { "width": "10%", "targets": 10 }
        ],
        columns: [
            { data: 'firstName', name: 'firstName'},  
            { data: 'lastName', name: 'lastName'},  
            { 
              data: 'dateOfBirth',
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
            { data: 'email', name: 'email'},  
            { data: 'phoneNumber', name: 'phoneNumber'},  
            { data: 'officeNumber', name: 'officeNumber'},  
            { data: 'countryName', name: 'countries.countryName'},  
            { data: 'address', name: 'address'},  
            { data: 'city', name: 'city'},  
            { data: 'comments', name: 'comments'},  
            { 
              data: 'isSubmitted',
              name: 'isSubmitted',
              className: 'center-parent',
              render: function(data){
                return (data == 1) ? '<span class="simple-box green"></span>' : '<span class="simple-box red"></span>';
              }
            },  
            {
                data: 'tenantsID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<div class="inner wide"><a class="btn bg-green btn-sm" href="tenant/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                  action += '<form class="delete-form confirm-submit" method="POST" action="/tenant/submit">';
                  action += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
                  action +=   '<input type="hidden" name="tenantsID" value="'+data+'">';
                  action +=   '<input type="hidden" name="flag" value="'+full.isSubmitted+'">';
                  if(full.isSubmitted == 1){
                    // action += '<input class="btn bg-green btn-sm btn-second" type="submit" value="<i class="fa fa-undo" aria-hidden="true"></i>">';
                    action += '<button class="btn bg-green btn-sm btn-second" title="Reverse" type="submit"><i class="fa fa-undo" aria-hidden="true"></i></button>';
                  }else{
                    action += '<button class="btn bg-green btn-sm btn-second" title="Submit" type="submit" > <i class="fa fa-check-square-o" aria-hidden="true"></i></button>';
                  }
                  action += '</form>';
                  action += '<form class="delete-form" method="POST" action="tenant/'+data+'">';
                  action += '<a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>';
                  action += '<i class="fa fa-trash" aria-hidden="true"></i> </span><span class="after">?</span></a>';
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
