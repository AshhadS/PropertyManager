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