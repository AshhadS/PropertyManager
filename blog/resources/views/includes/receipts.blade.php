<div class="container-fluid">
  <div class="col-md-12">
    <h4><b>RECEIPTS</b></h4>
    <div class="container-fluid">

      <button type="button" class="btn btn-primary pull-right add-btn <?php ($agreement->isSubmitted == 0) ? print 'disabled' : false ?>" <?php ($agreement->isSubmitted == 0) ? print 'disabled' : false ?> data-toggle="modal" data-target="#receipt">
      <i class="fa fa-plus"></i> <b>Add Item</b>
      </button>
    </div>
    <table class="m-item table table-striped">
      <tbody>
        <tr class="t-head">
          <th>#</th>
          <th>Receipt Code</th>
          <th>Description</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Cheque Number</th>
          <th>Cheque Date</th>
          <th>Receipt Date</th>
          <th>Actions</th>
        </tr>
        @foreach($receipts as $index => $receipt)
        <tr>
          <td class="id" data-bank="{{$receipt->bankmasterID}}" data-account="{{$receipt->bankAccountID}}" data-val="{{$receipt->receiptID}}">{{++$index}}</td>
          <td><?= sprintf("RC%'05d\n", $receipt->receiptID); ?></td>
          <td>
            @if(App\Model\Property::find($agreement->PropertiesID) && $agreement->PropertiesID != 0)
            For Property {{App\Model\Property::find($agreement->PropertiesID)->pPropertyName}}
            @endif
          </td>
          <td class="type" data-val="{{($receipt->paymentTypeID)}}"> {{($receipt->paymentTypeID) ? "Cash" : "Cheque"}} </td>
          <td class="amount">{{$receipt->receiptAmount}}</td>
          <td class="chequeNumber">{{$receipt->chequeNumber}}</td>
          <td class="chequeDate format-date">{{$receipt->chequeDate}}</td>
          <td class="receiptDate format-date">{{$receipt->receiptDate}}</td>
          <td class="edit-button">
            <a class="btn bg-green btn-sm pull-left receipt-edit" data-toggle="tooltip" title="Edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
            <form class="delete-form pull-left" method="POST" action="/custom/receipt/{{$receipt->receiptID}}">
              <a href="#" class="delete-btn btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                <span class="after">Sure ?</span>
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
  <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wide" role="document">
      <div class="modal-content">
        <div class="modal-body box box-info">
          <div class="">
            <form class="form-horizontal" id="receipt-form" action="/custom/receipt" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="documentID" value="{{$documentID}}">
              <input type="hidden" name="documentAutoID" value="{{$documentAutoID}}">
              <input type="hidden" name="receiptID">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" class="form-control" placeholder="Amount">
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
                  <label class="col-sm-2 control-label">Receipt Date</label>
                  <div class="col-sm-10">
                    <input name="receiptDate" class="form-control datepicker" />                      
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-2 control-label">Bank Name</label>
                  <div class="col-sm-10">
                    <select class="form-control selection-parent-item-bank edit" name="bankmasterID">
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
  $('.receipt-edit').on('click', function(e){
    e.preventDefault();
    $('[name="chequeDate"]').val($(this).data('id'));
    $('[name="amount"]').val($(this).closest('tr').find('.amount').text());
    $('[name="paymentTypeID"] option[value="'+$(this).closest('tr').find('.type').data('val')+'"').attr('selected', 'selected');
    $('[name="chequeNumber"]').val($(this).closest('tr').find('.chequeNumber').text());
    $('[name="chequeDate"]').val($(this).closest('tr').find('.chequeDate').text());
    $('[name="receiptDate"]').val($(this).closest('tr').find('.receiptDate').text());
    $('[name="receiptID"]').val($(this).closest('tr').find('.id').data('val'));

    var bankID = $(this).closest('tr').find('.id').data('bank');
    if(bankID){
      $('[name="bankmasterID"] option[value="'+bankID+'"]').attr('selected', true);      
    } 

    childSelection($('[name="bankmasterID'));

    var accountID = $(this).closest('tr').find('.id').data('account');
    if(accountID){
      $('[name="bankAccountID"] option[value="'+accountID+'"]').attr('selected', true);      
    }

    $('form').attr('action', '/update/custom/receipt');
    $('#receipt').modal('show');

  });

  $('#receipt').on('hidden.bs.modal', function (e) {
    $('form').attr('action', '/custom/receipt');
    document.getElementById("receipt-form").reset();

  });
});


function childSelection(elem){
    var prev_selection = $('.selection-child-item-account.edit').val();
    if ($(elem).val() != 0) {
      $('.selection-child-item-account').show();
      $('.no-units').hide();
      $.ajax({
          url: "/bank/getaccounts/"+$(elem).val()+"",
          context: document.body,
          method: 'POST',
          async: false,
          headers : {'X-CSRF-TOKEN': $('meta[name="_token_del"]').attr('content')}
      })
      .done(function(data) {
          // show message if no units for the selected property
          if(data.length){
            $('.selection-child-item-account').html(function(){
                // Generate the seletect list
                var output = '<select class="form-control selection-child-item" name="bankAccountID">';
                output += '<option value="">Select a account</option>';
                data.forEach(function( index, element ){
                    if(prev_selection == data[element].bankAccountID){
                      output += '<option value="'+data[element].bankAccountID+'" selected="selected">'+data[element].accountNumber+'</option>';
                    }else{
                      output += '<option value="'+data[element].bankAccountID+'">'+data[element].accountNumber+'</option>';
                    }
                });
                output += '</select>';
                return output;
            });
          }else{
            $('.selection-child-item-account').hide();
            $('.no-units').show();
          }         
      });
    }else{
      $('.selection-child-item-account').hide();
      $('.no-units').show();
    }      
}
</script>
@endpush