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
</ul>
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
              <div class="col-md-4">
                <h2 class='conrol-label item-editable' data-type="text" jcfield="Subject" data-name="subject" data-pk="{{$jobcard->jobcardID}}" >{{ $jobcard->subject}}</h2>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="box box-solid blue  ">
                  <div class="box-header with-border">
                    <h3 class="box-title">Description</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <p class="item-editable" data-type="textarea" jcfield="Description" data-name="description" data-pk="{{$jobcard->jobcardID}}" data-tpl="<textarea></textarea>">{{ $jobcard->description}}</p>
                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="box box-solid blue">
                  <div class="box-header with-border">
                    <h3 class="box-title">Details</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Status</p></b>
                      @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
                        <p class='col-sm-6 conrol-label status' jcfield="Description">{{ App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription }}</p>
                      @endif
                    </div>
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Jobcard Type</p></b>
                      @if($jobcard->jobcardTypeID && $jobcard->jobcardTypeID != 0)
                        <p class='col-sm-6 conrol-label jc-type' jcfield="Type">{{ App\Model\JobCardType::find($jobcard->jobcardTypeID)->jobcardTypeDescription }}</p>
                      @endif
                    </div>
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Priority</p></b>
                      @if($jobcard->priorityID && $jobcard->priorityID != 0)
                        <p class='col-sm-6 conrol-label jc-priority' jcfield="Priority">{{App\Model\JobCardPriority::find($jobcard->priorityID)->priorityDescription}}</p>
                      @endif
                    </div>
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
                  <!-- /.box-body -->
                </div>
              </div>
              <div class="col-md-4 ">                
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title">User Details</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Creator</p></b>
                      <p class='col-sm-6 conrol-label'>{{Sentinel::findById($jobcard->createdByUserID)->first_name }}</p>
                    </div>
                    <div class="row">
                      <b><p class="col-sm-4 control-label">Assigned To </p></b>
                      @if($jobcard->assignedToID && $jobcard->assignedToID != 0)
                        <p class='col-sm-6 conrol-label jc-assigned-to' jcfield="Assigned To">{{Sentinel::findById($jobcard->assignedToID)->first_name}}</p>
                      @endif
                    </div>
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
              <div class="col-md-4 ">                
                <div class="box box-solid blue ">
                  <div class="box-header with-border">
                    <h3 class="box-title">Attachemnts</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    @component('attachments', [
                    'entity_id' => $jobcard->jobcardID,
                    'document_id' => $jobcard->documentID, 
                    'attachments' => $attachments
                    ])
                    @endcomponent
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
          </div>
          <br/> <br/>
          @component('comments', ['entity_id' => $jobcard->jobcardID])
          @endcomponent
          <br/> <br/>
          @component('jobcard_log', ['logs' => $logs])
          @endcomponent
          
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
</div>
@endsection
@push('scripts')
<script>
$(function() {
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
    })
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
    })
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
    })
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
    })
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
    })
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
    })
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
    })
});

</script>
@endpush