@extends('admin_template')
@section('content')
<title>IBSS | Jobcard Payment</title>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
            <a href="/jobcard/edit/{{$jobcard->jobcardID}}" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i> Back To Jobcard</a>
          <h2> 
            <i class="fa fa-briefcase" aria-hidden="true"></i> Jobcard 
          @if($jobcard->jobCardCode)
          -   {{$jobcard->jobCardCode}}
          @endif
          </h2>

        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <h2 class='conrol-label'>{{ $jobcard->subject}}</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- Button trigger modal -->
  <div class="col-md-12">
    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#payment">Add Payment</button>
    <br />
    <br />
  </div>

  <table class="m-item table table-striped">
    <tr class="t-head"> 
      <th>Payment Code</th>
      <th>Supplier</th>
      <th>Invoice Number</th>
      <th>Invoice Date</th>
      <th>Amount</th>
      <th>Payment Type</th>
      <th>Payment Date</th>
      <th>Submitted</th>
      <th>Actions</th>
    </tr>
    @foreach($payments as $payment)
      <tr>
        <td><?= sprintf("SPV%'05d\n", $payment->paymentID); ?></td>
        <td>
          @if(App\Model\Supplier::find($payment->supplierID) && $payment->supplierID != 0)
            {{App\Model\Supplier::find($payment->supplierID)->supplierName}}
          @endif
        </td>
        <td>{{$payment->invoiceSystemCode}}</td>
        <td>{{$payment->SupplierInvoiceDate}}</td>
        <td><?= number_format((float)$payment->paymentAmount, 3, '.', '') ?></td>
        <td>
          @if(App\Model\PaymentType::find($payment->paymentTypeID) && $payment->paymentTypeID != 0)
            {{App\Model\PaymentType::find($payment->paymentTypeID)->paymentDescription}}
          @endif
        </td>
        <td>{{$payment->paymentDate}}</td>
        <td class="center-parent"> 
          @if ($payment->submittedYN == 0)
            <span class="simple-box red"></span>
          @else
            <span class="simple-box green"></span>
          @endif
        </td>  
        <td class="edit-button">
          <div class="inner wide">
            <a href="/jobcard/edit/payment/{{$payment->paymentID}}/pdf" data-toggle="tooltip" title="PDF" class="btn btn-info btn-sm"><i class="fa fa-file-text" aria-hidden="true"></i> </a>
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
            <form class="delete-form" action="/payment/{{$payment->paymentID}}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <a href="#" class="delete-btn btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                <span class="after">Sure?</span>
              </a>
            </form>
          </div>
        </td>
      </tr>
    @endforeach
  </table>





  <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="box box-info">
          <div class="box-body">
            <form method="POST" action="/jobcard/payment">            
              <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}" >
              {{ csrf_field() }}
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Select Supplier</label>
                <div class="col-sm-9">
                  <select class="form-control supplier-field" name="supplierID">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                      <option value="{{$supplier->supplierID}}">{{$supplier->supplierName}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Select Invoice</label>
                <div class="col-sm-9">
                  <select class="form-control invoice-field" name="invoiceID">
                    <option value="">Select Invoice</option>
                  </select>
                </div>
              </div>
              <div class="invoice-amount-section">
                
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Enter Amount</label>
                <div class="col-sm-9">
                  <input type="text" name="paymentAmount" class="form-control">
                </div>
              </div>              
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Payemnt Type</label>
                <div class="col-sm-9">
                  <select class="form-control payemnt-type-field" name="paymentTypeID">
                    @foreach($paymentTypes as $type)
                      <option value="{{$type->paymentTypeID}}">{{$type->paymentDescription}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group clearfix payment-number">
                <label class="col-sm-3 control-label">Cheque Number</label>
                <div class="col-sm-9">
                  <input name="chequeNumber" class="form-control" />                      
                </div>
              </div>
              <div class="form-group clearfix payment-date">
                <label class="col-sm-3 control-label">Cheque Date</label>
                <div class="col-sm-9">
                  <input name="chequeDate" class="form-control datepicker" />                      
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Payment Date</label>
                <div class="col-sm-9">
                  <input name="paymentDate" class="form-control datepicker" />                      
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Bank Name</label>
                <div class="col-sm-9">
                  <select class="form-control selection-parent-item-bank" name="bankmasterID">
                      <option value="0">Select Bank</option>
                    @foreach($banks as $bank)
                      <option value="{{$bank->bankmasterID}}">{{$bank->bankName}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-3 control-label">Account Number</label>
                <div class="col-sm-9">
                  <select class="form-control selection-child-item-account" name="bankAccountID">
                      <option value="0">Select Account</option>
                    @foreach($accounts as $account)
                      <option value="{{$account->bankAccountID}}">{{$account->accountNumber}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" value="Cancel" />
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

@endsection
@push('scripts')
  <script>
    $('.supplier-field').on('change', function(){
      $('.invoice-amount-section').html('');
      $.ajax({
        url: "/jobcard/edit/maintenance/payment/get-invoices",
        context: document.body,
        data: { 
          'jobcard': '{{$jobcard->jobcardID}}', 
          'supplier': $(this).val() 
        },
        method: 'POST',
        headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
      })
      .done(function(data) {
        $('.invoice-field').html(function(){
          // Generate the seletect list
          var output = '<select class="form-control invoice-field" name="invoiceID">';
            output += '<option value="'+0+'">'+'Select Invoice'+'</option>';
          data.forEach(function( index, element ){
            output += '<option value="'+data[element].supplierInvoiceID+'">'+data[element].invoiceSystemCode+'</option>';
          });
          output += '</select>';
          return output;
        });        
      });
    });
    $('.invoice-field').on('change', function(){
      $.ajax({
        url: "/jobcard/edit/maintenance/"+$(this).val()+"/amount",
        context: document.body,
        method: 'POST',
        headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
      })
      .done(function(data) {
        $('.invoice-amount-section').html(function(){
          return `<div class="form-group clearfix">
                    <label class="col-sm-3 control-label">Amount Payable</label>
                    <div class="col-sm-9">
                      <input type="text" name="supplierInvoiceAmount" readonly class="form-control" value="${data}">
                    </div>
                  </div>`;
        });        
      });
    });

      $('.modal form').on('submit', function(e){
        var payable = parseFloat($('[name="supplierInvoiceAmount"]').val()) ;
        var paid = parseFloat($('[name="paymentAmount"]').val());
        if(paid > payable){
          alert('cannot pay more that payable amount: '+payable);
          e.preventDefault();
        }
      });

      $('[name="paymentTypeID"]').on('change', function(){
        if($(this).val() == 3){
          $('.payment-number label').text('Bank Transfer Number');
          $('.payment-date label').text('Bank Transfer Date');
        }else{
          $('.payment-number label').text('Cheque Number');
          $('.payment-date label').text('Cheque Date');
        }
      });

      // $('.invoice-field').after()
  </script>
@endpush