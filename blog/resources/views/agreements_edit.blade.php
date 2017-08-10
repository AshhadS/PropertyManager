@extends('admin_template')

@section('content')
<section class="content-header">
      <h4><b>Agreement</b></h4>
  </section>
  <br /><br />
    
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
    <li role="presentation"><a href="#financials" aria-controls="financials" role="tab" data-toggle="tab">Financials</a></li>
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

                        {!! Form::select('PropertiesID', $propertylist, $agreement->PropertiesID ,['class' => 'col-sm-10 form-control']) !!}
                    </div>
                </div>
                
                <br></br>

                <div class="form-group">

                    {!! Form::label('tenantID', 'Tenant', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('tenantsID', $tenantlist, $agreement->tenantID ,['class' => 'col-sm-10 form-control']) !!}
                    </div>
                </div>

                <br></br>

                <div class="form-group">

                    {!! Form::label('UnunitIDit', 'Unit', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('unitID', $unitlist, $agreement->unitID ,['class' => 'col-sm-10 form-control']) !!}
                    </div>
                </div>

                <br></br>

                <div class="form-group">
                    {!! Form::label('actualRent', 'Actual Rent', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('actualRent', $agreement->actualRent, ['class' => 'col-sm-10 form-control']) !!}
                    </div>
                </div>

                <br></br>

                <div class="form-group">
                    {!! Form::label('marketRent', 'Market Rent', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('marketRent', $agreement->marketRent, ['class' => 'col-sm-10 form-control']) !!}
                    </div>
                </div>

                <br></br>


                <div class="form-group">

                    {!! Form::label('dateFrom', 'Agreement Start Date', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">

                        
                        {!! Form::text('dateFrom', $startDate, array('id' => 'datepicker','class' => 'col-sm-10 form-control') ) !!}
                        
                    </div>
                </div>

                <br></br>

                <div class="form-group">

                    {!! Form::label('dateTo', 'Agreement End Date', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                       {!! Form::text('dateTo', $endDate, array('id' => 'datepicker2','class' => 'col-sm-10 form-control') ) !!}
                        
                    </div>
                </div>

                <br></br>

                <div class="form-group">

                    {!! Form::label('paymentTypeID', 'Payment Type', ['class' => 'text-right col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('paymentTypeID', $paymenttypelist, $agreement->paymentTypeID ,['class' => 'col-sm-10 form-control']) !!}
                        
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
        </div>
    </div>
</div>



<div role="tabpanel" class="tab-pane" id="financials">
     <div class="row">
        <div class="col-md-12">
            <div class="">

            <h1> TBA</h1>
            </div>
        </div>
    </div>
</div>
</div>

@stop


@push('txtDatepickerScript')

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
  });

</script>


@endpush