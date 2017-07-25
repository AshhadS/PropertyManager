<div class="container-fluid">
  <div class="box box-widget">
    <div class="box-header with-border">
      <h4><b>NOTES</b></h4>
      <!-- /.user-block -->
    </div>
    <!-- /.box-header -->
    <div class="box-footer box-comments">
      @foreach ($notes as $note)
      <div class="box-comment">
        <!-- User image -->
        <img class="img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="User Image">

        <div class="comment-text">
              <span class="username">
                {{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}
                <span class="text-muted pull-right">{{ Carbon\Carbon::parse($note->updatedDate)->diffForHumans() }}</span>
              </span><!-- /.username -->
          {{$note->notes}}
        </div>
        <!-- /.comment-text -->
      </div>
      <!-- /.box-comment -->      
      @endforeach
    </div>
    <!-- /.box-footer -->
    <div class="box-footer">
      <form class="form-horizontal" action="/note" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="text" class="form-control" name='notes' placeholder="Type your notes here and press enter...">
        <input type="hidden" class="form-control" name="documentID" value="{{$documentID}}">
        <input type="hidden" class="form-control" name="documentAutoID" value="{{$documentAutoID}}">
      </form>
    </div>
    <!-- /.box-footer -->
  </div>
</div>