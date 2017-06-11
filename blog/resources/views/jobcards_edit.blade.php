@extends('admin_template')

@section('content')
  <section class="content-header">
      <h1>Jobcard</h1>
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
                        <b><p class="col-sm-2 control-label">Subject</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->subject}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Description</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcard->description}}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Status</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $jobcardstatussName }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Property name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $property_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Tenant name</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $tenant_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Unit</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $unit_number }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Created by</p></b>
                        <p class='col-sm-10 conrol-label'>{{ $created_by }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-2 control-label">Created on</p></b>
                        <p class='col-sm-10 conrol-label format-date'>{{ $created_at }}</p>
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
                <div class="box-header with-border">
                  <h3 class="box-title">Edit</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="/jobcards/update" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
                <input type="hidden" name="jobcardID" class="form-control" value="{{ $jobcard->jobcardID}}"  placeholder="Subject">
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" name="subject" class="form-control input-req" value="{{ $jobcard->subject}}"  placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" value="" placeholder="Description">{{ $jobcard->description}}</textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Property Name</label>
              <div class="col-sm-10">
                <select class="form-control selection-parent-item" name="PropertiesID" value="{{ $jobcard->PropertiesID}}" >
                        <option value="">Select a property</option>
                    @foreach ($properties as $property)
                        @if ($jobcard->PropertiesID == $property->PropertiesID)
                          <option value="{{$property->PropertiesID}}" selected="selected">{{ $property->pPropertyName }}</option>
                        @else
                          <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Tenant Name</label>
              <div class="col-sm-10">
                <select class="form-control" name="tenantsID" value="{{ $jobcard->tenantsID}}">
                        <option value="">Select a tenant</option> 
                    @foreach ($tenants as $tenant)
                        @if ($jobcard->tenantsID == $tenant->tenantsID)
                          <option value="{{$tenant->tenantsID}}" selected="selected">{{ $tenant->firstName }}</option>
                        @else
                          <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-10">
                <select class="form-control selection-child-item" name="unitID" value="{{ $jobcard->unitID}}">
                        <option value="">Select a unit</option>
                    @foreach ($units as $unit)
                        @if ($unit->unitID == $jobcard->unitID)
                          <option value="{{$unit->unitID}}" selected="selected">{{ $unit->unitNumber }}</option>
                        @else
                          <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                        @endif
                    @endforeach
                </select>
                <p class="no-units">No units belonging to this property</p>
              </div>
            </div>

            <div class="form-group">
              <label name="propertyType" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control" name="jobcardStatusID" value="{{ $jobcard->jobcardStatusID}}">
                  <!-- <option value="1" {{ $jobcard->jobcardStatusID == 1 ? "Selected='selected'" : "" }} >In Progress</option>
                  <option value="2" {{ $jobcard->jobcardStatusID == 2 ? "Selected='selected'" : "" }} >Completed</option>
                  <option value="3" {{ $jobcard->jobcardStatusID == 3 ? "Selected='selected'" : "" }} >deffered</option> -->
                  @foreach ($jobcardstatuss as $jobcardstatus)
                        @if ($jobcardstatus->jobcardStatusID == $jobcard->jobcardStatusID)
                          <option value="{{$jobcardstatus->jobcardStatusID}}" selected="selected">{{ $jobcardstatus->statusDescription }}</option>
                        @else
                          <option value="{{$jobcardstatus->jobcardStatusID}}">{{ $jobcardstatus->statusDescription }}</option>
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
                        <input type="hidden" name="documentAutoID" class="form-control" value="{{ $jobcard->jobcardID}}"  placeholder="Subject">
                        <input type="hidden" name="documentID" class="form-control" value="5" >
                
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

                  <input type="hidden" class='data-defined' data-id='{{ $attachment->attachmentID }}' data-documentAutoID='{{ $jobcard->jobcardID }}' data-description='{{ $attachment->attachmentDescription }}' data-fileNameCustom='{{ $attachment->fileNameCustom }}' data-fileNameSlug='{{ $attachment->fileNameSlug }}' data-documentID='{{ $attachment->documentID }}'>

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

@push('scripts')
<script>
$(function() {
       // filter child selection on page load
      childSelection($('.selection-parent-item'));

      // $('.no-units').hide();
      // Load content based on previous selection
      $('.selection-parent-item').on('change', function(){
        childSelection(this)
      });

      function childSelection(elem){
        var prev_selection = $('.selection-child-item').val();
        if ($(elem).val() != 0) {
          $('.selection-child-item').show();
          $('.no-units').hide();
          $.ajax({
              url: "/jobcard/getunit/"+$(elem).val()+"",
              context: document.body,
              method: 'POST',
              headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
          })
          .done(function(data) {
              // show message if no units for the selected property
              if(data.length){
                $('.selection-child-item').html(function(){
                    // Generate the seletect list
                    var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
                    output += '<option value="">Select a unit</option>';
                    data.forEach(function( index, element ){
                        if(prev_selection == data[element].unitID){
                          output += '<option value="'+data[element].unitID+'" selected="selected">'+data[element].unitNumber+'</option>';
                        }else{
                          output += '<option value="'+data[element].unitID+'">'+data[element].unitNumber+'</option>';
                        }
                    });
                    output += '</select>';
                    return output;
                });
              }else{
                $('.selection-child-item').hide();
                $('.no-units').show();
              }         
          });
        }else{
          $('.selection-child-item').hide();
          $('.no-units').show();
        }           
      }
});
</script>
@endpush