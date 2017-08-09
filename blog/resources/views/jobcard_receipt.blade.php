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
        <th>Payment Type</th>
        <th>Invoice Date</th>
        <th>Received</th>
        <th>Document</th>
        <th>Actions</th>
      </tr>
      @foreach($receipts as $receipt)
        <tr>
          <td>{{$receipt->invoiceSystemCode}}</td>
          <td>
            @if(App\Model\RentalOwner::find($receipt->customerID) && $receipt->customerID != 0)
              {{App\Model\RentalOwner::find($receipt->customerID)->firstName}}
            @endif
          </td>
          <td>
            @if(App\Model\PaymentType::find($receipt->paymentTypeID) && $receipt->paymentTypeID != 0)
              {{App\Model\PaymentType::find($receipt->paymentTypeID)->paymentDescription}}
            @endif
          </td>
          <td>{{$receipt->customerInvoiceDate}}</td>
          <td>{{$receipt->receiptAmount}}</td>
          <td>
            <a href="/jobcard/edit/receipt/{{$receipt->receiptID}}/pdf" class="btn btn-info"><i class="fa fa-file-text" aria-hidden="true"></i> PDF</a>
          </td>
          <td>
            <form class="delete-form" action="/receipt/{{$receipt->receiptID}}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <a href="" class="delete-btn btn btn-danger btn-sm button--winona">
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
                    <select class="form-control customer-field" name="customerID">
                      <option value="0">Select Customer</option>
                      @foreach($customers as $customer)
                        <option value="{{$customer->rentalOwnerID}}">{{$customer->firstName}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group clearfix">
                  <label class="col-sm-3 control-label">Select Invoice</label>
                  <div class="col-sm-9">
                    <select class="form-control invoice-field" name="invoiceID">
                      <option value="0">Select Invoice</option>
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


</div>

@endsection
@push('scripts')
  <script>
    $('.customer-field').on('change', function(){
      $.ajax({
        url: "/jobcard/edit/maintenance/receipt/"+$(this).val()+"",
        context: document.body,
        method: 'POST',
        headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
      })
      .done(function(data) {
        $('.invoice-field').html(function(){
          // Generate the seletect list
          var output = '<select class="form-control invoice-field" name="invoiceID">';
          output += '<option value="'+0+'">'+'Select Invoice'+'</option>';
          data.forEach(function( index, element ){
            output += '<option value="'+data[element].customerInvoiceID+'">'+data[element].CustomerInvoiceSystemCode+'</option>';
          });
          output += '</select>';
          return output;
        });        
      });
    });
    $('.invoice-field').on('change', function(){
      $.ajax({
        url: "/jobcard/edit/maintenance/receipt/"+$(this).val()+"/amount",
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