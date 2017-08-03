<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Jobcard_maintenance_{{ $jobcard->jobcardID}}</title>
        <link href="{{ asset("/css/pdf-print.css")}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
    	
<div class="container-fluid">
	<div class="row">
	<table class="header-section">
		<tr>
			<td><h2><img src="{{ asset("/images/logosml.jpg") }}" /></h2></td>
			<td class="remove-child-margins">
				<h4>{{$company->companyName}}</h4>
				<br />
				<p>{{$company->address}}</p>
				<p>{{$company->city}}</p>
				<p>Tel: {{$company->telephoneNumber}}</p>
				<p>Fax: {{$company->faxNumber}}</p>
			</td>
		</tr>
	</table>
		
		<br />
		<hr>
	</div>

  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
      	<h2> 
      		{{ $jobcard->subject}}
	        @if($jobcard->jobCardCode)
	        |   {{$jobcard->jobCardCode}}
	        @endif
        </h2>

      </div>
    </div>

    <div class="row">
      <p class="m-title">
          @if(App\Model\RentalOwner::find($customerInvoice->propertyOwnerID) && $customerInvoice->propertyOwnerID != 0)
                 {{App\Model\RentalOwner::find($customerInvoice->propertyOwnerID)->firstName}} {{App\Model\RentalOwner::find($customerInvoice->propertyOwnerID)->lastName}}
              @endif
        </p>

      

      <div class="table">
            <div class="table-row head">
              <div class="table-col small"><b>#</b></div>
              <div class="table-col"><b>Suplier</b></div>
              <div class="table-col wide"><b>Description</b></div>
              <div class="table-col small"><b>Units</b></div>
              <div class="table-col small"><b>Cost</b></div>
              <div class="table-col small"><b>Total</b></div>
            </div>
          @foreach($items as $index => $item)
            <div class="table-row">
              <div class="table-col small">{{++$index}}</div>
              <div class="table-col">
                @if(App\Model\Supplier::find($item->supplierID) && $item->supplierID != 0)
                   {{App\Model\Supplier::find($item->supplierID)->supplierName}}
                @endif
              </div>
              <div class="table-col wide">{{$item->description}}</div>
              <div class="table-col small">{{$item->units}}</div>
              <div class="table-col small">{{$item->cost*( 1 + $item->margin/100)}}</div>
              <div class="table-col small">{{$item->netTotal}}</div>
            </div>
          @endforeach
            <div class="table-row total">
              <div class="table-col wide">Grand Total</div>
              <div class="table-col"> </div>
              <div class="table-col small"></div>
              <div class="table-col small"></div>
              <div class="table-col small"></div>
              <div class="table-col small">{{$customerInvoice->amount}}</div>
            </div>
        </div>
    </div>


    
    </div>
  </div>
</div>
    </body>
