
<h3 class="title">Customer</h3>
<button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add customer</b>
  </button>
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>Customer Id</th>
        <th>Customer Name</th>
        <th>Address </th>
        <th>telephone</th>
        <th>Fax</th>
        <th>Type</th>
        <th>Actions </th>
      </tr>
      @foreach ($customers as $customer)
      <tr>
        <td >{{$customer->customerID}}</td>
        <td >{{$customer->customerCode}}</td>
        <td class='customer item-editable' data-type="text" data-name="customerName" data-pk="{{$customer->customerID}}">{{$customer->customerName}}</td>
        <td class='customer item-editable' data-type="textarea" data-name="address" data-pk="{{$customer->customerID}}">{{$customer->address}}</td>
        <td class='customer item-editable input-tel' data-type="text" data-name="telephoneNumber" data-pk="{{$customer->customerID}}">{{$customer->telephoneNumber}}</td>
        <td class='customer item-editable input-tel' data-type="text" data-name="faxNumber" data-pk="{{$customer->customerID}}">{{$customer->faxNumber}}</td>
        <td >
          <?php
            if($customer->fromPropertyOwnerOrTenant == 1){
              echo "Proeprty Owner";
            }else if($customer->fromPropertyOwnerOrTenant == 2){
              echo "Tenant";
            }else{
              echo "Normal";
            }
          ?>
        </td>
        <td>
          <!-- <button class="btn btn-info btn-sm edit-settings" data-id="{{$customer->supplierID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button> -->

          <form class="delete-form clearfix" data-section="customer" method="POST" action="customer/{{$customer->customerID}}">
            <a href="#" class="delete-btn-ajax btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button class="hide-element" data-section="customer"></button>
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
      
      <div class="modal-body">
        <form class="form-horizontal ajax-process pull add-customer" action="/customer" method="POST">
            {{ csrf_field() }}
            
            <div class="form-group">
              <label class="col-sm-2 control-label">Customer Name</label>
              <div class="col-sm-10">
                <input type="text" name="customerName" class="form-control">
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
                <button type="submit" data-section="customer" class="btn btn-info pull-right">Save</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
  
          
