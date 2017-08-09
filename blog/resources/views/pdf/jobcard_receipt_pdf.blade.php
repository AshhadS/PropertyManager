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

        <div class="frame">
          <h3> Invoice Code: {{$receipt->invoiceSystemCode}} </h3>
          <h3> Invoice Date: {{$receipt->customerInvoiceDate}} </h3>
          <h3> Paid By <?php ($receipt->paymentTypeID == 1) ? print "Cash" : print "Cheque"; ?> </h3>
          <h3> Invoice Amount: {{$receipt->customerInvoiceAmount}} </h3>
          <h3> Received Amount: {{$receipt->receiptAmount}} </h3>
          <p>_________________________</p>
          <h3> Ballence Amount: {{$receipt->customerInvoiceAmount - $receipt->receiptAmount}} </h3>
        </div>
      </div>
    </div>

   
  </div>
</div>
    </body>
