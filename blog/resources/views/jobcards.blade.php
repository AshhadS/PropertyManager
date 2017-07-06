@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Jobcards</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add Jobcard</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="/jobcards" method="POST">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" name="subject" class="form-control input-req" required placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="2" placeholder="Description"></textarea>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Property Name</label>
              <div class="col-sm-10">
                <select name="PropertiesID" class="form-control selection-parent-item" >
                        <option value="0">Select a property</option>
                    @foreach ($properties as $property)
                        <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label name="tenant" class="col-sm-2 control-label">Tenant Name</label>
              <div class="col-sm-10">
                <select class="form-control" name="tenantsID">
                        <option value="">Select a tenant</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label name="unit" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-10">
                <select class="form-control selection-child-item" name="unitID">
                        <option value="0">Select a unit</option>
                    @foreach ($units as $unit)
                        <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                    @endforeach
                </select>
                <p class="no-units">No units belonging to this property</p>
              </div>
            </div>

            <div class="form-group">
              <label name="jobcardStatusID" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control" name="jobcardStatusID">
                  @foreach ($jobcardstatuss as $jobcardstatus)
                      <option value="{{$jobcardstatus->jobcardStatusID}}">{{ $jobcardstatus->statusDescription }}</option>
                  @endforeach
                </select>
              </div>
            </div>  

            <div class="form-group">
              <label class="col-sm-2 control-label">Job Card Priority</label>
              <div class="col-sm-10">
                <select name="priorityID" class="form-control" >
                        <option value="0">Select a priority</option>
                    @foreach ($jobcardprioritys as $jobcardpriority)
                        <option value="{{$jobcardpriority->priorityID}}">{{ $jobcardpriority->priorityDescription }}</option>
                    @endforeach
                </select>
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-2 control-label">Job Card Type</label>
              <div class="col-sm-10">
                <select name="jobcardTypeID" class="form-control" >
                        <option value="0">Select a type</option>
                    @foreach ($jobcardtypes as $jobcardtype)
                        <option value="{{$jobcardtype->jobcardTypeID}}">{{ $jobcardtype->jobcardTypeDescription }}</option>
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
<div class="container-fluid">
  <section class="content-header pull-left">
      <h1>Jobcards</h1>
  </section>

  <br/><br/>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Jobcard</b>
  </button>
</div>

<div class="container-fluid" >

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#opened" aria-controls="opened" role="tab" data-toggle="tab">Open Cards &nbsp;&nbsp;<span class="badge bg-light-blue">{{$openCount}}</span></a></li>
    <li role="presentation"><a href="#closed" aria-controls="closed" role="tab" data-toggle="tab">Closed Cards &nbsp;&nbsp;<span class="badge bg-light-blue">{{$closedCount}}</span></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="opened">
      <h3>Opened Jobcards</h3>
      <div class="jc-list">
        @foreach($openJobcards as $jobcard)
          <div class="jc-list-item">          
            <div class="col-md-5">  
              @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
                <div class="stattus-box"><?php print App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription[0] ?></div>            
              @endif

              <br/>
              <p class=""><b>{{$jobcard->subject}} &nbsp;&nbsp;</b></p>
              <p>{{$jobcard->description}}</p>
              @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
              <p class="inline-element"><b>Status:  &nbsp;&nbsp;</b><span class="label bg-light-blue disabled">
                 {{App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription}}
              </span></p>
              @endif
              

            </div>
            <div class="col-md-2">
              <br/>
              <br/>
              <div class="jc assigned-to clearfix">
                <span>Assiged To: <span class="profile-image"><img src="{{ asset("/bower_components/admin-lte/dist/img/idss-defualt.png") }}" class="user-image" alt="User Image"/></span>  
                  @if(Sentinel::findById($jobcard->assignedToID))
                    {{Sentinel::findById($jobcard->assignedToID)->first_name }}
                  @else
                    none
                  @endif
                </span>
              </div>
            </div>
            <div class="col-md-2">
              <div class="jc-priority">  
                @if($jobcard->jobCardCode)
                 <h5><b>{{$jobcard->jobCardCode}}</b></h5>
                @endif
              </div>
              <div class="jc assigned-to clearfix">
                <span>Created By: <span class="profile-image"><img src="{{ asset("/bower_components/admin-lte/dist/img/idss-defualt.png") }}" class="user-image" alt="User Image"/></span>
                  @if(Sentinel::findById($jobcard->createdByUserID))
                    {{Sentinel::findById($jobcard->createdByUserID)->first_name }}
                  @else
                    none
                  @endif
                </span>
              </div>
            </div>
            <div class="col-md-2">
              <div class="jc-priority">  
                @if(App\Model\JobCardPriority::find($jobcard->priorityID))
                 <p>{{App\Model\JobCardPriority::find($jobcard->priorityID)->priorityDescription}} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
                @endif
              </div>
            </div>
            <div class="pull-right">
              <br/>
              <div class="jc-edit-button clearfix">
                <div class="inner">
                <div>
                  <a class="btn bg-green btn-sm" href="jobcard/edit/{{$jobcard->jobcardID}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
                <form class="delete-form" method="POST" action="jobcard/{{$jobcard->jobcardID}}">
                  <a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>
                  <i class="fa fa-trash" aria-hidden="true"></i></span><span class="after"><i class="fa fa-question" aria-hidden="true"></i></span></a>
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="closed">
      <h3>Closed Jobcards ({{$closedCount}})</h3>
      <div class="jc-list">
         @foreach($closedJobcards as $jobcard)
          <div class="jc-list-item">          
            <div class="col-md-5">  
              @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
                <div class="stattus-box"><?php print App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription[0] ?></div>            
              @endif

              <h3 class=""><b>{{$jobcard->subject}} &nbsp;&nbsp;</b></h3>
              <p>{{$jobcard->description}}</p>
              @if($jobcard->jobcardStatusID && $jobcard->jobcardStatusID != 0)
              <h4 class="inline-element"><b>Status:  &nbsp;&nbsp;</b><span class="label bg-light-blue disabled">
                 {{App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription}}
              </span></h4>
              @endif
              

            </div>
            <div class="col-md-2">
              <br/>
              <br/>
              <div class="jc assigned-to clearfix">
                <span>Assiged To: <span class="profile-image"></span>  
                  @if(Sentinel::findById($jobcard->assignedToID))
                    {{Sentinel::findById($jobcard->assignedToID)->first_name }}
                  @else
                    none
                  @endif
                </span>
              </div>
            </div>
            <div class="col-md-2">
              <div class="jc-priority">  
                @if($jobcard->jobCardCode)
                 <h5><b>{{$jobcard->jobCardCode}}</b></h5>
                @endif
              </div>
              <div class="jc assigned-to clearfix">
                <span>Created By: <span class="profile-image"></span>
                  @if(Sentinel::findById($jobcard->createdByUserID))
                    {{Sentinel::findById($jobcard->createdByUserID)->first_name }}
                  @else
                    none
                  @endif
                </span>
              </div>
            </div>
            <div class="col-md-2">
              <div class="jc-priority">  
                @if(App\Model\JobCardPriority::find($jobcard->priorityID))
                 <h4>{{App\Model\JobCardPriority::find($jobcard->priorityID)->priorityDescription}} <i class="fa fa-long-arrow-up" aria-hidden="true"></i></h4>
                @endif
              </div>
            </div>
            <div class="pull-right">
              <br/>
              <div class="jc-edit-button clearfix">
                <div class="inner">
                <div>
                  <a class="btn bg-green btn-sm" href="jobcard/edit/{{$jobcard->jobcardID}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
                <form class="delete-form" method="POST" action="jobcard/{{$jobcard->jobcardID}}">
                  <a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>
                  <i class="fa fa-trash" aria-hidden="true"></i></span><span class="after"><i class="fa fa-question" aria-hidden="true"></i></span></a>
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>    
@endsection
@push('scripts')
<script>
$(function() {
    $('#jobcards-table').DataTable({
        processing: true,
        ordering: false,
        serverSide: true,
        ajax: {
          'url' : 'jobcards/all',
          'type': 'POST' ,
          'headers' : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columnDefs": [
          { "width": "10%", "targets": 8 }
        ],
        columns: [
            { data: 'subject', name: 'jobcard.subject'},  
            { data: 'description', name: 'jobcard.description'},  
            { data: 'pPropertyName', name: 'Properties.pPropertyName'},  
            { data: 'statusDescription', name: 'jobcardstatus.statusDescription'},  
            { data: 'firstName', name: 'tenats.firstName'},  
            { data: 'unitNumber', name: 'units.unitNumber'},  
            { data: 'first_name', name: 'users.first_name'},  
            // { data: 'createdDateTime', name: 'jobcard.createdDateTime'}, 
            { 
              data: 'createdDateTime',
              name: 'jobcard.createdDateTime',
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
                data: 'jobcardID',
                className: 'edit-button',
                orderable: false,
                render: function ( data, type, full, meta ) {
                  // Create action buttons
                  var action = '<center><span class="inner"><a class="btn bg-green btn-sm" href="jobcard/edit/'+data+'"><i class="fa fa-eye" aria-hidden="true"></i>View</a>';
                  action += '<form class="delete-form" method="POST" action="jobcard/'+data+'">';
                  action += '<a href="" class="delete-btn btn btn-danger btn-sm button--winona"><span>';
                  action += '<i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span></a>';
                  action += '<input type="hidden" name="_method" value="DELETE"> ';
                  action += '<input type="hidden" name="_token" value="'+ $('meta[name="_token_del"]').attr('content') +'">';
                  action += '</form></span></center>';
                  return action;
                }
            }      
        ]
    });
      // filter child selection on page load
      childSelection($('.selection-parent-item'));

      // $('.no-units').hide();
      // Load content based on previous selection
      $('.selection-parent-item').on('change', function(){
        childSelection(this)
      });

      function childSelection(elem){
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
                        output += '<option value="'+data[element].unitID+'">'+data[element].unitNumber+'</option>';
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
