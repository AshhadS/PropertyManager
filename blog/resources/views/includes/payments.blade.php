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
          <td class="id" data-val="{{$payment->paymentID}}">{{++$index}}</td>
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
            <a class="btn bg-green btn-sm pull-left payment-edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</a>
            <form class="delete-form pull-left  " method="POST" action="/custom/payment/{{$payment->paymentID}}">
              <a href="#" class="delete-btn btn btn-danger btn-sm button--winona">
                <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
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
                  <label class="col-sm-2 control-label">Payment Date</label>
                  <div class="col-sm-10">
                    <input name="paymentDate" class="form-control datepicker" />                      
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
    $('form').attr('action', '/update/custom/payment');


    $('#payment').modal('show');

  });

  $('#payment').on('hidden.bs.modal', function (e) {
    $('form').attr('action', '/custom/payment');
    document.getElementById("payment-form").reset();

  });
});
</script>
@endpush