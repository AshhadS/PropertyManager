@foreach ($monthlyRevenueArray as $index=>$customer)
            
            <tr>
              <td>{{$index}}</td>
              <td>OMR</td>
              <td>{{number_format($customer[1],3)}}</td>
              <td>{{number_format($customer[2],3)}}</td>
              <td>{{number_format($customer[3],3)}}</td>
              <td>{{number_format($customer[4],3)}}</td>
              <td>{{number_format($customer[5],3)}}</td>
              <td>{{number_format($customer[6],3)}}</td>
              <td>{{number_format($customer[7],3)}}</td>
              <td>{{number_format($customer[8],3)}}</td>
              <td>{{number_format($customer[9],3)}}</td>
              <td>{{number_format($customer[10],3)}}</td>
              <td>{{number_format($customer[11],3)}}</td>
              <td>{{number_format($customer[12],3)}}</td>
                              
              
            </tr>
            
           @endforeach