<meta name="_token_del" content="{{ csrf_token() }}">
<h3 class="title">Bank</h3>
<div class="col-md-6">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">id</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
      @foreach ($banks as $bank)
      <tr>

        <td  >{{$bank->bankmasterID}}</td>
        <td class='bank item-editable' data-type="text" data-name="bankName" data-pk="{{$bank->bankmasterID}}" >{{$bank->bankName}}</td>
        <td class="edit-button">

          <form class="delete-form clearfix" data-section="banks" method="POST" action="bank/{{$bank->bankmasterID}}">
            <a href="#" class="delete-btn-ajax btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>

          <a href="#" class="btn btn-primary btn-second btn-sm account-popover-launch" data-bankid="{{$bank->bankmasterID}}" data-toggle="popover"><i class="fa fa-plus"></i> Add Bank Account</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <p class="text-muted">Click the table cell to edit an item</p>
  
</div>
<div class="col-md-6">
  <h4>Add Bank</h4>
  <form class="form-horizontal ajax-process  pull" action="/bank" method="POST">
      {{ csrf_field() }}
      <div class="simple-add-textbox-wrapper pull-left">
        <input type="text" name="bankName" class="pull-left simple-add-textbox input-req">
        
      </div>
      <button type="submit" class="btn btn-info simple-add-btn pull-left " data-section="banks"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>

