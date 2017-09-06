 @foreach ($supplierStatements as $supplierStatement)
                @if($supplierStatement->supplierInvoiceAmount-$supplierStatement->totalpaidAmount > 0)
                <tr>
                  <td>{{$supplierStatement->supplierName}}</td>
                  <td>{{$supplierStatement->invoiceSystemCode}}</td>
                  <td>{{$supplierStatement->invoiceDate}}</td>
                  <td>{{$supplierStatement->supplierInvoiceCode}}</td>
                  <td>OMR</td>
                  <td>{{number_format($supplierStatement->supplierInvoiceAmount,3)}}</td>
                  <td>{{number_format(($supplierStatement->supplierInvoiceAmount-$supplierStatement->totalpaidAmount),3)}}</td>
                </tr>
                @endif
           @endforeach