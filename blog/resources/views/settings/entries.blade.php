<?php use App\Http\Controllers\SettingsController; ?>
<h3 class="title">General Ledger</h3>
<!-- Button trigger modal -->
<!--   <button type="button" class="btn btn-primary pull-right add-btn" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus"></i> <b>Add Chart Of Accounts</b>
  </button> -->
<div class="col-md-12">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Document Code</th>
        <th>Description</th>
        <th>GL Code</th>
        <th>GL Description</th>
        <th>Debit</th>
        <th>Credit</th>
      </tr>
      @foreach ($entries as $index => $entry)
      <tr>
        <td>{{++$index}}</td>
        <td>{{$entry->documentCode}}</td>
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
    </tbody>
  </table>
</div>

  