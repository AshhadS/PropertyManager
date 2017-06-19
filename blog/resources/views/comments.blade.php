<div class="container-fluid">
  <div class="box box-widget">
    <div class="box-header with-border">
      <h2>Comments</h2>
      <!-- /.user-block -->
      <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
          <i class="fa fa-circle-o"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <!-- /.box-footer -->
    <div class="box-footer">
      <form class="form-horizontal" action="/jobcardcomment" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="text" class="form-control" name='comments' placeholder="Type your comment here and press enter...">
        <input type="hidden" class="form-control" name="jobcardID" value="{{$entity_id}}">
      </form>
    </div>
    <!-- /.box-footer -->
  </div>
</div>