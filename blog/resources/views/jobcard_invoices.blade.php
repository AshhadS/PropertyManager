@extends('admin_template')
@section('content')
<title>IBSS | Jobcard Invoice</title>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
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
        <div class="col-md-12">
          <h2 class='conrol-label'>{{ $jobcard->subject}}</h2>
          <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#invoiceModal"><i class="fa fa-plus"></i> Add Invoice</button>
          <!-- <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Invoice</button> -->
        </div>
      </div>
    </div>
  </div>
      <div class="row">
        <div class="col-md-4">
          <h4><b>SUPPLIER</b></h4>
        </div>
      </div>
    
      <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog wide" role="document">
        <div class="modal-content">
          <div class="modal-body box box-info">
            <div class=""> 
            <!-- form start -->
            <form class="form-horizontal" id="maintenance-form" action="/custom/invoice" method="POST">
                {{ csrf_field() }}
              <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}">
              <input type="hidden" name="PropertiesID" value="{{$jobcard->PropertiesID}}">
              <input type="hidden" name="unitID" value="{{$jobcard->unitID}}">
              <div class="box-body">
                <div class="form-group">
                  <label name="supplierID" class="col-sm-2 control-label">Invoice Type</label>
                  <div class="col-sm-10">
                    <select class="form-control input-req" name="invoiceType">
                      <!-- <option value="">Select a type</option> -->
                      <option value="0">Supplier</option>
                      <option value="1">Customer</option>
                    </select>
                  </div>
                </div>

                <div class="form-group supplier">
                  <label name="supplierID" class="col-sm-2 control-label">Supplier</label>
                  <div class="col-sm-10">
                    <select class="form-control input-req" name="supplierID">
                            <option value="">Select a supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{$supplier->supplierID}}">{{ $supplier->supplierName }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group clearfix customer">
                  <label class="col-sm-2 control-label">Select Customer</label>
                  <div class="col-sm-10">
                    <select class="form-control customer-field" disabled name="customerID">
                      @if($customer)
                        <option value="{{$customer->rentalOwnerID}}" selected="selected">{{$customer->firstName}}</option>
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group invoice-code">
                  <label class="col-sm-2 control-label">Invoice Number</label>
                  <div class="col-sm-10">
                    <input type="text" name="supplierInvoiceCode" class="form-control" placeholder="Invoice Code">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Invoice Date</label>
                  <div class="col-sm-10">
                    <input type="text" name="invoiceDate" class="form-control datepicker" placeholder="Invoice Date">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="amount" class="form-control input-req" placeholder="Amount">
                  </div>
                </div>           
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="reset" class="btn btn-default" value="Reset" />
                  <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
          </div>
        </div>
      </div>
  </div> 
  
  <table class="m-item  table table-striped">
      <thead>
      </thead>
      <tbody> 
        <tr class="t-head">
          <th class="amount-col" style="width: 10px;">#</th>
          <th style="width: 140px;">Invoice System Code</th>
          <th>Supplier Name</th>
          <th style="width: 140px;">Invoice Number</th>
          <th>Invoice Date</th>
          <th  style="width: 100px;">Amount</th>
          <th style="width: 130px;">Payment Status</th>
          <th style="width: 70px;">Submitted</th>
          <th>Actions</th>
        </tr>
        @foreach($supplierInvoices as $index => $supplierInvoice)
          <tr class="maintenance-item">
            <td> {{++$index}} </td>
            <td> {{$supplierInvoice->invoiceSystemCode}} </td>
            <td data-supplier-val="{{$supplierInvoice->supplierID}}">
              @if(App\Model\Supplier::find($supplierInvoice->supplierID) && $supplierInvoice->supplierID != 0)
                 {{App\Model\Supplier::find($supplierInvoice->supplierID)->supplierName}}
              @endif
            </td>
            <td class="invoice-code"> {{$supplierInvoice->supplierInvoiceCode}} </td>
            <td class="invoice-date format-date"> {{$supplierInvoice->invoiceDate}} </td>
            <td><?= number_format((float)$supplierInvoice->amount, 3, '.', '') ?></td>
            <td> 
              @if ($supplierInvoice->paymentPaidYN == 0)
                Not Paid
              @elseif ($supplierInvoice->paymentPaidYN == 1)
                Partially Paid
              @else
                Fully Paid
              @endif
            </td > 
            <td class="center-parent"> 
              @if ($supplierInvoice->submittedYN == 0)
                <span class="simple-box red"></span>
              @else
                <span class="simple-box green"></span>
              @endif
            </td>         
            <td class="edit-button"> 
              <div class="inner wide">
                <a href="#" data-id="{{$supplierInvoice->supplierInvoiceID}}" data-toggle="tooltip" title="Edit" class="btn bg-yellow supplier-edit-invoice btn-sm pull-left" data-toggle="modal" data-target="#supplierModal"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                <a href="/invoice/{{$supplierInvoice->supplierInvoiceID}}/display" data-toggle="tooltip" title="PDF" class="btn btn-info btn-sm btn-second pull-left"><i class="fa fa-file-text" aria-hidden="true"></i> </a>
                <form class="delete-form confirm-submit" method="POST" action="/invoice/submit">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <input type="hidden" name="invoiceID" value="{{$supplierInvoice->supplierInvoiceID}}">
                  <input type="hidden" name="invoiceType" value="1">
                  <input type="hidden" name="flag" value="{{$supplierInvoice->submittedYN}}">
                  @if($supplierInvoice->submittedYN == 1)
                    <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Reverse" type="submit"><i class="fa fa-undo" aria-hidden="true"></i></button>
                  @else
                    <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Submit" type="submit" > <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                  @endif
                </form> 
                @if($supplierInvoice->manuallyAdded == '1')
                  <form class="delete-form pull-left" method="POST" action="/custom/invoice/delete">
                    <a href="#" class="delete-btn-rp btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                      <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                      <span class="after">Sure ?</span>
                    </a>
                    <input type="hidden" name="invoiceID" value="{{$supplierInvoice->supplierInvoiceID}}">
                    <input type="hidden" name="invoiceType" value="0">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                @endif
              </div>
              </td>            
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
        <th class="amount-col"  style="width: 10px;">#</th>
        <th  style="width: 140px;">Invoice System Code</th>
        <th>Customer Name</th>
        <th>Invoice Date</th>
        <th  style="width: 100px;">Amount</th>
        <th>Payment Status</th>
        <th style="width: 70px;">Submitted</th>
        <th>Actions</th>
      </tr>
      @foreach($customerInvoices as $index => $customerInvoice)
          <tr class="maintenance-item">
            <td> {{++$index}} </td>
            <td> {{$customerInvoice->CustomerInvoiceSystemCode}} </td>
            <td data-supplier-val="{{$customerInvoice->propertyOwnerID}}">
              @if(App\Model\Customer::find($customerInvoice->propertyOwnerID))
                 {{App\Model\Customer::find($customerInvoice->propertyOwnerID)->customerName}}
              @endif
            </td>
            <td class="invoice-date format-date"> {{$customerInvoice->invoiceDate}} </td>
            <td> <?= number_format((float)$customerInvoice->amount, 3, '.', '') ?></td>
            <td>
              @if ($customerInvoice->paymentReceivedYN == 0)
                Not Received
              @elseif ($customerInvoice->paymentReceivedYN == 1)
                Partially Received
              @else
                Fully Received
              @endif
            </td>    
            <td class="center-parent"> 
              @if ($supplierInvoice->submittedYN == 0)
                <span class="simple-box red"></span>
              @else
                <span class="simple-box green"></span>
              @endif
            </td>          
            <td class="edit-button"> 
              <div class="inner wide">
                <a href="#" data-id="{{$customerInvoice->customerInvoiceID}}" class="btn bg-yellow customer-edit-invoice btn-sm pull-left" data-toggle="modal" data-target="#clientModal"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                <a href="/customer/invoice/{{$customerInvoice->customerInvoiceID}}/display" class="btn btn-info btn-sm btn-second pull-left"><i class="fa fa-file-text" aria-hidden="true"></i> </a>
                <form class="delete-form confirm-submit" method="POST" action="/invoice/submit">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <input type="hidden" name="invoiceID" value="{{$customerInvoice->customerInvoiceID}}">
                  <input type="hidden" name="invoiceType" value="2">
                  <input type="hidden" name="flag" value="{{$customerInvoice->submittedYN}}">
                  @if($customerInvoice->submittedYN == 1)
                    <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Reverse" type="submit"><i class="fa fa-undo" aria-hidden="true"></i></button>
                  @else
                    <button class="btn bg-green btn-sm btn-second" data-toggle="tooltip" title="Submit" type="submit" > <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                  @endif
                </form> 
                @if($customerInvoice->manuallyAdded == '1')
                  <form class="delete-form pull-left" method="POST" action="/custom/invoice/delete">
                    <a href="#" class="delete-btn-rp btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                      <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                      <span class="after">Sure ?</span>
                    </a>
                    <input type="hidden" name="invoiceID" value="{{$customerInvoice->customerInvoiceID}}">
                    <input type="hidden" name="invoiceType" value="1">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                @endif
              </div>
             </td>            
          </tr>
        @endforeach
    </table>
</div>

<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box box-info">
        <div class="box-body">
          <form method="POST" action="/update/customer-invoice">            
            <input type="hidden" name="customerInvoiceID" >
            {{ csrf_field() }}
            <div class="form-group clearfix">
              <label class="col-sm-2 control-label">Invoice Date</label>
              <div class="col-sm-10">
                <input type="text" name="invoiceDate" class="form-control datepicker" placeholder="Invoice Date">
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
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="box box-info">
        <div class="box-body">
          <form method="POST" action="/update/supplier-invoice">            
            <input type="hidden" name="supplierInvoiceID" >
            {{ csrf_field() }}
            <div class="form-group clearfix">
              <label class="col-sm-2 control-label">Invoice Date</label>
              <div class="col-sm-10">
                <input type="text" name="invoiceDate" class="form-control datepicker" placeholder="Invoice Date">
              </div>
            </div>
            <div class="form-group clearfix">
              <label class="col-sm-2 control-label">Invoice Code</label>
              <div class="col-sm-10">
                <input type="text" name="supplierInvoiceCode" class="form-control" placeholder="Code Enterable by the system">
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
@endsection
@push('scripts')
  <script>
    $(function() {
      $('.supplier-edit-invoice').on('click', function(){
        $('[name="invoiceDate"]').val($(this).closest('tr').find('.invoice-date').text());
        $('[name="supplierInvoiceCode"]').val($(this).closest('tr').find('.invoice-code').text());
        $('[name="supplierInvoiceID"]').val($(this).data('id'));

        // $('[name=" paymentPaidYN"]').val($(this).closest('tr').find('.paid'));

      });
      $('.customer-edit-invoice').on('click', function(){
        $('[name="invoiceDate"]').val($(this).closest('tr').find('.invoice-date').text());
        $('[name="customerInvoiceID"]').val($(this).data('id'));
      });


      $('.form-group.customer').hide();
      $('[name="invoiceType"]').on('change', function(){
        if($(this).val() == '0'){
          $('.form-group.supplier').show();
          $('.form-group.invoice-code').show();
          $('.form-group.customer').hide();

          $('.form-group.customer select').removeAttr('required');
          $('.form-group.supplier select').attr('required', true);
        }else{
          $('.form-group.customer').show();
          $('.form-group.invoice-code').hide();
          $('.form-group.supplier').hide();

          $('.form-group.supplier select').removeAttr('required');
          $('.form-group.customer select').attr('required', true);
        }
      });
    });

  </script>
@endpush