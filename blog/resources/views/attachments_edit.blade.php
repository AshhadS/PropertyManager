<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <br>
              <section class="content-header">
                  <h1>Attachment</h1>
              </section>
              <br>
              <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Edit</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal edit-form" action="/attachment/update" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <input type="hidden" name="attachmentID" class="form-control">
                      <input type="hidden" name="documentAutoID" class="form-control"  >
                      <input type="hidden" name="documentID" class="form-control">
              
                      <div class="form-group">
                        <label class="col-sm-2 control-label">File Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="fileNameCustom"  class="form-control input-req"  placeholder="Name">
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
                            <p class="image-exists">Image has already been added</p>
                            <span class='remove-attachment btn btn-danger btn-sm'>Remove</span>
                            <div class="file-input">
                              <input type="file" name="attachmentFile">
                            </div>
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
  </div>
</div>
