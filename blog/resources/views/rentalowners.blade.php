@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Property Ownners</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add Property Owner</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/rentalowners" method="POST">
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
                <input type="text" name="dob" class="form-control datepicker"  placeholder="Date of Birth">
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
                <input type="tel"  pattern="[0-9]{10}" name="phone" class="form-control"  placeholder="Please enter 10 digits">
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
      <h1> Proeperty Owners</h1>
  </section>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Property Owner</b>
  </button>
</div>


<div class="panel panel-default give-space">
    <div class="panel-body">
        @if (count($rentalowners) > 0)
            <table class="table table-bordered table-hover table-striped" id="rentalowners-table">

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
                          <th>Actions</th>
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
    $('#rentalowners-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          'url' : 'rentalowners/all',
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
                data: 'rentalownerID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                    // Create action buttons
                  var action = '<div class="inner"><a class="btn btn-info btn-sm" href="rentalowner/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="rentalowner/'+data+'">';
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
