<?php use App\Http\Controllers\SettingsController; ?>
<h3 class="title">Chart of Accounts</h3>
<!-- Button trigger modal -->
  <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Chart Of Accounts</b>
  </button>
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
        <td class='accounts'>{{$account->chartOfAccountCode }}</td>
        <td class='accounts item-editable' data-type="textarea" data-name="accountDescription" data-pk="{{$account->chartOfAccountID}}" >{{$account->accountDescription}}</td>
        <td class='accounts item-editable' data-type="text" data-name="mainCode" data-pk="{{$account->chartOfAccountID}}" >{{$account->mainCode}}</td>
        <td class='accounts-type item-editable' data-type="select" data-name="type" data-pk="{{$account->chartOfAccountID}}" ><?php print SettingsController::getAccountType($account->type); ?></td>
        <td>
          <!-- <button class="btn btn-info btn-sm edit-settings" data-id="{{$account->accountID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button> -->

          <form class="delete-form clearfix" data-section="accounts" method="POST" action="account/{{$account->chartOfAccountID}}">
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chart of Accounts</h4>
      </div>
      <div class="modal-body">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add Chart of Account</h3>
          </div>
          <form class="form-horizontal ajax-process  pull add-user" action="/account" method="POST">
              {{ csrf_field() }}
              <!-- <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" name="chartOfAccountCode" placeholder="Account Code" class="input-req form-control">
                </div>
              </div> -->
              <div class="form-group">
              <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="accountDescription" placeholder="Account Description"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Main Code</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="mainCode" placeholder="Main Code" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Account Type</label>
                <div class="col-sm-10">
                  <select name="type" id="accountType" class="form-control">
                    <option value="1">Expense</option>
                    <option value="2">Income</option>
                    <option value="3">Current Asset</option>
                    <option value="4">Fixed Asset</option>
                    <option value="5">Current Liability</option>
                    <option value="6">Long Term Liability</option>
                    <option value="7">Equity</option>
                    <option value="8">Non-Operating Income</option>
                    <option value="9">Non-Operating Expense</option>
                  </select>     
                </div>
              </div>  
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="reset" class="btn btn-default" value="Reset">
                  <button type="submit" data-section="accounts" class="btn btn-info pull-right">Save</button>
                </div>
              </div> 
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  