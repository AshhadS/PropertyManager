@extends('admin_template')
@section('content')
<title>IDSS | Reconciliation</title>

<div class="panel panel-default give-space">
    <div class="panel-body">
          <div class="container-fluid">
            <div class="col-md-6">
              <div class="row">
                <h5 class="col-md-4 remove-margin">Bank : </h5><h5 class="col-md-8 remove-margin">{{App\Model\Bank::find($thisAccount->bankmasterID)->bankName}}</h5>
              </div>
              <div class="row">
                <h5 class="col-md-4 remove-margin">Account Number : </h5><h5 class="col-md-8 remove-margin">{{App\Model\BankAccount::find($thisAccount->bankAccountID)->accountNumber}}</h5>
              </div>
              <div class="row">
                <h5 class="col-md-4 remove-margin">Book Ballence : </h5><h5 class="col-md-8 remove-margin">0</h5>
              </div>
            </div>
          </div>
      <div class="page-header container-fluid">
        <div class="container-fluid">
          <section class="content-header pull-left">
              <h4><b>BANK RECONCILIATION</b></h4>
          </section>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#reconciliation"><i class="fa fa-plus"></i> Add Reconciliation</button>
        </div>
      </div>
            <table class="table table-bordered table-hover table-striped" id="rentalowners-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Date</th> 
                      <th>Month</th>
                      <th>Year</th>
                      <th>Bank</th>
                      <th>Account</th>
                      <th>Narration</th>
                      <th>Submitted</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                    @foreach($reconciliaions as $index => $reconciliaion)
                      <tr>
                        <td> {{++$index}} </td>
                        <td> {{$reconciliaion->asOfDate}} </td>
                        <td> {{$reconciliaion->month}} </td>
                        <td> {{$reconciliaion->year}} </td>
                        <td>
                          @if(App\Model\Bank::find($reconciliaion->bankMasterID) && $reconciliaion->bankMasterID != 0)
                            {{App\Model\Bank::find($reconciliaion->bankMasterID)->bankName}}
                          @endif
                        </td>
                        <td>
                          @if(App\Model\BankAccount::find($reconciliaion->bankAccountID) && $reconciliaion->bankAccountID != 0)
                            {{App\Model\BankAccount::find($reconciliaion->bankAccountID)->accountNumber}}
                          @endif
                        </td>
                        <td> {{$reconciliaion->narration}} </td>
                        <td> {{$reconciliaion->submittedYN}} </td>
                        <td class="edit-button">
                          <a class="btn bg-green btn-sm pull-left" data-toggle="tooltip" title="" href="/reconciliation/{{$reconciliaion->bankReconciliationMasterID}}/items" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                          
                          <form class="delete-form pull-left" method="POST" action="/reconciliation/{{$reconciliaion->bankReconciliationMasterID}}">
                            <a href="#" class="delete-btn btn btn-danger btn-sm button--winona" data-toggle="tooltip" title="Delete">
                              <span><i class="fa fa-trash" aria-hidden="true"></i> </span>
                              <span class="after">Sure ?</span>
                            </a>
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          </form>
                        </td>
                      </tr>
                    @endforeach

                       
            </table>
    </div>
</div>

 <div class="modal fade" id="reconciliation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="box box-info">
            <div class="box-body">
              <form method="POST" action="/reconciliation">            
                <input type="hidden" name="bankMasterID" value="{{$thisAccount->bankmasterID}}" >
                <input type="hidden" name="bankAccountID" value="{{$thisAccount->bankAccountID}}" >
                {{ csrf_field() }}

                <div class="form-group clearfix payment-date">
                  <label class="col-sm-3 control-label">Date</label>
                  <div class="col-sm-9">
                    <input name="reconciliationDate" class="form-control datepicker" />                      
                  </div>
                </div>
               <div class="form-group  clearfix">
	              <label class="col-sm-3 control-label">Narration</label>
	              <div class="col-sm-9">
	                <textarea class="form-control" name="narration" rows="2" placeholder="Narration"></textarea>
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
@endsection
