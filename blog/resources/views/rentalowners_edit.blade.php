@extends('admin_template')

@section('content')
<title>IDSS | Rental Owners</title>

<div class="container-fluid">
  <h3 class="pull-left">{{ $rentalowner->firstName}}  {{ $rentalowner->lastName}}</h3>
  <br />
  <br />
  <br />
  <a role="presentation" href="#edit" class='edit-remove-actives pull-right btn btn-info <?php ($rentalowner->isSubmitted == 1) ? print 'disabled' : false ?>' aria-controls="edit" role="tab" data-toggle="tab"><i class="fa fa-pencil" aria-hidden="true"></i> edit</a>
</div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">Summary</a></li>
    <!-- <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li> -->
    <!-- <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">Attachments</a></li> -->
    <li role="presentation"><a href="#financials" aria-controls="financials" role="tab" data-toggle="tab">Financials</a></li>
    <li role="presentation"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab">Properties</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="view">
     <div class="row">
        <div class="col-md-12">
            <div class="">
                  <div class="box-body">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-1">
                            <p>Address</p>
                            <p>{{ $rentalowner->address}}</p>
                          </div>
                          <div class="col-md-1">
                            <p>Phone</p>
                            <p class="remove-bottom-margin"><i class="fa fa-mobile" aria-hidden="true"></i> {{ $rentalowner->phoneNumber}}</p>
                            <p class="remove-bottom-margin"><i class="fa fa-home" aria-hidden="true"></i> {{ $rentalowner->officeNumber}}</p>
                          </div>                        
                          <div class="col-md-1">
                            <p>Email</p>
                            <p class="remove-bottom-margin"></i> {{ $rentalowner->email}}</p>
                            <p class="remove-bottom-margin"><a href="mailto:{{$rentalowner->email}}?Subject=Property%20Management%20Tool"><i class="fa fa-envelope" aria-hidden="true"></i> Compose Mail</a> </p>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-1">
                            <p class="">Date of Birth</p></b>
                            <p class='format-date'>{{ $rentalowner->dateOfBirth}}</p>
                          </div>
                        </div><br/>  
                      </div>

                      <div class="container-fluid">
                        <div class="row">
                          <div class="button-group">
                            <form method="POST" class="confirm-submit" action="/rentalowner/submit">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="rentalownerID" value="{{$rentalowner->rentalOwnerID}}">
                              <input type="hidden" name="flag" value="{{$rentalowner->isSubmitted}}">
                              @if($rentalowner->isSubmitted == 1)
                                <input class="btn btn-primary" type="submit" value="Reverse">
                              @else
                                <input class="btn btn-primary" type="submit" value="Submit">
                              @endif
                            </form>
                          </div>
                        </div>
                      </div>
                      <br />
                      <!-- <div class="row">
                        <b><p class="col-sm-2 control-label">Country</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $countryName }}</p>
                      </div><br/>                       
                      <div class="row">
                        <b><p class="col-sm-2 control-label">City</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $rentalowner->city}}</p>
                      </div><br/>  
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Comments</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $rentalowner->comments}}</p>
                      </div><br/>   -->
                      <!-- Button trigger modal -->
        
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Attachment</h4>
              </div>
              <div class="modal-body">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Attachment</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="/attachment" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="box-body">
                        <input type="hidden" name="documentAutoID" class="form-control" value="{{ $rentalowner->rentalOwnerID }}"  placeholder="Subject">
                        <input type="hidden" name="documentID" class="form-control" value="2" >
                
                        <div class="form-group">
                          <label class="col-sm-2 control-label">File Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="fileNameCustom" class="form-control input-req"  placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">File Description</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="description" rows="2" value="" placeholder="Description"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label name="tenant" class="col-sm-2 control-label">Document</label>
                          <div class="col-sm-10">
                            <input type="file" name="attachmentFile" required="required" accept="image/*">
                          </div>
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="reset" class="btn btn-default" value="Reset" />
                        <button type="submit" class="btn bg-green pull-right">Save</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>
                </div>
              </div>    
            </div>
          </div>
        </div>
        <div class="box box-info attachments-rows ">
          <div class="box-header with-border">
            <h4 class="">Files &nbsp;</h4>
            <a href="#" class="" data-toggle="modal" data-target="#myModal">
               Add Attachment
            </a>
          </div>
        @if($attachments->isEmpty())
          <div class="box-body"><p>No files added yet</p></div>
        @endif
          @foreach ($attachments as $attachment)
              <div class="attacment-item">
                <a href="/blog/storage/app/uploads/attachments/{{$attachment->fileNameSlug}}">{{$attachment->fileNameCustom}}</a>
                <p>{{$attachment->attachmentDescription}}</p>
                <div class="edit-button">
                  <button class="btn bg-green btn-sm edit-attachment" data-id='{{ $attachment->attachmentID }}' data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

                  <input type="hidden" class='data-defined' data-id='{{ $attachment->attachmentID }}' data-documentAutoID='{{ $rentalowner->rentalOwnerID }}' data-description='{{ $attachment->attachmentDescription }}' data-fileNameCustom='{{ $attachment->fileNameCustom }}' data-fileNameSlug='{{ $attachment->fileNameSlug }}' data-documentID='{{ $attachment->documentID }}'>


                  <form class="delete-form" action="/attachment/{{ $attachment->attachmentID }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <!-- <input type="submit" value="Delete" class="btn btn-danger btn-small"> -->
                    <a href="" class="delete-btn btn btn-danger btn-sm button--winona">
                      <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                      <span class="after">Sure?</span>
                    </a>
                  </form>
                </div>
              </div>
          @endforeach
        </div>
        @component('attachments_edit')

        @endcomponent
        <div class="box box-info attachments-rows ">
          <div class="box-header with-border">
            <h4><b>Notes</b></h4>
          </div>
          <div class="box-body">
            {{ $rentalowner->comments}}
          </div>
        </div>
                    
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
                <form class="form-horizontal" action="/rentalowners/update" method="POST">
                    {{ csrf_field() }}
                  <div class="box-body">
                  <input type="hidden" name="rentalOwnerID" value="{{ $rentalowner->rentalOwnerID}}">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">First name</label>
                      <div class="col-sm-10">
                        <input type="text" name="fname" value="{{ $rentalowner->firstName}}" class="form-control input-req"  placeholder="First name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Last name</label>
                      <div class="col-sm-10">
                        <input type="text" name="lname" value="{{ $rentalowner->lastName}}" class="form-control input-req"  placeholder="Last name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Date of Birth</label>
                      <div class="col-sm-10">
                        <input type="text" name="dob" value="{{date_create_from_format('Y-m-d', $rentalowner->dateOfBirth) ? date_create_from_format('Y-m-d', $rentalowner->dateOfBirth)->format('j/m/Y') : null }}" class="form-control datepicker"  placeholder="Date of Birth">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" name="email" value="{{ $rentalowner->email}}" class="form-control input-req"  placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Phone</label>
                      <div class="col-sm-10">
                        <input type="tel" name="phone" value="{{ $rentalowner->phoneNumber}}" class="form-control input-req"  placeholder="Please enter 10 digits">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Office Phone</label>
                      <div class="col-sm-10">
                        <input type="tel" name="officephone" value="{{ $rentalowner->officeNumber}}" class="form-control"  placeholder="Please enter 10 digits">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10">
                        <select name="country" class='form-control' value="{{ $rentalowner->country}}" >
                          @foreach ($countries as $country)
                              @if($rentalowner->country == $country->id)
                                <option value="{{$country->id}}" selected="selected">{{ $country->countryName }}</option>
                              @else
                                <option value="{{$country->id}}">{{ $country->countryName }}</option>
                              @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="address" rows="2" placeholder="Address"> {{ $rentalowner->address}}</textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">City</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $rentalowner->city}}" name="city" class="form-control"  placeholder="City">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Comments</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="comments"  rows="2" placeholder="Comments">{{ $rentalowner->comments}}</textarea>
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
    <div role="tabpanel" class="tab-pane" id="financials">
    <br/>
      <div class="container-fluid">
        <h2>Financials </h2>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="properties">
      <br/>
      <div class="container-fluid">
        <h2>Properties </h2>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Property Type</th>
              <th>Address</th>
              <th>Number of units</th>
              <th>View</th>
            </tr>
            @foreach($ownedProperties as $property)
              <tr>
                <td>{{$property->pPropertyName}}</td>
                <td>{{$property->description}}</td>
                <td>{{$property->propertySubTypeID}}</td>
                <td>{{$property->address}}</td>
                <td>{{$property->numberOfUnits}}</td>
                <td><a class="btn bg-green btn-sm" href="/prop/edit/{{$property->PropertiesID}}"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>              
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection