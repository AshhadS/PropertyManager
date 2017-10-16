@extends('admin_template')
@section('content')
<title>IBSS | Reconciliation</title>

<div class="panel panel-default give-space">
    <div class="panel-body">
      <div class="page-header container-fluid">
        <div class="container-fluid">
          <section class="content-header pull-left">
              <h4><b>BANK ACCOUNTS</b></h4>
          </section>

        </div>
      </div>
            <table class="table table-bordered table-hover table-striped" id="rentalowners-table">

                <!-- Table Headings -->
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Account</th> 
                      <th>Bank</th>
                      <th>Book Ballence</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                    @foreach($accounts as $index => $account)
                      <tr>
                        <td> {{++$index}} </td>
                        <td>
                          @if(App\Model\BankAccount::find($account->bankAccountID) && $account->bankAccountID != 0)
                            {{App\Model\BankAccount::find($account->bankAccountID)->accountNumber}}
                          @endif
                        </td>
                        <td>
                          @if(App\Model\Bank::find($account->bankmasterID) && $account->bankmasterID != 0)
                            {{App\Model\Bank::find($account->bankmasterID)->bankName}}
                          @endif
                        </td>
                        <td>
                          0
                        </td>
                        <td class="edit-button">
                          <a class="btn bg-green btn-sm pull-left" data-toggle="tooltip" title="Edit" href="/{{$account->bankAccountID}}/reconciliation"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                        </td>
                          
                          
                      </tr>
                    @endforeach

                       
            </table>
    </div>
</div>

@endsection
