<div class="container-fluid">
  <div class="col-md-12">
    <h4><b>PAYMENTS</b></h4>
    <div class="container-fluid">
      <button type="button" class="btn btn-primary pull-right add-btn <?php ($agreement->isSubmitted == 0) ? print 'disabled' : false ?>" <?php ($agreement->isSubmitted == 0) ? print 'disabled' : false ?> data-toggle="modal" data-target="#payment">
      <i class="fa fa-plus"></i> <b>Add Item</b>
      </button>
    </div>
    <table class="m-item table table-striped">
      <tbody>
        <tr class="t-head">
          <th>#</th>
          <th>Payment Code</th>
          <th>Description</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Cheque Number</th>
          <th>Cheque Date</th>
          <th>Payment Date</th>
          <th>Actions</th>
        </tr>
        @foreach($payments as $index => $payment)
        <tr>
          <td class="id" data-bank="{{$payment->bankmasterID}}" data-account="{{$payment->bankAccountID}}" data-val="{{$payment->paymentID}}">{{++$index}}</td>
          <td><?= sprintf("SPV%'05d\n", $payment->paymentID); ?></td>
          <td>
            @if(App\Model\Property::find($agreement->PropertiesID) && $agreement->PropertiesID != 0)
            For Property {{App\Model\Property::find($agreement->PropertiesID)->pPropertyName}}
            @endif
          </td>
          <td class="type" data-val="{{($payment->paymentTypeID)}}"> {{($payment->paymentTypeID) == 1 ? "Cash" : "Cheque"}} </td>
          <td class="amount">{{$payment->paymentAmount}}</td>
          <td class="chequeNumber">{{$payment->chequeNumber}}</td>
          <td class="chequeDate format-date">{{$payment->chequeDate}}</td>
          <td class="paymentDate format-date">{{$payment->paymentDate}}</td>
          <td class="edit-button">
            <div class="inner wide">
              <a class="btn bg-green btn-sm pull-left payment-edit" data-toggle="tooltip" title="Edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
              <form class="delete-form confirm-submit" method="POST" action="/submit/payment">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="paymentID" value="{{$payment->paymentID}}">
                <input type="hidden" name="flag" value="{{$payment->submittedYN}}">
                @if($payment->submittedYN == 1)
                  <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Reverse" type="submit"><i class="fa fa-undo" aria-hidden="true"></i></button>
                @else
                  <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Submit" type="submit" > <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                @endif
              </form> 
              <form class="delete-form pull-left  " method="POST" action="/custom/payment/{{$payment->paymentID}}">
                <a href="#" class="delete-btn-rp btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                  <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                  <span class="after">Sure ?</span>
                </a>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wide" role="document">
      <div class="modal-content">
        <div class="modal-body box box-info">
          <div class="">
            <form class="form-horizontal" id="payment-form" action="/custom/payment" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="documentID" value="{{$documentID}}">
              <input type="hidden" name="documentAutoID" value="{{$documentAutoID}}">
              <input type="hidden" name="paymentID">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" class="form-control input-req" placeholder="Amount">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Payment Type</label>
                  <div class="col-sm-10">
                    <select name="paymentTypeID" class="form-control">
                      <option value="1">Cash</option>
                      <option value="2">Cheque</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Cheque Number</label>
                  <div class="col-sm-10">
                    <input name="chequeNumber" class="form-control" />                      
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Cheque Date</label>
                  <div class="col-sm-10">
                    <input name="chequeDate" class="form-control datepicker" />                      
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Payment Date</label>
                  <div class="col-sm-10">
                    <input name="paymentDate" class="form-control datepicker input-req" />                      
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-2 control-label">Bank Name</label>
                  <div class="col-sm-10">
                    <select class="form-control selection-parent-item-bank edit input-req" name="bankmasterID">
                        <option value="0">Select Bank</option>
                      @foreach($banks as $bank)
                        <option value="{{$bank->bankmasterID}}">{{$bank->bankName}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-2 control-label">Account Number</label>
                  <div class="col-sm-10">
                    <select class="form-control selection-child-item-account edit" name="bankAccountID">
                        <option value="0">Select Account</option>
                      
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="reset" class="btn btn-default" value="Reset" />
                  <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
@push('scripts')
<script>
$(function() {
  $('.payment-edit').on('click', function(e){
    e.preventDefault();
    $('[name="chequeDate"]').val($(this).data('id'));
    $('[name="amount"]').val($(this).closest('tr').find('.amount').text());
    $('[name="paymentTypeID"] option[value="'+$(this).closest('tr').find('.type').data('val')+'"').attr('selected', 'selected');
    $('[name="chequeNumber"]').val($(this).closest('tr').find('.chequeNumber').text());
    $('[name="chequeDate"]').val($(this).closest('tr').find('.chequeDate').text());
    $('[name="paymentDate"]').val($(this).closest('tr').find('.paymentDate').text());
    $('[name="paymentID"]').val($(this).closest('tr').find('.id').data('val'));


    var bankID = $(this).closest('tr').find('.id').data('bank');
    if(bankID){
      $('[name="bankmasterID"] option[value="'+bankID+'"]').attr('selected', true);      
    } 

    // defined in custom js
    childSelection($('[name="bankmasterID'));


    var accountID = $(this).closest('tr').find('.id').data('account');
    if(accountID){
      $('[name="bankAccountID"]').show();
      $('[name="bankAccountID"] option[value="'+accountID+'"]').attr('selected', true);      
    }

    $('.form-horizontal').attr('action', '/update/custom/payment')
    $('#payment').modal('show');
  
  });

  $('#payment').on('hidden.bs.modal', function (e) {
    $('.form-horizontal').attr('action', '/custom/payment');
    document.getElementById("payment-form").reset();
    $('[selected="selected"]').attr('selected', false);
    $('[type="reset"]').trigger('click');

    $('[name="bankAccountID"]').html('<option value="0">Select Account</option>');
    $('[name="bankAccountID"]').hide();
  });

});


</script>
@endpush