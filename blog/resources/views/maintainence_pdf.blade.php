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
        <p class="m-title">Materials</p>
      
    <table class="m-item  table table-striped" cellspacing="0">
      <thead>
      </thead>
      <tbody>
        <tr class="t-head" cellspacing="0">
          <th class="amount-col">#</th>
          <th>GL Code</th>
          <th>Description</th>
          <th>Comments</th>
          <th>Supplier</th>
          <th class="amount-col">Cost</th>
          <th class="amount-col">Margin</th>
          <th class="amount-col">Total</th>
        </tr>
        @foreach($maintenanceItensMaterial as $index => $item)
          <tr class="maintenance-item">
            <td data-type-val="{{$item->itemType}}" data-itemid-val="{{$item->itemID}}" class="amount-col">{{++$index}}</td>
            <td data-glcode-val="{{$item->GLCode}}">{{$item->GLCode}}</td>
            <td data-description-val="{{$item->description}}">{{$item->description}}</td>
            <td data-comments-val="{{$item->comments}}">{{$item->comments}}</td>
            <td data-supplier-val="{{$item->supplierID}}">
            @if(App\Model\Supplier::find($item->supplierID) && $item->supplierID != 0)
               {{App\Model\Supplier::find($item->supplierID)->supplierName}}
            @endif
            </td>
            <td data-cost-val="{{$item->costAmount}}" class="amount-col">{{$item->costAmount}}</td>
            <td data-margin-val="{{$item->margin}}" class="amount-col">{{$item->margin}}</td>
            <td class="amount-col">{{$item-> totalAmount}}</td>
            
          </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    <br />
    <div class="row">
      <p class="m-title">Labour</p>
      <table class="m-item  table table-striped">
        <thead>
        </thead>
        <tbody>
          <tr class="t-head">
            <th class="amount-col">#</th>
            <th>GL Code</th>
            <th>Description</th>
            <th>Comments</th>
            <th>Supplier</th>
            <th class="amount-col">Cost</th>
            <th class="amount-col">Margin</th>
            <th class="amount-col">Total</th>
          </tr>

          @foreach($maintenanceItensLabour as $index => $item)
            <tr class="maintenance-item">
              <td data-type-val="{{$item->itemType}}" data-itemid-val="{{$item->itemID}}" class="amount-col">{{++$index}}</td>
              <td data-glcode-val="{{$item->GLCode}}">{{$item->GLCode}}</td>
              <td data-description-val="{{$item->description}}">{{$item->description}}</td>
              <td data-comments-val="{{$item->comments}}">{{$item->comments}}</td>
              <td data-supplier-val="{{$item->supplierID}}">
                @if(App\Model\Supplier::find($item->supplierID) && $item->supplierID != 0)
                   {{App\Model\Supplier::find($item->supplierID)->supplierName}}
                @endif
              </td>
              <td data-cost-val="{{$item->costAmount}}" class="amount-col">{{$item->costAmount}}</td>
              <td data-margin-val="{{$item->margin}}" class="amount-col">{{$item->margin}}</td>
              <td class="amount-col">{{$item-> totalAmount}}</td>
              
            </tr>
          @endforeach
        </tbody>
      </table>      
    </div>
    <br />
    <div class="row">
      <p class="m-title">Summary</p>
      <table class="m-item  table">
        <thead>
        </thead>
        <tbody>
          <tr class="success">
            <td><b>Total</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="total-cell amount-col">{{$maintenanceItensCostTotal}}</td>
            <td class="total-cell amount-col">{{$maintenanceItensProfit}}</td>
            <td class="total-cell amount-col">{{$maintenanceItensTotal}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
    </body>
