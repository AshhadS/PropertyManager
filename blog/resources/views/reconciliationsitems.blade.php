@extends('admin_template')
@section('content')
<title>IDSS | Reconciliation</title>
<meta name="_token_del" content="{{ csrf_token() }}">

<div class="panel panel-default give-space">
    <div class="panel-body">
      <div class="container-fluid">
        <div class="col-md-6">
          <div class="row">
            <h5 class="col-md-4 remove-margin">Bank : </h5><h5 class="col-md-8 remove-margin">{{App\Model\Bank::find($thisAccount->bankmasterID)->bankName}}</h5>
          </div>
          <div class="row">
            <h5 class="col-md-4 remove-margin">Account Number : </h5><h5 class="col-md-8 remove-margin">{{App\Model\BankAccount::find($thisAccount->bankAccountID)->accountNumber}}</h5>
          </div>
          <div class="row">
            <h5 class="col-md-4 remove-margin">Book Ballence : </h5><h5 class="col-md-8 remove-margin">0</h5>
          </div>
        </div>
      </div>
      <div class="page-header container-fluid">
        <div class="container-fluid">
          <section class="content-header pull-left">
              <h4><b>BANK RECONCILIATION</b></h4>
          </section>

        </div>
      </div>
      <h4><b>RECEIPTS</b></h4>
            <table class="table table-bordered table-hover table-striped" id="rentalowners-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Cheque Number</th> 
                      <th>Cheque Date</th>
                      <th>Amount</th>
                      <th>Narration</th>
                      <th>Cleared</th>
                      <th>Cleared Amount</th>
                    </tr>
                </thead>
                @foreach($receipts as $index => $receipt)
                  <tr>
                    <td>{{++$index}}</td>
                    <td>{{$receipt->chequeNumber}}</td>
                    <td>{{$receipt->chequeDate}}</td>
                    <td>{{$receipt->receiptAmount}}</td>
                    <td>[Narration]</td>
                    <td>
                      <form action="/reconciliation/clearcheque" method="POST">
                        <input type="hidden" name="id" value="{{$receipt->receiptID}}">
                        <input type="hidden" name="type" value="receipt">                          
                        <input type="checkbox" class="cleared-checkbox" value="{{$receipt->clearedYN}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                    <td>{{$receipt->clearedAmount}}</td>                       
                  </tr>
                @endforeach
                    

                       
            </table>
            <br>
            <br>
            <h4><b>PAYMENTS</b></h4>
            <table class="table table-bordered table-hover table-striped" id="rentalowners-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Cheque Number</th> 
                      <th>Cheque Date</th>
                      <th>Amount</th>
                      <th>Narration</th>
                      <th>Cleared</th>
                      <th>Cleared Amount</th>
                    </tr>
                </thead>
                @foreach($payments as $index => $payment)
                  <tr>
                    <td>{{++$index}}</td>
                    <td>{{$payment->chequeNumber}}</td>
                    <td>{{$payment->chequeDate}}</td>
                    <td>{{$payment->paymentAmount}}</td>
                    <td>[Narration]</td>
                    <td>
                      <form action="/reconciliation/clearcheque" method="POST">
                        <input type="hidden" name="id" value="{{$payment->paymentID}}">
                        <input type="hidden" name="type" value="payment">                          
                        <input type="checkbox" class="cleared-checkbox" value="{{$receipt->clearedYN}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                    <td>{{$payment->clearedAmount}}</td>                       
                  </tr>
                @endforeach
                    

                       
            </table>

            <button type="submit" class="pull-right btn btn-primary submit-reconcillation">Submit</button>
    </div>
</div>

@endsection
@push('scripts')
<script>
  $(function() {    

    $('.submit-reconcillation').on('click', function(){      
      $('.cleared-checkbox').each(function(){
        if($(this).is(':checked')){
          clearCheque($(this).closest('form'));
        }
      });
      window.location.reload();
    });
  });

  function clearCheque(form){
    $.ajax({
      url : '/reconciliation/clearcheque',
      type: "POST",
      async: false,
      data: $(form).serialize(),
      success: function (data) {
        if(data == 'true'){
          return true;
        }
      },
      error: function (jXHR, textStatus, errorThrown) {
          console.info(errorThrown);
      }
    });
  }
</script>
@endpush