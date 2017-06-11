@extends('admin_template')

@section('content')
  <section class="content-header">
      <h1>Units</h1>
  </section>
  <br /><br />
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">View</a></li>
    <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">Attachments</a></li>
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
                          <b><p class="col-sm-2 control-label">Unit Number</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $unit->unitNumber}}</p>
                        </div>
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Description</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $unit->description}}</p>
                        </div>
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Size</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $unit->size}}</p>
                        </div>
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Market Rent</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $unit->marketRent}}</p>
                        </div>
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Currency</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $currencyName}}</p>
                        </div>
                        <div class="row">
                          <b><p class="col-sm-2 control-label">Property</p></b>
                          <p class='col-sm-10 conrol-label'>{{ $property_name}}</p>
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
                      <form class="form-horizontal" action="/units/update" method="POST">
                          {{ csrf_field() }}
                        <div class="box-body">
                        <input type="hidden" name="unitID" value="{{ $unit->unitID}}">
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Unit Number</label>
                            <div class="col-sm-10">
                              <input type="text" name="unitNumber" value="{{ $unit->unitNumber}}" class="form-control input-req" id="inputEmail3" placeholder="Unit Number">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                              <textarea class="form-control input-req" name="description" rows="2" placeholder="Description">{{ $unit->description}}</textarea>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Size</label>
                            <div class="col-sm-10">
                              <input type="text" name="size" value="{{ $unit->size}}" class="form-control input-req" id="inputEmail3" placeholder="Size">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Market Rent</label>
                            <div class="col-sm-10">
                              <input type="text" name="marketRent" value="{{ $unit->marketRent}}" class="form-control input-req" id="inputEmail3" placeholder="Market Rent">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" name="propertyType" value="{{ $unit->PropertiesID}}" class="col-sm-2 control-label">Property Name</label>
                            <div class="col-sm-10">
                              <select class="form-control input-req" name="PropertiesID" >
                                  <option value="">Select a property</option>
                                  @foreach ($properties as $prop)
                                      @if ($unit->PropertiesID === $prop->PropertiesID)
                                        <option value="{{$prop->PropertiesID}}" selected="selected">{{ $prop->pPropertyName }}</option>
                                      @else
                                        <option value="{{$prop->PropertiesID}}">{{ $prop->pPropertyName }}</option>
                                      @endif
                                  @endforeach
                              </select>
                            </div>
                          </div> 

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Curreny</label>
                            <div class="col-sm-10">
                              <select name="currencyID" class="form-control input-req" >
                                  <option value="">Select a currency</option>
                                  @foreach ($currencies as $currency)
                                      @if ($unit->currencyID == $currency->currencyID)
                                        <option value="{{$currency->currencyID}}" selected="selected" >{{ $currency->currencyCode }}</option>
                                      @else
                                        <option value="{{$currency->currencyID}}">{{ $currency->currencyCode }}</option>
                                      @endif
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
      <div role="tabpanel" class="tab-pane" id="attachments">
    <br/>
      <div class="container-fluid">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> <b>Add Attachment</b>
        </button>
        <br/><br/><br/>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Attachment</h4>
              </div>
              <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Attachment</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="/attachment" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="box-body">
                        <input type="hidden" name="documentAutoID" class="form-control" value="{{ $unit->unitID}}"  placeholder="Subject">
                        <input type="hidden" name="documentID" class="form-control" value="3" >
                
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
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>
                </div>
              </div>    
            </div>
          </div>
        </div>
        <div class="box box-info attachments-rows">
          @foreach ($attachments as $attachment)
              <div class="attacment-item">
                <a href="/blog/storage/app/uploads/attachments/{{$attachment->fileNameSlug}}">{{$attachment->fileNameCustom}}</a>
                <p>{{$attachment->attachmentDescription}}</p>
                <div class="edit-button">
                  <button class="btn btn-info btn-sm edit-attachment" data-id='{{ $attachment->attachmentID }}' data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

                  <input type="hidden" class='data-defined' data-id='{{ $attachment->attachmentID }}' data-documentAutoID='{{ $unit->unitID }}' data-description='{{ $attachment->attachmentDescription }}' data-fileNameCustom='{{ $attachment->fileNameCustom }}' data-fileNameSlug='{{ $attachment->fileNameSlug }}' data-documentID='{{ $attachment->documentID }}'>

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
      </div>
    </div>
  </div>    
@endsection