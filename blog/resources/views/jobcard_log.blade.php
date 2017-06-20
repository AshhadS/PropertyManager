<!-- The timeline -->
<ul class="timeline timeline-inverse">
  
    @foreach ($logs as $log)
      <!-- timeline item -->
      @if($log->field == 'Comment')
        <li>
          <i class="fa fa-comments bg-yellow"></i>
          <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($log->timestamp)->diffForHumans() }}</span>
            <h3 class="timeline-header"><a href="#">{{$log->updatedByEmpName}} </a> commented on your post</h3>
            <div class="timeline-body">
              {{$log->history}}
            </div>
            <div class="timeline-footer">
              <a class="btn btn-warning btn-flat btn-xs"> <i class="fa fa-reply" aria-hidden="true"></i> Reply</a>
            </div>
          </div>
        </li>
      @else
        <!-- timeline item -->
        <li>
          <i class="fa fa-user bg-aqua"></i>
          <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($log->timestamp)->diffForHumans() }}</span>
            <h3 class="timeline-header no-border"><a href="#">{{$log->updatedByEmpName}}</a> {{$log->history}}
            </h3>
          </div>
        </li>
        <!-- END timeline item -->


      @endif


      <!-- END timeline item -->    
    @endforeach
  <li>
    <i class="fa fa-clock-o bg-gray"></i>
  </li>
</ul>
