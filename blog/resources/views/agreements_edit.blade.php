@extends('admin_template')

@section('content')
<meta name="_token_del" content="{{ csrf_token() }}">
<title>IDSS | Agreement</title>
<section class="content-header">
      <h4><b>Agreement</b></h4>
  </section>
  <br /><br />
  
    
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#financials" aria-controls="financials" role="tab" data-toggle="tab">Financials</a></li>
    <li role="presentation"><a href="#receipts" aria-controls="receipts" role="tab" data-toggle="tab">Receipt</a></li>
    <li role="presentation"><a href="#payments" aria-controls="payments" role="tab" data-toggle="tab">Payments</a></li>
  </ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="edit">
        <div class="row">
            <div class="col-md-12 pull-right">
                <div class=""> 
                  {!! Form::model($agreement, [
                    'method' => 'patch',
                    'action' => ['AgreementsController@update', $agreement->agreementID]
                    ]) !!}
                    <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('PropertiesID', 'Property', ['class' => 'text-right col-sm-2 control-label']) !!} 
                        <div class="col-sm-10">
                            {!! Form::select('PropertiesID', $propertylist, $agreement->PropertiesID ,['class' => 'input-req col-sm-10 form-control selection-parent-item']) !!}
                        </div>
                    </div>
                    <br></br>
                    <div class="form-group">
                        {!! Form::label('tenantID', 'Tenant', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('tenantsID', $tenantlist, $agreement->tenantID ,['class' => 'input-req col-sm-10 form-control']) !!}
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('UnunitIDit', 'Unit', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('unitID', $unitlist, $agreement->unitID ,['class' => 'input-req col-sm-10 form-control selection-child-item edit']) !!}
                            <p class="no-units">No units belonging to this property</p>
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('actualRent', 'Rent Cost', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('actualRent', $agreement->actualRent, ['class' => 'input-req col-sm-10 form-control']) !!}
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('marketRent', 'Rent Amount', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('marketRent', $agreement->marketRent, ['class' => 'input-req col-sm-10 form-control']) !!}
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('dateFrom', 'Agreement Start Date', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('dateFrom', $startDate, array('id' => 'datepicker','class' => 'input-req col-sm-10 form-control') ) !!}
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('dateTo', 'Agreement End Date', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                           {!! Form::text('dateTo', $endDate, array('id' => 'datepicker2','class' => 'input-req col-sm-10 form-control') ) !!}
                        </div>
                    </div>

                    <br></br>
                    <div class="form-group">
                        {!! Form::label('paymentTypeID', 'Payment Type', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('paymentTypeID', $paymenttypelist, $agreement->paymentTypeID ,['class' => 'input-req col-sm-10 form-control']) !!}
                        </div>
                    </div>

                    <br></br>
                     <div class="form-group">
                        {!! Form::label('PDCYN', 'PDCYN', ['class' => 'text-right col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {{ Form::checkbox('pdcyn', 1, $agreement->isPDCYN, ['class' => 'col-sm-1 field']) }}
                        </div>
                    </div>

                    <br></br>
                </div>
                    <div class="box-footer">
                        <div class="form-buttons">
                            {!! Form::submit('Save', ['class' => 'btn  bg-green pull-right']) !!}
                            {!! Form::reset('Reset', ['class' => 'btn btn-default ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>  
                <hr />
                <!-- <a href="/agreement/submit/{{$agreement->agreementID}}" class="pull-right btn btn-primary">Submit</a> -->
                <div class="container-fluid">
                  <div class="row">
                    <div class="button-group pull-right">
                      <form method="POST" class="confirm-submit" action="/agreement/submit/{{$agreement->agreementID}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="agreementID" value="{{$agreement->agreementID}}">
                        <input type="hidden" name="flag" value="{{$agreement->isSubmitted}}">
                        @if($agreement->isSubmitted == 1)
                          <input class="btn btn-primary" type="submit" value="Reverse">
                        @else
                          <input class="btn btn-primary" type="submit" value="Submit">
                        @endif
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="financials">
        <div class="row">
            <div class="col-md-12">
            <h4><b>TBA</b></h4>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="receipts">
        @component('includes/receipts', [
        'agreement' => $agreement,
         'receipts' => $receipts,
         'customers' => $customers,
         'paymentTypes' => $paymentTypes,
         'documentID' => 8,
         'documentAutoID' => $agreement->agreementID,
         'banks' => $banks,
         'accounts' => $accounts,
         ])
        @endcomponent       
    </div>
    <div role="tabpanel" class="tab-pane" id="payments">
        @component('includes/payments', [
        'agreement' => $agreement,
         'payments' => $payments,
         'customers' => $customers,
         'paymentTypes' => $paymentTypes,
         'documentID' => 8,
         'documentAutoID' => $agreement->agreementID,         
         'banks' => $banks,
         'accounts' => $accounts,
         ])
        @endcomponent    
    </div>
</div>

@stop


@push('scripts')

<script>

  $(function() {
    // $( "#datepicker" ).datepicker();
    
    var $datepicker = $('#datepicker');
    $datepicker.datepicker("option", "dateFormat", 'Y/d/m');

     var $datepicker2 = $('#datepicker2');
     $datepicker2.datepicker();
  //  $datepicker.datepicker( );
    // $datepicker.datepicker('setDate', new Date());
    // var date = new Date(document.getElementById("datepicker").data);
    // $datepicker.datepicker('setDate',date);

    // filter child selection on page load
      childSelection($('.selection-parent-item'));
      

      // $('.no-units').hide();
      // Load content based on previous selection
      $('.selection-parent-item').on('change', function(){
        childSelection(this)
      });

      function childSelection(elem){
        var prev_selection = $('.selection-child-item.edit').val();
        console.log(prev_selection); 
        if ($(elem).val() != 0) {
          $('.selection-child-item').show();
          $('.no-units').hide();
          $.ajax({
              url: "/jobcard/getunit/"+$(elem).val()+"",
              context: document.body,
              method: 'POST',
              headers : {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
          })
          .done(function(data) {
              // show message if no units for the selected property
              if(data.length){
                $('.selection-child-item').html(function(){
                    // Generate the seletect list
                    var output = '<select class="form-control selection-child-item" name="propertySubTypeID">';
                    output += '<option value="">Select a unit</option>';
                    data.forEach(function( index, element ){
                        if(prev_selection == data[element].unitID){
                          output += '<option value="'+data[element].unitID+'" selected="selected">'+data[element].unitNumber+'</option>';
                        }else{
                          output += '<option value="'+data[element].unitID+'">'+data[element].unitNumber+'</option>';
                        }
                    });
                    output += '</select>';
                    return output;
                });
              }else{
                $('.selection-child-item').hide();
                $('.no-units').show();
              }         
          });
        }else{
          $('.selection-child-item').hide();
          $('.no-units').show();
        }      

      }

      
      $('#agreement-editModal').modal({ show: false})
  });

</script>


@endpush