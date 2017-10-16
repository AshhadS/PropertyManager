<?php use App\Http\Controllers\SettingsController; ?>
<h3 class="title page-header"><i class="fa fa-list"></i>  General Ledger</h3>
<div class="clearfix">
  <div class="col-md-6">
    <form class="form-inline filter-form" action="/entries/export">
    <div class="form-group">
      <label class="sr-only" for="from">From</label>
      <input type="text" name="from" class="form-control datepicker input-req" placeholder="From">
    </div>
    <div class="form-group">
      <label class="sr-only" for="to">To</label>
      <input type="text" name="to" class="form-control datepicker input-req" placeholder="To">
    </div>
    <p class="btn bg-light-blue filter-entries">Filter</p>
    <a class="btn btn-default link-ajaxed" data-section="entries" href="#entries">Reset</a>
  </form>
  </div>
  <div class="col-md-6">
  <a href="#" class="btn bg-light-blue pull-right excel-export"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel Export</a>
  </div>
</div>
  <br>
  <br>
<!-- Button trigger modal -->
<!--   <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Chart Of Accounts</b>
  </button> -->
<div class="col-md-12">
  <table class="table table-bordered">
    <thead>
        <th style="width: 10px">#</th>
        <th>Document Code</th>
        <th>Document Date</th>
        <th>Description</th>
        <th>GL Code</th>
        <th>GL Description</th>
        <th>Debit</th>
        <th>Credit</th>
    </thead>
    <tbody>
      @foreach ($entries as $index => $entry)
        <tr>
          <td data-val="{{$entry->amount}}">{{++$index}}</td>
          <td>{{$entry->documentCode}}</td>
          <td class="format-date"><?php print date_format(date_create($entry->documentDate),"d/m/Y")?></td>
          <td>{{$entry->description}}</td>
          <td>{{App\Model\ChartOfAccount::find($entry->accountCode)->chartOfAccountCode}}</td>
          <td>{{App\Model\ChartOfAccount::find($entry->accountCode)->accountDescription}}</td>

          @if($entry->amount < 0)
            <td>0</td>
            <td>{{abs($entry->amount)}}</td>
          @else
            <td>{{abs($entry->amount)}}</td>
            <td>0</td>
          @endif
        </tr>
      @endforeach      
      <tr>
        <td colspan="6" >Totals</td>        
        <td>{{abs($creditTot)}}</td>
        <td>{{abs($debitTot)}}</td>
      </tr>
    </tbody>
  </table>
</div>

  