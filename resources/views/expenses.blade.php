@extends('layouts.app')

@section('content')
<div class="modal" id="editExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="card-title" id="exampleModalLabel">Update Expense</h4>
          </div>
          <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="modal_expenseType" placeholder="Expense Type">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="modal_expenseAmount" placeholder="Expense Amount">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" id="modal_expenseDate" placeholder="Expense Date">
                        </div>
                        <input type="hidden" id="modal_expenseId" name="modal_expenseId" value="">
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer from-group">
            <p onclick="updateExpense()" style="height:2.5rem;" class='btn btn-success' value="">Update</p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>  
</div>


<section class="pt-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <h1>Expenses</h1>
                <div class="card">
                    <div class="card-header">{{ __('Total Expenses') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered" id="myTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Expense Type</th>
                                    <th scope="col">Expense Amount</th>
                                    <th scope="col">Expense Date</th>
                                    <th scope="col">Acton</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $expeseDetails as $key)
                                <tr>
                                    <td>{{ $key->expense_type }}</td>
                                    <td>${{ $key->expense_amount }}</td>
                                    <td>{{ $key->expense_date }}</td>
                                    <td>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-round">
                                        <i id="{{$key->id}}" onclick="fetchValues({{$key->id}})" class="user_dialog" data-toggle="modal" data-target="#editExpense">Update</i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-round">
                                        <i id="{{ $key->id}}" onclick="deleteExpense(this.id)">Delete</i>
                                    </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Expense') }}</div>

                    <div class="card-body">
                        <form action="{{ route('storeExpense') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                <input type="text" name="expenseType" class="form-control" placeholder="Expense Type">
                                </div>
                                <div class="col">
                                <input type="number" name="expenseAmount" class="form-control" placeholder="Expense Amount">
                                </div>
                                <div class="col">
                                <input type="date" name="expenseDate" class="form-control date" placeholder="Expense Date">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    </div>
                </div>
            </div>    
        </div>
    </div>

</section>

<script>

$(document).ready(function () {
 $('#myTable').DataTable ({
     order: [[1, 'asc' ]],
     dom: 'Bflrtip',
     buttons: [ 'csv', 'excel' ]
 });
});

function deleteExpense(id){
    var request = new XMLHttpRequest();
    request.open("GET", "deleteexpense/"+id, false);
    request.send();
    // document.getElementById('deleted').innerHTML = request.response;
    location.reload();
  }
  function updateExpense(){
    var id = document.getElementById('modal_expenseId').value;

    var expense_type = document.getElementById('modal_expenseType').value;
    var expense_amount = document.getElementById('modal_expenseAmount').value;
    var expense_date = document.getElementById('modal_expenseDate').value;

    var request = new XMLHttpRequest();
    request.open("GET", "updateexpense/"+id+"/"+expense_type+"/"+expense_amount+"/"+expense_date, false);
    request.send();
    //console.log(request.response);
    location.reload();
  }
  function fetchValues(expenseId){
    var request = new XMLHttpRequest();
    request.open("get", "getexpensevalues/" + expenseId, false);
    request.send();
    var response = JSON.parse(request.response);
    //console.log(request.response);
    
    document.getElementById('modal_expenseType').value = response.expense_type;
    document.getElementById('modal_expenseAmount').value = response.expense_amount;
    document.getElementById('modal_expenseDate').value = response.expense_date;
    document.getElementById('modal_expenseId').value = expenseId;
  }

</script>
@endsection
