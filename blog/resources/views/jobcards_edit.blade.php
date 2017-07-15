@extends('admin_template')
@section('content')
<!-- Nav tabs -->
<!-- <ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#view" aria-controls="view" role="tab" data-toggle="tab">View</a></li>
  <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
</ul> -->
<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="view">
    <div class="row">
      <div class="container-fluid">
        <div class="">
          <!-- /.box-header -->
          <!-- form start -->          
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <h2> <i class="fa fa-briefcase" aria-hidden="true"></i> Jobcard 
                @if($jobcard->jobCardCode)
                -   {{$jobcard->jobCardCode}}
                @endif
                </h2>
                
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <h2 class='conrol-label item-editable' data-type="text" jcfield="Subject" data-name="subject" data-pk="{{$jobcard->jobcardID}}" >{{ $jobcard->subject}}</h2>
                <br/>
              </div>

              <div class="col-md-4">
                <div class="btn-group col-md-12 jc-status" role="group" aria-label="...">
                  <span class="status-log hide-element">{{$jobcard->jobcardStatusID}}</span><br />
                  <button type="button" status="2" statusID class="btn btn-default jc-status hide-element">In Progress</button>
                  <button type="button" status="6" class="btn btn-default jc-status hide-element">Pending</button>
                  <button type="button" status="5" class="btn btn-default jc-status hide-element">Deferred</button>
                  <button type="button" status="4" class="btn btn-default jc-status hide-element">Completed</button>
                  <button type="button" status="3" class="btn btn-default jc-status hide-element">Resolved</button>
                  <button type="button" status="1" class="btn btn-default jc-status hide-element">Reopen</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">                
                <div class="box box-solid blue">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-list" aria-hidden="true"></i> Details</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="col-md-6">                      
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Status</p></b>
                          <span class='col-sm-4 bg-light-blue disabled ' >
                            @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
                               {{App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription}}
                            @endif
                          </span>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Jobcard Type</p></b>
                          <p class='col-sm-6 conrol-label jc-type' jcfield="Type">
                          @if($jobcard->jobcardTypeID && $jobcard->jobcardTypeID != 0)
                            {{ App\Model\JobCardType::find($jobcard->jobcardTypeID)->jobcardTypeDescription }}
                          @endif
                          </p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Priority</p></b>
                          <p class='col-sm-6 conrol-label jc-priority' jcfield="Priority">
                          @if($jobcard->priorityID && $jobcard->priorityID != 0)
                            {{App\Model\JobCardPriority::find($jobcard->priorityID)->priorityDescription}}
                          @endif
                          </p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Property name</p></b>
                        <p class='col-sm-6 conrol-label jc-property' jcfield="Property">{{ $property_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Tenant name</p></b>
                        <p class='col-sm-6 conrol-label jc-tenant' jcfield="Tenant">{{ $tenant_name }}</p>
                      </div>
                      <div class="row">
                        <b><p class="col-sm-4 control-label">Unit</p></b>
                        <p class='col-sm-6 conrol-label jc-unit' jcfield="Unit">{{ $unit_number }}</p>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="box box-solid blue  ">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Description</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="col-md-6">
                      <p class="item-editable" data-type="textarea" jcfield="Description" data-name="description" data-pk="{{$jobcard->jobcardID}}" data-tpl="<textarea></textarea>">{{ $jobcard->description}}</p>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-paperclip" aria-hidden="true"></i> Attachemnts</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <form action="/attachment/save" class="dropzone attachments-drop-box" id="my-awesome-dropzone">
                      {{ csrf_field() }}
                      <input type="hidden" name="documentAutoID" value="{{$jobcard->jobcardID}}">
                      <input type="hidden" name="documentID" value="{{$jobcard->documentID}}">
                      <div class="dz-message"><span>Drop files here or click here to upload</span></div>
                        <input type="file" name="file-upload">
                        <br/>

                      <div class="">
                        @foreach ($attachments as $attachment)
                          <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                            <div class="dz-image">
                            <span class="file-type"></span>
                              @if(substr(File::mimeType(storage_path('app\\uploads\\attachments\\' . $attachment->fileNameSlug)), 0, 5) == 'image')
                                <img class="dz-server-file" data-dz-remove src="/blog/storage/app/uploads/attachments/{{$attachment->fileNameSlug}}">
                              @endif
                            </div>
                            <div class="dz-details">
                                <div class="dz-size"><span data-dz-size="{{File::size(storage_path('app\\uploads\\attachments\\' . $attachment->fileNameSlug))}}"></span></div>
                                <div class="dz-filename"><span data-dz-name="">{{$attachment->fileName}}</span></div>
                            </div>
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div>
                            <a href="#" attachemnt-id="{{$attachment->attachmentID}}" class="jc-attachment">Remove</a>
                          </div>
                        @endforeach
                      </div>
                    </form>
                  </div>
                </div>
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Activity</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    
                    <div>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
                        <li role="presentation"><a href="#activity" aria-controls="activity" role="tab" data-toggle="tab">Activity</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="comments">
                          <br />
                          @component('comments', ['entity_id' => $jobcard->jobcardID])
                          @endcomponent
                        </div>
                        <div role="tabpanel" class="tab-pane" id="activity">
                          <br />
                          @component('jobcard_log', ['logs' => $logs])
                          @endcomponent
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-4 ">                
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-user" aria-hidden="true"></i> User Details</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Creator</p></b>
                      <p class='col-sm-6 conrol-label'>{{Sentinel::findById($jobcard->createdByUserID)->first_name }}</p>
                      <b><p class="col-sm-4 control-label">Phone</p></b>
                      <p class='col-sm-6 conrol-label'>XXX-XXX-XXX</p>
                      <b><p class="col-sm-4 control-label">Email</p></b>
                      <p class='col-sm-6 conrol-label'>testmail@mail.com</p>
                    </div>
                    <br />
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Assigned To </p></b>
                        <p class='col-sm-6 conrol-label jc-assigned-to' jcfield="Assigned To">
                          @if(Sentinel::findById($jobcard->assignedToID) && $jobcard->assignedToID != 0)
                            {{Sentinel::findById($jobcard->assignedToID)->first_name}}
                          @endif
                        </p>
                        <b><p class="col-sm-4 control-label">Phone</p></b>
                        <p class='col-sm-6 conrol-label'>XXX-XXX-XXX</p>
                        <b><p class="col-sm-4 control-label">Email</p></b>
                        <p class='col-sm-6 conrol-label'>testmail@mail.com</p>
                        </p>
                    </div>
                  </div>
                </div>
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <i class="fa fa-calendar" aria-hidden="true"></i> Dates</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Created on</p></b>
                      <p class='col-sm-6 conrol-label format-date'>{{ $jobcard->createdDateTime }}</p>
                    </div>
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Last Updated</p></b>
                      <p class='col-sm-6 conrol-label format-date'>{{ $jobcard->lastUpdatedDateTime }}</p>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
                
              </div>
              <!-- <div class="col-md-4 ">                
                /.box-body
              </div> -->
            </div>
          </div>
          
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    statusButtonHandler();
    $('.jc-status').on('click', function(){
      $('.status-log').text($(this).attr('status'));
      updateStatus($(this).attr('status'));
      statusButtonHandler();
    });

    function statusButtonHandler(){
      $('button.jc-status').hide();
      switch($('.status-log').text()) {
      case '1':
          $('[status="2"]').show();
          $('[status="6"]').show();
          break;
      case '2':
          $('[status="5"]').show();
          $('[status="6"]').show();
          $('[status="3"]').show();
          break;
      case '6':
          $('[status="2"]').show();
          $('[status="5"]').show();
          break;
      case '5':
          $('[status="1"]').show();
          break;
      case '4':
          $('[status="1"]').show();
          break;
      case '3':
          $('[status="4"]').show();
          break;
      case '1':
          $('[status="2"]').show();
          $('[status="6"]').show();
          break;
      }
    }

    function updateStatus(id){
      $.ajax({
        type: 'POST',
        url: '/jobcards/update',
        data: { 
          _token: '{{ csrf_token() }}',
          name: 'jobcardStatusID',
          value: id,
          pk:'{{$jobcard->jobcardID}}',
          field: 'Status',
        },
        
      })
    }

    // filter child selection on page load
    childSelection($('.selection-parent-item'));
    // $('.no-units').hide();
    // Load content based on previous selection
    $('.selection-parent-item').on('change', function() {
        childSelection(this)
    });

    function childSelection(elem) {
        var prev_selection = $('.selection-child-item').val();
        if ($(elem).val() != 0) {
            $('.selection-child-item').show();
            $('.no-units').hide();
            $.ajax({
                    url: "/jobcard/getunit/" + $(elem).val() + "",
                    context: document.body,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .done(function(data) {
                    // show message if no units for the selected property
                    if (data.length) {
                        $('.selection-child-item').html(function() {
                            // Generate the seletect list
                            var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
                            output += '<option value="">Select a unit</option>';
                            data.forEach(function(index, element) {
                                if (prev_selection == data[element].unitID) {
                                    output += '<option value="' + data[element].unitID + '" selected="selected">' + data[element].unitNumber + '</option>';
                                } else {
                                    output += '<option value="' + data[element].unitID + '">' + data[element].unitNumber + '</option>';
                                }
                            });
                            output += '</select>';
                            return output;
                        });
                    } else {
                        $('.selection-child-item').hide();
                        $('.no-units').show();
                    }
                });
        } else {
            $('.selection-child-item').hide();
            $('.no-units').show();
        }
    }

    //edit form style - popup or inline
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.params = function (params) {
      params._token = '{{ csrf_token() }}';
      return params;
    };
    $('.item-editable').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',   
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            }         
    });
    $('.status').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardStatusID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($jobcardstatuss as $jobcardstatus)
              {value: "{{$jobcardstatus->jobcardStatusID}}", text:"{{ $jobcardstatus->statusDescription }}"},
            @endforeach
            ],
    });
    $('.jc-type').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardTypeID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                console.log($(this).attr('jcfield')); 
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($jobcardtypes as $jobcardtype)
              {value: "{{$jobcardtype->jobcardTypeID}}", text:"{{ $jobcardtype->jobcardTypeDescription }}"},
            @endforeach
            ],
    });
    $('.jc-priority').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "priorityID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($jobcardprioritys as $jobcardpriority)
              {value: "{{$jobcardpriority->priorityID}}", text:"{{ $jobcardpriority->priorityDescription }}"},
            @endforeach
            ],
    });
    $('.jc-property').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardStatusID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($properties as $property)
              {value: "{{$property->PropertiesID}}", text:"{{ $property->pPropertyName }}"},
            @endforeach
            ],
    });
    $('.jc-tenant').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardStatusID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($tenants as $tenant)
              {value: "{{$tenant->tenantsID}}", text:"{{ $tenant->firstName }}"},
            @endforeach
            ],
    });
    $('.jc-unit').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardStatusID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($units as $unit)
              {value: "{{$unit->unitID}}", text:"{{ $unit->unitNumber }}"},
            @endforeach
            ],
    });
    $('.jc-assigned-to').editable({
        validate: function(value) {
            if($.trim(value) == '') 
                return 'Value is required.';
        },
            method: 'POST',
            url:'/jobcards/update',  
            title: 'Edit',
            send:'always',
            type: "select",
            name: "jobcardStatusID",
            pk: "{{$jobcard->jobcardID}}",
            tpl: "<select></select>",
            params: function(params) {
                //originally params contain pk, name and value
                params.field = $(this).attr('jcfield');
                params._token = '{{ csrf_token() }}';
                return params;
            },
            source : [
            @foreach ($users as $user)
              {value: "{{$user->id}}", text:"{{ $user->first_name }}"},
            @endforeach
            ],
    });

    $('.jc-attachment').on('click', function(e){
      e.preventDefault();
      // Hide preview to show its deleted
      $(this).closest('.dz-preview').hide();
      // Send request to delete from db
      $.ajax({
        type: 'POST',
        url: '/jobcard-attachments/'+ $(this).attr('attachemnt-id'),
        data: { 
          _token: '{{ csrf_token() }}',
          _method: 'delete',
        },
        
      })
    });

    /**
     * Load already added files
     */

    // The setting up of the dropzone
    // var photo_counter = 0;
    Dropzone.options.myAwesomeDropzone = {

        uploadMultiple: true,
        parallelUploads: 100,
        maxFilesize: 2,
        addRemoveLinks: true,
        dictRemoveFile: "Remove"

        // The setting up of the dropzone
        // init:function() {
        //     // Add server images
        //     var myDropzone = this;

  

    //         $.ajax({
    //             // url : '/jobcard-attachments/{{$jobcard->jobcardID}}',
    //             // method: "POST",
    //             // data: { _token: $('input[name="_token"]').val()},
    //             // dataType: 'json',
    //             // accepts: {
    //             //     xml: 'text/xml',
    //             //     text: 'text/plain'
    //             // }
    //         })
    //         .done(function(data) {
    //           // console.log(data); 
    //             $.each(data.images, function (key, value) {
    //                 var file = {name: value.original, size: value.size};
    //                 var imageUrl = "/blog/storage/app/uploads/attachments/"+ value.server;

    //                 myDropzone.emit("thumbnail", file, imageUrl);
    //                 // console.log(file); 
    //                 // console.log(imageUrl); 
    //                 myDropzone.createThumbnailFromUrl(file, 200, 200, false, false, false, false);
    //                 // myDropzone.emit("complete", file);
    //                 // photo_counter++;
    //                 // console.log(photo_counter); 
    //             });
    //         });


    //         // this.on("removedfile", function(file) {

    //         //     $.ajax({
    //         //         type: 'POST',
    //         //         url: 'upload/delete',
    //         //         data: {id: file.name, _token: $('#csrf-token').val()},
    //         //         dataType: 'html',
    //         //         success: function(data){
    //         //             var rep = JSON.parse(data);
    //         //             if(rep.code == 200)
    //         //             {
    //         //                 photo_counter--;
    //         //                 $("#photoCounter").text( "(" + photo_counter + ")");
    //         //             }

    //         //         }
    //         //     });

    //         // } );
    //     },
    //     // error: function(file, response) {
    //     //     if($.type(response) === "string")
    //     //         var message = response; //dropzone sends it's own error messages in string
    //     //     else
    //     //         var message = response.message;
    //     //     file.previewElement.classList.add("dz-error");
    //     //     _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
    //     //     _results = [];
    //     //     for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    //     //         node = _ref[_i];
    //     //         _results.push(node.textContent = message);
    //     //     }
    //     //     return _results;
    //     // },
    //     // success: function(file,done) {
    //     //     photo_counter++;
    //     //     $("#photoCounter").text( "(" + photo_counter + ")");
    //     // }
    }



    
});

</script>
@endpush