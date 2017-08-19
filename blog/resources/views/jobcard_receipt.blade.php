@extends('admin_template')
@section('content')
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
    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#receipt">Add Receipt</button>
    <br />
    <br />
  </div>
    <table class="m-item table table-striped">
      <tr class="t-head">
        <th>Receipt Code</th>
        <th>Customer</th>
        <th>Customer Invoice Code</th>
        <th>Payment Type</th>
        <th>Invoice Date</th>
        <th>Received</th>
        <th>Document</th>
        <th>Actions</th>
      </tr>
      @foreach($receipts as $receipt)
        <tr>
          <td><?= sprintf("RC%'05d\n", $receipt->receiptID); ?></td>
          <td>
            @if(App\Model\RentalOwner::find($receipt->customerID) && $receipt->customerID != 0)
              {{App\Model\RentalOwner::find($receipt->customerID)->firstName}}
            @endif
          </td>
          <td>{{$receipt->invoiceSystemCode}}</td>
          <td>
            @if(App\Model\PaymentType::find($receipt->paymentTypeID) && $receipt->paymentTypeID != 0)
              {{App\Model\PaymentType::find($receipt->paymentTypeID)->paymentDescription}}
            @endif
          </td>
          <td>{{$receipt->customerInvoiceDate}}</td>
          <td><?= number_format((float)$receipt->receiptAmount, 3, '.', '') ?></td>
          <td>
            <a href="/jobcard/edit/receipt/{{$receipt->receiptID}}/pdf" class="btn btn-info"><i class="fa fa-file-text" aria-hidden="true"></i> PDF</a>
          </td>
          <td>
            <form class="delete-form" action="/receipt/{{$receipt->receiptID}}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <a href="#" class="delete-btn btn btn-danger btn-sm button--winona">
                <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                <span class="after">Sure?</span>
              </a>
            </form>
          </td>
        </tr>
      @endforeach
    </table>

    <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="box box-info">
            <div class="box-body">
              <form method="POST" action="/jobcard/receipt">            
                <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}" >
                {{ csrf_field() }}

                 <div class="form-group clearfix">
                  <label class="col-sm-3 control-label">Select Customer</label>
                  <div class="col-sm-9">
                    <select class="form-control customer-field" readonly name="customerID">
                      @if($customer)
                        <option value="{{$customer->rentalOwnerID}}" selected="selected">{{$customer->firstName}}</option>
                      @endif
                    </select>
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-3 control-label">Select Invoice</label>
                  <div class="col-sm-9">
                    <select class="form-control invoice-field" name="invoiceID">
                      <option value="">Select Invoice</option>
                      @if($invoices)
                        @foreach($invoices as $invoice)
                          <option value="{{$invoice->customerInvoiceID}}">{{$invoice->CustomerInvoiceSystemCode}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-3 control-label">Enter Amount</label>
                  <div class="col-sm-9">
                    <input type="text" name="receiptAmount" class="form-control">
                  </div>
                </div>              
                <div class="form-group clearfix">
                  <label class="col-sm-3 control-label">Payment Type</label>
                  <div class="col-sm-9">
                    <select class="form-control payemnt-type-field" name="paymentTypeID">
                      @foreach($paymentTypes as $type)
                        <option value="{{$type->paymentTypeID}}">{{$type->paymentDescription}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="box-footer">
                  <div class="form-buttons">
                    <input type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" value="Cancel" />
                    <input type="submit" class="btn btn-info pull-right" value="Save" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

@endsection
@push('scripts')
  <script>
    // Rental owner field is disabled so no changed event will fire delete code 
    // $('.customer-field').on('change', function(){
    //   $.ajax({
    //     url: "/jobcard/edit/maintenance/{{$jobcard->jobcardID}}/receipt/"+$(this).val()+"",
    //     context: document.body,
    //     method: 'POST',
    //     headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    //   })
    //   .done(function(data) {
    //     $('.invoice-field').html(function(){
    //       // Generate the seletect list
    //       var output = '<select class="form-control invoice-field" name="invoiceID">';
    //       output += '<option value="'+0+'">'+'Select Invoice'+'</option>';
    //       data.forEach(function( index, element ){
    //         output += '<option value="'+data[element].customerInvoiceID+'">'+data[element].CustomerInvoiceSystemCode+'</option>';
    //       });
    //       output += '</select>';
    //       return output;
    //     });        
    //   });
    // });
    $('.invoice-field').on('change', function(){
      $.ajax({
        url: "/jobcard/edit/maintenance/{{$jobcard->jobcardID}}/receipt/"+$(this).val()+"/amount",
        context: document.body,
        method: 'POST',
        headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
      })
      .done(function(data) {
        $('.invoice-field').closest('.form-group').after(function(){
          console.log(data); 
          return `<div class="form-group clearfix">
                    <label class="col-sm-3 control-label">Amount Recievable</label>
                    <div class="col-sm-9">
                      <input type="text" name="customerInvoiceAmount" readonly class="form-control" value="${data}">
                    </div>
                  </div>`;
        });        
      });
    });
    $('.modal form').on('submit', function(e){
      var dueAmount = parseFloat($('[name="customerInvoiceAmount"]').val());
      var received = parseFloat($('[name="receiptAmount"]').val());
      if(received > dueAmount){
        e.preventDefault();
        alert('Cannot receive more that due amount: '+dueAmount);
      }
    });
  </script>
@endpush