
<h3 class="title">Payment Types</h3>
<div class="col-md-6">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">id</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
      @foreach ($paymenttypes as $paymenttype)
      <tr>
        <td>{{$paymenttype->paymentTypeID}}</td>
        <td>{{$paymenttype->paymentDescription}}</td>
        <td>
          <button class="btn btn-info btn-sm edit-settings" data-id="{{$paymenttype->paymenttypesID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

          <form class="delete-form clearfix" method="POST" action="paymenttype/{{$paymenttype->paymentTypeID}}">
            <a href="#" class="delete-btn btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="col-md-6">
  <h4>Add Payment Types</h4>
  <form class="form-horizontal pull" action="/paymenttype" method="POST">
      {{ csrf_field() }}
      <div class="simple-add-textbox-wrapper pull-left">
        <input type="text" name="paymentDescription" class="pull-left simple-add-textbox input-req">
        
      </div>
      <button type="submit" class="btn btn-info simple-add-btn pull-left"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>