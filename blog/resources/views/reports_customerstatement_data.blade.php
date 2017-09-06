@foreach ($customerStatements as $customerStatement)
                @if($customerStatement->customerInvoiceAmount-$customerStatement->totalReceived > 0)
                <tr>
                  <td>{{$customerStatement->firstName}} {{$customerStatement->lastName}}</td>
                  <td>{{$customerStatement->invoiceSystemCode}}</td>
                  <td>{{$customerStatement->customerInvoiceDate}}</td>
                  <td>{{$customerStatement->customerInvoiceCode}}</td>
                  <td>OMR</td>
                  <td>{{number_format($customerStatement->customerInvoiceAmount,3)}}</td>
                  <td>{{number_format(($customerStatement->customerInvoiceAmount-$customerStatement->totalReceived),3)}}</td>
                </tr>
                @endif
           @endforeach