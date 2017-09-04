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
              <!-- <div class="form-group">
                <label name="supplierID" class="col-sm-2 control-label">Gl Code</label>
                <div class="col-sm-10">
                  <select class="form-control" name="GLCode">
                    <option value="">Select a chart</option>
                    @foreach ($chartOfAccounts as $chart)
                      <option value="{{$chart->chartOfAccountID}}">{{ $chart->chartOfAccountCode }}</option>
                    @endforeach
                  </select>
                </div>
              </div> -->

              <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control input-req" name="description" rows="2" placeholder="Description"></textarea>
                </div>
              </div>

              <div class="form-group">
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

              <div class="form-group">
                <label class="col-sm-2 control-label">Units</label>
                <div class="col-sm-10">
                  <input type="text" name="units" class="form-control input-req" placeholder="Units">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Cost</label>
                <div class="col-sm-10">
                  <input type="text" name="cost" class="form-control input-req" placeholder="Cost">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Margin</label>
                <div class="col-sm-10">
                  <input type="text" name="margin" class="form-control input-req percentage" placeholder="Enter percentage out of 100 without the %">
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
                  <select class="form-control input-req selection-child-item" name="itemType">
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

    <div class="pull-right">
    <div class="container-fluid">
      
      <div class="row">
        <button type="button" class="btn btn-primary pull-right add-btn <?php ($jobcard->isSubmitted == 1) ? print 'disabled' : false ?>" data-form-url="/jobcard/edit/maintenance" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-plus"></i> Add Item
        </button>        
      </div>
    </div>
      <?php ($jobcard->isSubmitted == 1) ? print '<p class="text-muted">Once the submit has been clicked item cant be changed</p>' : false ?>
    </div>
    <br />
    <div class="row">
        <p class="m-title">Materials</p>

    <div class="main-table">      
      <table class="m-item  table table-striped">
        <thead>
        </thead>
        <tbody>
          <tr class="t-head">
            <th class="amount-col">#</th>
            <!-- <th>GL Code</th> -->
            <th>Description</th>
            <th>Comments</th>
            <th>Supplier</th>
            <th class="amount-col">Units</th>
            <th class="amount-col">Cost</th>
            <th class="amount-col">Total</th>
            <th class="amount-col">Margin</th>
            <th class="amount-col">Net Total</th>
            <th class="amount-col"><span class="pull-left">Actions &nbsp;&nbsp;</span> <h4 class="pull-left remove-margin"><!-- <i class="add-item fa fa-plus-square" aria-hidden="true"></i> --></h4></th>
          </tr>
          @foreach($maintenanceItensMaterial as $index => $item)
            <tr class="maintenance-item">
              <td data-type-val="{{$item->itemType}}" data-itemid-val="{{$item->itemID}}" class="amount-col">{{++$index}}</td>
              <!-- <td data-glcode-val="{{$item->GLCode}}">{{$item->GLCode}}</td> -->
              <td data-description-val="{{$item->description}}">{{$item->description}}</td>
              <td data-comments-val="{{$item->comments}}">{{$item->comments}}</td>
              <td data-supplier-val="{{$item->supplierID}}">
              @if(App\Model\Supplier::find($item->supplierID) && $item->supplierID != 0)
                 {{App\Model\Supplier::find($item->supplierID)->supplierName}}
              @endif
              </td>
              <td data-units-val="{{$item->units}}" class="amount-col">{{$item->units}}</td>
              <td data-cost-val="{{$item->cost}}" class="amount-col"><?= number_format((float)$item->cost, 3, '.', '') ?></td>
              <td class="amount-col"><?= number_format((float)$item->total, 3, '.', '') ?></td>
              <td data-margin-val="{{$item->margin}}" class="amount-col">{{$item->margin}}%</td>
              <td class="amount-col"><?= number_format((float)$item->netTotal, 3, '.', '') ?></td>
              <td class="amount-col edit-button">
                <div class="inner">
                  <a class="btn bg-green btn-sm item-edit <?php ($jobcard->isSubmitted == 1) ? print 'disabled' : false ?>" href="#" data-form-url="/jobcard/edit/maintenance/update" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                  <form class="delete-form" method="POST" action="/jobcard/edit/maintenance/{{$item->itemID}}">
                    <a href="#" class="delete-btn btn btn-danger btn-sm button--winona <?php ($jobcard->isSubmitted == 1) ? print 'disabled' : false ?>"><span><i class="fa fa-trash" aria-hidden="true"></i></span><span class="after">?</span></a>
                    <input type="hidden" name="_method" value="DELETE"> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
          
          
        </tbody>
      </table>
<!--       <div class="maintenance-item new-item" >
        <form action="/jobcard/edit/maintenance" class="meterial-maintenance" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}" />
          <input type="hidden" name="itemType" value="1" />
          <div ></div>
          <div class="table-col">
            <select class="form-control" name="GLCode">
              <option value="">Select a chart</option>
              @foreach ($chartOfAccounts as $chart)
                <option value="{{$chart->chartOfAccountID}}">{{ $chart->accountDescription }}</option>
              @endforeach
            </select>
          </div>
          <div class="table-col" ><input type="text" class="form-control" placeholder="Description" name="description" /></div>
          <div class="table-col" ><input type="text" class="form-control" placeholder="Comment" name="comments" /></div>
          <div class="table-col" >
            <select class="form-control" name="supplierID">
              <option value="">Select a supplier</option>
              @foreach ($suppliers as $supplier)
                <option value="{{$supplier->supplierID}}">{{ $supplier->supplierName }}</option>
              @endforeach
            </select>
          </div>
          <div class="amount-col table-col"><input type="text" name="units" class="form-control" placeholder="Units" /></div>
          <div class="amount-col table-col"><input type="text" name="cost" class="form-control" placeholder="Cost" /></div>
          <div class="amount-col table-col"></div>
          <div class="amount-col table-col"><input type="text" name="margin" class="form-control percentage" placeholder="Percent %" /></div>
          <div class="amount-col table-col "></div>
          <div class="amount-col edit-button table-col">
            <div class="inner">                
              <a class="delete-item" href="#">Remove</a>
            </div>
          </div>
        </form>
      </div> -->
      <table class="m-item table table-striped">
        <tr class="success">
          <td><b>Total</b></td>
          <!-- <td></td> -->
          <td></td>
          <td></td>
          <td></td>
          <td class="total-cell amount-col"></td>
          <td class="total-cell amount-col"></td>
          <td class="total-cell amount-col"></td>
          <td class="total-cell amount-col"></td>
          <td class="total-cell amount-col"><?= number_format((float)$maintenanceItensMeterialsTotal, 3, '.', '') ?></td>
          <td class="amount-col edit-button"></td>
        </tr>
      </table>      
    </div>
    <!-- <div class="container-fluid">
      <button class="btn btn-primary pull-right meterial-maintenance" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
    </div> -->
      
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
            <!-- <th>GL Code</th> -->
            <th>Description</th>
            <th>Comments</th>
            <th>Supplier</th>
            <th class="amount-col">Units</th>
            <th class="amount-col">Cost</th>
            <th class="amount-col">Total</th>
            <th class="amount-col">Margin</th>
            <th class="amount-col">Net Total</th>
            <th class="amount-col"><span class="pull-left">Actions &nbsp;&nbsp;</span> <h4 class="pull-left remove-margin"><!-- <i class="add-item fa fa-plus-square" aria-hidden="true"></i> --></h4></th>
          </tr>

          @foreach($maintenanceItensLabour as $index => $item)
            <tr class="maintenance-item">
              <td data-type-val="{{$item->itemType}}" data-itemid-val="{{$item->itemID}}" class="amount-col">{{++$index}}</td>
              <!-- <td data-glcode-val="{{$item->GLCode}}">{{$item->GLCode}}</td> -->
              <td data-description-val="{{$item->description}}">{{$item->description}}</td>
              <td data-comments-val="{{$item->comments}}">{{$item->comments}}</td>
              <td data-supplier-val="{{$item->supplierID}}">
                @if(App\Model\Supplier::find($item->supplierID) && $item->supplierID != 0)
                   {{App\Model\Supplier::find($item->supplierID)->supplierName}}
                @endif
              </td>
              <td data-units-val="{{$item->units}}" class="amount-col">{{$item->units}}</td>
              <td data-cost-val="{{$item->cost}}" class="amount-col"><?= number_format((float)$item->cost, 3, '.', '') ?></td>
              <td class="amount-col"><?= number_format((float)$item->total, 3, '.', '') ?></td>
              <td data-margin-val="{{$item->margin}}" class="amount-col">{{$item->margin}}%</td>
              <td class="amount-col"><?= number_format((float)$item->netTotal, 3, '.', '') ?></td>
              <td class="amount-col edit-button">
                <div class="inner">
                  <a class="btn bg-green btn-sm item-edit <?php ($jobcard->isSubmitted == 1) ? print 'disabled' : false ?>" href="#" data-form-url="/jobcard/edit/maintenance/update" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                  <input type="hidden" class="values">
                  <form class="delete-form" method="POST" action="/jobcard/edit/maintenance/{{$item->itemID}}">
                    <a href="#" class="delete-btn btn btn-danger btn-sm button--winona <?php ($jobcard->isSubmitted == 1) ? print 'disabled' : false ?>"><span><i class="fa fa-trash" aria-hidden="true"></i></span><span class="after">?</span></a>
                    <input type="hidden" name="_method" value="DELETE"> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
          <!-- <div class="maintenance-item new-item" >
            <form action="/jobcard/edit/maintenance" class="labour-maintenance" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="itemType" value="1">
              <td ></td>
              <td class="">
                <select class="form-control" name="GLCode">
                  <option value="">Select a chart</option>
                  @foreach ($chartOfAccounts as $chart)
                    <option value="{{$chart->chartOfAccountID}}">{{ $chart->accountDescription }}</option>
                  @endforeach
                </select>
              </td>
              <td ><input type="text" class="form-control" placeholder="Description" name="description" /></td>
              <td ><input type="text" class="form-control" placeholder="Comment" name="comments" /></td>
              <td >
                <select class="form-control" name="supplierID">
                  <option value="">Select a supplier</option>
                  @foreach ($suppliers as $supplier)
                    <option value="{{$supplier->supplierID}}">{{ $supplier->supplierName }}</option>
                  @endforeach
                </select>
              </td>
              <td  class="amount-col"><input type="text" name="units" class="form-control" placeholder="Units"></td>
              <td  class="amount-col"><input type="text" name="cost" class="form-control" placeholder="Cost"></td>
              <td class="amount-col"></td>
              <td class="amount-col"><input type="text" name="margin" class="form-control percentage" placeholder="Percent %"></td>
              <td class="amount-col"></td>
              <td class="amount-col edit-button">
                <div class="inner">                
                  <a class="delete-item" href="#">Remove</a>
                </div>
              </td>
            </form>
          </div> -->
          <tr class="success">
            <td><b>Total</b></td>
            <!-- <td></td> -->
            <td></td>
            <td></td>
            <td></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"><?= number_format((float)$maintenanceItensLabourTotal, 3, '.', '') ?></td>
            <td class="amount-col edit-button"></td>
          </tr>
        </tbody>
      </table>
      <div class="container-fluid">
        <!-- <button class="btn btn-primary pull-right labour-maintainance" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button> -->
      </div>
        
    </div>
    <br />
    <div class="row">
      <p class="m-title">Summary</p>
      <table class="m-item  table">
        <thead>
        </thead>
        <tbody>
          <tr class="success">
            <td><b>Grand Total</b></td>
            <!-- <td></td> -->
            <td></td>
            <td></td>
            <td></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"></td>
            <td class="total-cell amount-col"><?= number_format((float)$maintenanceItensTotal, 3, '.', '') ?></td>
            <td class="amount-col edit-button"></td>
          </tr>
        </tbody>
      </table>
    </div>
      
    <div class="container-fluid">
      <div class="row">
        <div class="button-group pull-right">
          <form method="POST" action="/maintainance/submit">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="jobcardID" value="{{$jobcard->jobcardID}}">
            <input type="hidden" name="flag" value="{{$jobcard->isSubmitted}}">
            @if($jobcard->isSubmitted == 1)
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
        $('input[name="units"]').val($(item).find('td[data-units-val]').data('units-val'));
        $('input[name="cost"]').val($(item).find('td[data-cost-val]').data('cost-val'));
        $('input[name="margin"]').val($(item).find('td[data-margin-val]').data('margin-val'));
        $('textarea[name="comments"]').val($(item).find('td[data-comments-val]').data('comments-val'));
        $('select[name="itemType"]').val($(item).find('td[data-type-val]').data('type-val'));
        $('input[name="itemID"]').val($(item).find('td[data-itemid-val]').data('itemid-val'));

      });

      deleteRowHandler();
      dynamicFormSubmit();
      
      // Reset form when modal closes
      $('#myModal').on('hidden.bs.modal', function (e) {
        document.getElementById("maintenance-form").reset();
      });

      $('[data-toggle="modal"]').on('click', function(){
        var formUrl = $(this).data('form-url');
        console.log(formUrl); 
        $('#maintenance-form').attr('action', formUrl);
      });

      // Adding new row in click of plus icon
      $(".add-item").on('click',  function(e){
        e.preventDefault();
        var newRow = '<div class="maintenance-item new-item">'+$(this).closest('.main-table').find('.new-item').first().html()+'</div>';
        $(newRow).find('[name="_token"]').val('{{csrf_token()}}')
        // console.log(($(newRow).find('[name="_token"]')));
        $(this).closest('.main-table').find('.new-item').last().after(newRow);
        deleteRowHandler();        
        dynamicFormSubmit();
      });

      function deleteRowHandler(){
        $('.delete-item').on('click', function(e){
          e.preventDefault();
          if($(this).closest('.main-table').find('.new-item').length > 1)
            $(this).closest('.new-item').remove();
        });
      }

      $('button.meterial-maintenance').on('click', function(){
        $('form.meterial-maintenance').each(function(key, value){
          $.ajax({
              url : $(value).attr('action'),
              type: "POST",
              data: $(value).serialize(),
              success: function (data) {
                  console.info('success');
              },
              error: function (jXHR, textStatus, errorThrown) {
                  console.info(errorThrown);
              }
          });
        });
        setTimeout(location.reload.bind(location), 20)
      });

      $('.labour-maintenance').on('click', function(){
        $('form.labour-maintenance').submit();
      });

      $('.form-horizontal').on('submit', function(e){
        console.log(parseInt($(this).find('[name="units"]').val())); 
        if(parseInt($(this).find('[name="units"]').val()) <= 0){
          alert('Units cannot be zero or less');
          e.preventDefault();
        }
      })

      function dynamicFormSubmit(){
        $('.meterial-maintenance').on('submit', function(e) {
          e.preventDefault();
          console.log(this); 
          // $.each(this, function(key, value){
          //   console.log($(value).serialize()); 

          // })
          // $.ajax({
          //     url : $(this).attr('action'),
          //     type: "POST",
          //     data: $(this).serialize(),
          //     success: function (data) {
          //         console.info('success');
          //     },
          //     error: function (jXHR, textStatus, errorThrown) {
          //         console.info(errorThrown);
          //     }
          // });
        }); 
      }


    });

  </script>
@endpush