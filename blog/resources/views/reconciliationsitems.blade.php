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
                      <th>Customer</th>
                      <th>Docuemnt Code</th>
                      <th>Receipt Date</th>
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
                    <td class="format-date">{{$receipt->chequeDate}}</td>
                    <td>
                      @if(App\Model\Customer::find($receipt->customerID))
                        {{App\Model\Customer::find($receipt->customerID)->customerName}}
                      @endif
                    </td>
                    <td><?php 
                      $code = $receipt->documentAutoID;
                      print sprintf("REC%'05d\n", $code);
                     ?>
                    </td>
                    <td class="format-date">{{$receipt->receiptDate}}</td>
                    <td class="amount">{{$receipt->receiptAmount}}</td>
                    <td>[Narration]</td>
                    <td>
                      <form action="/reconciliation/clearcheque" method="POST">
                        <input type="hidden" name="id" value="{{$receipt->receiptID}}">
                        <input type="hidden" name="type" value="receipt">                          
                        <input type="checkbox" class="cleared-checkbox" <?php print ($receipt->clearedYN) ? 'checked' : '' ?> <?php print ($reconciliation->submittedYN) ? 'disabled' : '' ?>>
                        <input type="hidden" name="reconciliation" value="{{$reconciliation->bankReconciliationMasterID}}">                          
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                    <td class="clearedAmount">{{$receipt->clearedAmount}}</td>                       
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
                      <th>Supplier</th>
                      <th>Document Code</th>
                      <th>Payment Date</th>
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
                    <td class="format-date">{{$payment->chequeDate}}</td>
                    <td>
                      @if(App\Model\Supplier::find($payment->supplierID))
                        {{App\Model\Supplier::find($payment->supplierID)->supplierName}}
                      @endif
                    </td>
                    <td>
                      <?php 
                        $code = $payment->documentAutoID;
                        print sprintf("PA%'05d\n", $code);
                      ?>
                    </td>
                    <td class="format-date">{{$payment->paymentDate}}</td>
                    <td class="amount">{{$payment->paymentAmount}}</td>
                    <td>[Narration]</td>
                    <td>
                      <form action="/reconciliation/clearcheque" method="POST">
                        <input type="hidden" name="id" value="{{$payment->paymentID}}">
                        <input type="hidden" name="type" value="payment">                          
                        <input type="hidden" name="reconciliation" value="{{$reconciliation->bankReconciliationMasterID}}">                          
                        <input type="checkbox" class="cleared-checkbox" <?php print ($payment->clearedYN) ? 'checked' : '' ?> <?php print ($reconciliation->submittedYN) ? 'disabled' : '' ?> >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </form>
                    </td>
                    <td class="clearedAmount">{{$payment->clearedAmount}}</td>                       
                  </tr>
                @endforeach
                    

                       
            </table>

            @if($reconciliation->submittedYN != 1)
              <form action="/reconciliation/submit" method="POST">
                <input type="hidden" name="reconciliation" value="{{$reconciliation->bankReconciliationMasterID}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" v="{{$reconciliation->submittedYN}}" class="pull-right btn btn-primary submit-reconcillation">Submit</button>                
              </form>
            @endif
    </div>
</div>

@endsection
@push('scripts')
<script>
  $(function() {    

    // $('.submit-reconcillation').on('click', function(){      
    //   $('.cleared-checkbox').each(function(){
    //     if($(this).is(':checked')){
    //       clearCheque($(this).closest('form'));
    //     }
    //   });
    //   window.location.reload();
    // });


    $('.cleared-checkbox').change(function(){
        // this will contain a reference to the checkbox   
      clearCheque($(this).closest('form'));
      if (this.checked) {
          // the checkbox is now checked 
          var amount = $(this).closest('tr').find('.amount').text();
          $(this).closest('tr').find('.clearedAmount').text(amount);
      } else {
          // the checkbox is now no longer checked
          $(this).closest('tr').find('.clearedAmount').text('');      
      }
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