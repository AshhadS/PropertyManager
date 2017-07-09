
<h3 class="title">Supplier</h3>
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>Supplier Id</th>
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
          <button class="btn btn-info btn-sm edit-settings" data-id="{{$supplier->supplierID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

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
<div class="col-md-12">
  <h4>Add User</h4>
  <form class="form-horizontal ajax-process  pull add-user" action="/supplier" method="POST">
      {{ csrf_field() }}
        <input type="text" name="supplierCode" placeholder="Supplier Code" class="input-req">
        <input type="text" name="supplierName" placeholder="Supplier  Name" >
        <input type="tel" name="telephoneNumber" placeholder="Telephone" >
        <input type="tel" name="faxNumber" placeholder="Fax" >
        <textarea name="address" placeholder="Address"></textarea>
        
      <button type="submit" class="btn btn-info " data-section="supplier"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>
