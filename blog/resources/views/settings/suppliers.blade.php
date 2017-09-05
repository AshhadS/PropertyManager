
<h3 class="title">Supplier</h3>
<button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Supplier</b>
  </button>
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>Supplier Code</th>
        <th>Supplier Name</th>
        <th>Address </th>
        <th>telephone</th>
        <th>Fax</th>
        <th>Actions </th>
      </tr>
      @foreach ($suppliers as $supplier)
      <tr>
        <td >{{$supplier->supplierID}}</td>
        <td class='supplier item-editable' data-type="text" data-name="supplierCode" data-pk="{{$supplier->supplierID}}">{{$supplier->supplierCode}}</td>
        <td class='supplier item-editable' data-type="text" data-name="supplierName" data-pk="{{$supplier->supplierID}}">{{$supplier->supplierName}}</td>
        <td class='supplier item-editable' data-type="textarea" data-name="address" data-pk="{{$supplier->supplierID}}">{{$supplier->address}}</td>
        <td class='supplier item-editable' data-type="text" data-name="telephoneNumber" data-pk="{{$supplier->supplierID}}">{{$supplier->telephoneNumber}}</td>
        <td class='supplier item-editable' data-type="text" data-name="faxNumber" data-pk="{{$supplier->supplierID}}">{{$supplier->faxNumber}}</td>
        <td>
          <!-- <button class="btn btn-info btn-sm edit-settings" data-id="{{$supplier->supplierID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button> -->

          <form class="delete-form clearfix" data-section="supplier" method="POST" action="supplier/{{$supplier->supplierID}}">
            <a href="#" class="delete-btn-ajax btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
      <p class="text-muted">Click the table cell to edit an item</p>
      
    </tbody>
  </table>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Supplier</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
          <h4>Add Supplier</h4>
          <form class="form-horizontal ajax-process  pull add-user" action="/supplier" method="POST">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="col-sm-2 control-label">Supplier code</label>
                <div class="col-sm-10">
                  <input type="text" name="supplierCode" class="form-control input-req">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Supplier Name</label>
                <div class="col-sm-10">
                  <input type="text" name="supplierName" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Telephone</label>
                <div class="col-sm-10">
                  <input type="tel" name="telephoneNumber" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Fax</label>
                <div class="col-sm-10">
                  <input type="tel" name="faxNumber" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Address</label>
                <div class="col-sm-10">
                  <textarea name="address" class="form-control" ></textarea>
                </div>
              </div>
                 
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="reset" class="btn btn-default" value="Reset">
                  <button type="submit" data-section="supplier" class="btn btn-info pull-right">Save</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  
          
