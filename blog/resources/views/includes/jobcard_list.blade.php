<div class="jc-list">
  @foreach($jobcards_list as $jobcard)
    <div class="jc-list-item">          
      <div class="col-md-3">  
        @if(App\Model\JobCardStatus::find($jobcard->jobcardStatusID) && $jobcard->jobcardStatusID != 0)
          <div class="stattus-box"><?php print App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription[0] ?></div>            
        @endif
        <br/>
        <p class=""><b>{{$jobcard->subject}} &nbsp;&nbsp;</b></p>
        <p>{{$jobcard->description}}</p>
        @if(App\Model\JobCardStatus::find($jobcard->jobcardStatusID) && $jobcard->jobcardStatusID != 0)
          <p class="inline-element"><b>Status:  &nbsp;&nbsp;</b><span class="label bg-light-blue disabled">
             {{App\Model\JobCardStatus::find($jobcard->jobcardStatusID)->statusDescription}}
          </span></p>
        @endif
      </div>
      <div class="col-md-2">
        <br/>
        @if(App\Model\Property::find($jobcard->PropertiesID) && $jobcard->PropertiesID != 0)
          <p>
            <b>Property</b>
            <span>{{App\Model\Property::find($jobcard->PropertiesID)->pPropertyName}}</span>
          </p>
        @endif
        @if(App\Model\Tenant::find($jobcard->tenantsID) && $jobcard->tenantsID != 0)
          <p>
            <b>Tenant</b>
            <span>{{App\Model\Tenant::find($jobcard->tenantsID)->firstName}}</span>
          </p>
        @endif
        @if(App\Model\Unit::find($jobcard->unitID) && $jobcard->unitID != 0)
          <p>
            <b>Unit</b>
            <span>{{App\Model\Unit::find($jobcard->unitID)->unitNumber}}</span>
          </p>
        @endif
      </div>
      <div class="col-md-2">
        <br/><br/>
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
            <a class="btn bg-green btn-sm" data-toggle="tooltip" title="View" href="jobcard/edit/{{$jobcard->jobcardID}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
          </div>
          @if(!$hide_delete)
            <form class="delete-form" method="POST" action="jobcard/{{$jobcard->jobcardID}}">
              <a href="" class="delete-btn btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete"><span>
              <i class="fa fa-trash" aria-hidden="true"></i></span><span class="after"><i class="fa fa-question" aria-hidden="true"></i></span></a>
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
          @endif
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>