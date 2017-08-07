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
  <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#payment">Add Payment</button>

  <table class="m-item table table-striped">
    <tr class="t-head">
      <th>Payment Code</th>
      <th>Supplier</th>
      <th>Payment Type</th>
      <th>Invoice Date</th>
      <th>Paid</th>
    </tr>
    @foreach($payments as $payment)
      <tr>
        <th>{{$payment->invoiceSystemCode}}</th>
        <th>
          @if(App\Model\Supplier::find($payment->supplierID) && $payment->supplierID != 0)
            {{App\Model\Supplier::find($payment->supplierID)->supplierName}}
          @endif
        </th>
        <th>
          @if(App\Model\PaymentType::find($payment->paymentTypeID) && $payment->paymentTypeID != 0)
            {{App\Model\PaymentType::find($payment->paymentTypeID)->paymentDescription}}
          @endif
        </th>
        <th>{{$payment->SupplierInvoiceDate}}</th>
        <th>{{$payment->paymentAmount}}</th>
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
                <label class="col-sm-2 control-label">Select Supplier</label>
                <div class="col-sm-10">
                  <select class="form-control supplier-field" name="supplierID">
                    <option value="0">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                      <option value="{{$supplier->supplierID}}">{{$supplier->supplierName}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-2 control-label">Select Invoice</label>
                <div class="col-sm-10">
                  <select class="form-control invoice-field" name="invoiceID">
                    <option value="0">Select Invoice</option>
                  </select>
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="col-sm-2 control-label">Enter Amount</label>
                <div class="col-sm-10">
                  <input type="text" name="paymentAmount" class="form-control">
                </div>
              </div>              
              <div class="form-group clearfix">
                <label class="col-sm-2 control-label">Payemnt Type</label>
                <div class="col-sm-10">
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

@endsection
@push('scripts')
  <script>
    $('.supplier-field').on('change', function(){
      $.ajax({
        url: "/jobcard/edit/maintenance/"+$(this).val()+"",
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
        $('.invoice-field').closest('.form-group').after(function(){
          console.log(data); 
          return `<div class="form-group clearfix">
                    <label class="col-sm-2 control-label">Amount Payable</label>
                    <div class="col-sm-10">
                      <input type="text" name="supplierInvoiceAmount" readonly class="form-control" value="${data}">
                    </div>
                  </div>`;
        });        
      });
    });

      // $('.invoice-field').after()
  </script>
@endpush