@extends('admin_template')
@section('content')
<div class="container-fluid">
    <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wide" role="document">
      <div class="modal-content">
        <div class="modal-body box box-info">
          <div class=""> 
          <!-- form start -->
          <form class="form-horizontal" id="maintenance-form" action="/jobcard/edit/maintenance" method="POST">
              {{ csrf_field() }}
            <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}">
            <input type="hidden" name="itemID">
            <div class="box-body">
              <div class="form-group">
                <label class="col-sm-2 control-label">Gl Code</label>
                <div class="col-sm-10">
                  <input type="text" name="GLCode" class="form-control" required placeholder="Gl Code">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description" rows="2" placeholder="Description"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label name="supplierID" class="col-sm-2 control-label">Supplier</label>
                <div class="col-sm-10">
                  <select class="form-control" name="supplierID">
                          <option value="">Select a supplier</option>
                      @foreach ($suppliers as $supplier)
                          <option value="{{$supplier->supplierID}}">{{ $supplier->supplierName }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Cost Amount</label>
                <div class="col-sm-10">
                  <input type="text" name="costAmount" class="form-control" placeholder="Cost Amount">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Margin</label>
                <div class="col-sm-10">
                  <input type="text" name="margin" class="form-control percentage" placeholder="Enter percentage out of 100 without the %">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Comments</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="comments" rows="2" placeholder="Comments"></textarea>
                </div>
              </div>


              <div class="form-group">
                <label name="itemType" class="col-sm-2 control-label">Material / Labour</label>
                <div class="col-sm-10">
                  <select class="form-control selection-child-item" name="itemType">
                     <option value="1">Meterial</option> 
                     <option value="2">Labour</option> 
                  </select>
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
  <div class="box-body">
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

    <button type="button" class="btn btn-primary pull-right add-btn" data-form-url="/jobcard/edit/maintenance" data-toggle="modal" data-target="#myModal">
      <i class="fa fa-plus"></i> <b>Add Item</b>
    </button>
    <br />
    <div class="row">
        <p class="m-title">Materials</p>
      
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
          <th class="amount-col">Actions</th>
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
            <td class="amount-col edit-button">
              <div class="inner">
                <a class="btn bg-green btn-sm item-edit" href="#" data-form-url="/jobcard/edit/maintenance/update" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <form class="delete-form" method="POST" action="/jobcard/edit/maintenance/{{$item->itemID}}">
                  <a href="#" class="delete-btn btn btn-danger btn-sm button--winona"><span><i class="fa fa-trash" aria-hidden="true"></i></span><span class="after">?</span></a>
                  <input type="hidden" name="_method" value="DELETE"> 
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </div>
            </td>
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
            <th class="amount-col">Actions</th>
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
              <td class="amount-col edit-button">
              <div class="inner">
                <a class="btn bg-green btn-sm item-edit" href="#" data-form-url="/jobcard/edit/maintenance/update" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <input type="hidden" class="values">
                <form class="delete-form" method="POST" action="prop/6">
                  <a href="#" class="delete-btn btn btn-danger btn-sm button--winona"><span><i class="fa fa-trash" aria-hidden="true"></i></span><span class="after">?</span></a>
                  <input type="hidden" name="_method" value="DELETE"> 
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </div>
            </td>
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
            <td class="amount-col edit-button"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@push('scripts')
  <script>
    $(function() {
      // Show data on the form when edit is clicked 
      $('.item-edit').on('click', function(){
        var item = $(this).closest('.maintenance-item');
        $('input[name="GLCode"]').val($(item).find('td[data-glcode-val]').data('glcode-val'));
        $('textarea[name="description"]').val($(item).find('td[data-description-val]').data('description-val'));
        $('select[name="supplierID"]').val($(item).find('td[data-supplier-val]').data('supplier-val'));
        $('input[name="costAmount"]').val($(item).find('td[data-cost-val]').data('cost-val'));
        $('input[name="margin"]').val($(item).find('td[data-margin-val]').data('margin-val'));
        $('textarea[name="comments"]').val($(item).find('td[data-comments-val]').data('comments-val'));
        $('select[name="itemType"]').val($(item).find('td[data-type-val]').data('type-val'));
        $('input[name="itemID"]').val($(item).find('td[data-itemid-val]').data('itemid-val'));
        

      });

      
      // Reset form when modal closes
      $('#myModal').on('hidden.bs.modal', function (e) {
        document.getElementById("maintenance-form").reset();
      });

      $('[data-toggle="modal"]').on('click', function(){
        var formUrl = $(this).data('form-url');
        console.log(formUrl); 
        $('#maintenance-form').attr('action', formUrl);
      });


    });

  </script>
@endpush