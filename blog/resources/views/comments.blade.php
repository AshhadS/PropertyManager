<div class="container-fluid">
  <div class="box box-widget">
    <!-- /.box-header -->
    <!-- /.box-footer -->
    <div class="box-footer">
      <h4 class="pull-left">COMMENTS</h4>
      <br />
      <br />
      <form class="form-horizontal" action="/jobcardcomment" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="text" class="form-control" name='comments' placeholder="Type your comment here and press enter...">
        <input type="hidden" class="form-control" name="jobcardID" value="{{$entity_id}}">
      </form>
    </div>
    <!-- /.box-footer -->
  </div>
</div>