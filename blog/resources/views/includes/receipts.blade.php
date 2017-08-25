<div class="container-fluid">
  <div class="col-md-12">
    <h4><b>RECEIPTS</b></h4>
    <div class="container-fluid">
      <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#receipt">
      <i class="fa fa-plus"></i> <b>Add Item</b>
      </button>
    </div>
    <table class="m-item table table-striped">
      <tbody>
        <tr class="t-head">
          <th>#</th>
          <th>Description</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Actions</th>
        </tr>
        @foreach($receipts as $index => $receipt)
        <tr>
          <td>{{++$index}}</td>
          <td>
            @if(App\Model\Property::find($agreement->PropertiesID) && $agreement->PropertiesID != 0)
            For Property {{App\Model\Property::find($agreement->PropertiesID)->pPropertyName}}
            @endif
          </td>
          <td> {{($receipt->paymentTypeID) ? "Cash" : "Cheque"}} </td>
          <td>{{$receipt->receiptAmount}}</td>
          <td class="edit-button">
            <a class="btn bg-green btn-sm pull-left" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</a>
            <form class="delete-form pull-left" method="POST" action="/custom/receipt/{{$receipt->receiptID}}">
              <a href="#" class="delete-btn btn btn-danger btn-sm button--winona">
                <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                <span class="after">Sure ?</span>
              </a>
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wide" role="document">
      <div class="modal-content">
        <div class="modal-body box box-info">
          <div class="">
            <form class="form-horizontal" action="/custom/receipt" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="documentID" value="{{$documentID}}">
              <input type="hidden" name="documentAutoID" value="{{$documentAutoID}}">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" name="cost" class="form-control" placeholder="Amount">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Payment Type</label>
                  <div class="col-sm-10">
                    <select name="paymentTypeID" class="form-control">
                      <option value="1">Cash</option>
                      <option value="2">Cheque</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="form-buttons">
                  <input type="reset" class="btn btn-default" value="Reset" />
                  <button type="submit" class="btn btn-info pull-right">Create</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
</script>
@endpush