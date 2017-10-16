@foreach ($monthlyRevenueArray as $index=>$unit)
            
            <tr>
              <td>{{$index}}</td>
              <td>OMR</td>
              <td>{{number_format($unit[1],3)}}</td>
              <td>{{number_format($unit[2],3)}}</td>
              <td>{{number_format($unit[3],3)}}</td>
              <td>{{number_format($unit[4],3)}}</td>
              <td>{{number_format($unit[5],3)}}</td>
              <td>{{number_format($unit[6],3)}}</td>
              <td>{{number_format($unit[7],3)}}</td>
              <td>{{number_format($unit[8],3)}}</td>
              <td>{{number_format($unit[9],3)}}</td>
              <td>{{number_format($unit[10],3)}}</td>
              <td>{{number_format($unit[11],3)}}</td>
              <td>{{number_format($unit[12],3)}}</td>
                              
              
            </tr>
            
           @endforeach