
<h3 class="title">Chart of Accounts</h3>
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">Id</th>
        <th>Account Code</th>
        <th>Account Description</th>
        <th>Main Code</th>
        <th>Type</th>
        <th>Actions </th>
      </tr>
      @foreach ($chartofaccounts as $account)
      <tr>
        <td>{{$account->chartOfAccountID}}</td>
        <td class='accounts item-editable' data-type="text" data-name="chartOfAccountCode" data-pk="{{$account->chartOfAccountID}}" >{{$account->chartOfAccountCode }}</td>
        <td class='accounts item-editable' data-type="textarea" data-name="accountDescription" data-pk="{{$account->chartOfAccountID}}" >{{$account->accountDescription}}</td>
        <td class='accounts item-editable' data-type="text" data-name="mainCode" data-pk="{{$account->chartOfAccountID}}" >{{$account->mainCode}}</td>
        <td class='accounts-type item-editable' data-type="select" data-name="type" data-pk="{{$account->chartOfAccountID}}" >{{$account->type }}</td>
        <td>
          <button class="btn btn-info btn-sm edit-settings" data-id="{{$account->accountID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

          <form class="delete-form clearfix" data-section="accounts" method="POST" action="account/{{$account->accountID}}">
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
  <h4>Add Chart of Account</h4>
  <form class="form-horizontal ajax-process  pull add-user" action="/account" method="POST">
      {{ csrf_field() }}
        <input type="text" name="chartOfAccountCode" placeholder="Account Code" class="input-req">
        <textarea name="accountDescription" placeholder="Account Description"></textarea>
        <input type="text" name="mainCode" placeholder="Main Code" >
        <select name="type" id="accountType">
          <option value="1">Expense</option>
          <option value="2">Income</option>
        </select>        
      <button type="submit" class="btn btn-info " data-section="accounts"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>
