@extends('admin_template')
@section('content')
<div class="container-fluid">
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
    <div class="row">
        <h4><b>SUPPLIER</b></h4>
    </div>
  </div>

  
  <table class="m-item  table table-striped">
      <thead>
      </thead>
      <tbody>
        <tr class="t-head">
          <th class="amount-col">#</th>
          <th>Supplier</th>
          <th>Amount</th>
          <th>Invoice Date</th>
          <th>Payment Made</th>
          <th>Document</th>
        </tr>
        @foreach($supplierInvoices as $index => $supplierInvoice)
          <tr class="maintenance-item">
            <td> {{++$index}} </td>
            <td data-supplier-val="{{$supplierInvoice->supplierID}}">
              @if(App\Model\Supplier::find($supplierInvoice->supplierID) && $supplierInvoice->supplierID != 0)
                 {{App\Model\Supplier::find($supplierInvoice->supplierID)->supplierName}}
              @endif
            </td>
            <td> {{$supplierInvoice->amount}} </td>
            <td> {{$supplierInvoice->invoiceDate}} </td>
            <td> {{($supplierInvoice->paymentPaidYN) ? "Yes" : "No"}} </td>            
            <td> <a href="/invoice/{{$supplierInvoice->supplierInvoiceID}}/display" class="btn btn-info"><i class="fa fa-file-text" aria-hidden="true"></i> PDF</a></td>            
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-4">
        <h4><b>CLIENT</b></h4>
      </div>
    </div>
    <table class="m-item  table table-striped"  >
      <tr class="t-head">
        <th class="amount-col">#</th>
        <th>Property Owner</th>
        <th>Invoice Date</th>
        <th>Payment Recieved</th>
        <th>Amount</th>
        <th>Document</th>
      </tr>
      @foreach($customerInvoices as $index => $customerInvoice)
          <tr class="maintenance-item">
            <td> {{++$index}} </td>
            <td data-supplier-val="{{$customerInvoice->supplierID}}">
              @if(App\Model\RentalOwner::find($customerInvoice->propertyOwnerID) && $customerInvoice->propertyOwnerID != 0)
                 {{App\Model\RentalOwner::find($customerInvoice->propertyOwnerID)->firstName}} {{App\Model\RentalOwner::find($customerInvoice->propertyOwnerID)->lastName}}
              @endif
            </td>
            <td> {{$customerInvoice->invoiceDate}} </td>
            <td> {{($customerInvoice->paymentReceivedYN) ? "Yes" : "No"}} </td>            
            <td> {{$customerInvoice->amount}} </td>
            <td> <a href="/customer/invoice/{{$customerInvoice->customerInvoiceID}}/display" class="btn btn-info"><i class="fa fa-file-text" aria-hidden="true"></i> PDF</a></td>            
          </tr>
        @endforeach
    </table>

</div>
@endsection
@push('scripts')
  <script>
    $(function() {
     
    });

  </script>
@endpush