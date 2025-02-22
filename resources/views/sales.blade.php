@extends('layouts.app')

@section('content')
<div class="modal" id="editSale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="card-title" id="exampleModalLabel">Update Sale</h4>
          </div>
          <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="date" class="form-control" id="modal_saleDate" placeholder="Sale Date">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="modal_saleAmount" placeholder="Sale Amount">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="modal_saleQuantity"  placeholder="Quantity">
                        </div>
                        <input type="text" id="modal_saleId" name="modal_saleId" value="">
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer from-group">
            <p onclick="updateSale()" style="height:2.5rem;" class='btn btn-success' value="">Update</p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>  
</div>

<section class="pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <h1>Sales</h1>
                <div class="card">
                    <div class="card-header">{{ __('Total Sales') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered" id="myTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Sale Date</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Acton</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($saleRecord as $key)
                                <tr>
                                    <td>{{$key['inventory_name']}}</td> 
                                    <td>{{ $key['date'] }}</td>
                                    <td>${{ $key['price'] }}</td>
                                    <td>{{ $key['quantity'] }}</td>
                                    
                                    <td>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-round">
                                        <i id="{{$key['id']}}" onclick="fetchValues({{$key['id']}})" class="user_dialog" data-toggle="modal" data-target="#editSale">Update</i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-round">
                                        <i id="{{ $key['id']}}" onclick="deleteSale(this.id)">Delete</i>
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
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif  
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif  
                <div class="card">
                    <div class="card-header">{{ __('Add Sale') }}</div>

                    <div class="card-body">
                    <form action="{{ route('storeSale') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <select name="productId" class="dropdown form-control" onchange="updatePrice(this.value)">
                                    @foreach( $inventoryDetails as $key )
                                    <option class="dropdown-item" value="{{ $key->id}}">{{ $key->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <input type="date" name="saleDate" class="form-control" placeholder="Sale Date">
                            </div>
                            <div class="col">
                                <input type="number" pattern="^[1-9]\d*$" min="1" id="saleQuantity" name="saleQuantity" class="form-control" placeholder="Quantity">
                            </div>
                            <div class="col">
                                <input type="number" readonly="readonly" disabled id="saleAmount" name="saleAmount" class="form-control" placeholder="Total Amount">
                                <input class="form-check-input" type="checkbox" value="tax" id="tax" onchange="updateTotal()">
                                <label class="form-check-label" for="tax">
                                    VAT 20%
                                </label>
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

function deleteSale(id){
    var request = new XMLHttpRequest();
    request.open("GET", "deletesale/"+id, false);
    request.send();
    // document.getElementById('deleted').innerHTML = request.response;
    location.reload();
}
function updateSale(){
    var id = document.getElementById('modal_saleId').value;

    var sale_date = document.getElementById('modal_saleDate').value;
    var sale_amount = document.getElementById('modal_saleAmount').value;
    var sale_quantity = document.getElementById('modal_saleQuantity').value;

    var request = new XMLHttpRequest();
    request.open("GET", "updatesale/"+id+"/"+sale_date+"/"+sale_amount+"/"+sale_quantity, false);
    request.send();
    //console.log(request.response);
    location.reload();
}
function fetchValues(saleId){
    var request = new XMLHttpRequest();
    request.open("get", "/getvaluesforsale/" + saleId, false);
    request.send();
    var response = JSON.parse(request.response);
    //console.log(request.response);

    document.getElementById('modal_saleDate').value = response.data.sale_date;
    document.getElementById('modal_saleAmount').value = response.data.sale_amount;
    document.getElementById('modal_saleQuantity').value = response.data.sale_quantity;
    document.getElementById('modal_saleId').value = saleId;

    // updating price in modal..
    var modal_quantityInput = document.getElementById('modal_saleQuantity');
    var modal_priceInput = document.getElementById('modal_saleAmount');

    modal_quantityInput.addEventListener('input', function() {
        var modal_quantity = parseInt(modal_quantityInput.value);
        var modal_price = response.product.product_price;
        
        // calculate the new price based on the quantity..
        var modal_newPrice = modal_price * modal_quantity;
        modal_priceInput.value = Math.round(modal_newPrice);
    });
}
function updatePrice(id) {
    var request = new XMLHttpRequest();
    request.open("get", "getprice/" + id, false);
    request.send();
    var response = JSON.parse(request.response);

    var originalPrice = parseFloat(response.product_price);
    document.getElementById('saleAmount').value = originalPrice;

    var quantityInput = document.getElementById('saleQuantity'); // Assuming you have an input with ID 'quantity'
    
    // Update price as per quantity
    quantityInput.addEventListener('input', function() {
        var quantity = parseInt(quantityInput.value);
        var newPrice = originalPrice * quantity;
        if (document.getElementById('tax').checked) {
            newPrice += newPrice * 0.2;  // Add 20% VAT
        }
        document.getElementById('saleAmount').value = newPrice;
    });
}

function updateTotal() {
    var priceWithoutVAT = (document.getElementById('saleAmount').value);
    if (document.getElementById('tax').checked) {
        document.getElementById('saleAmount').value = priceWithoutVAT * 1.2;
    } else {
        document.getElementById('saleAmount').value = priceWithoutVAT / 1.2; 
    }
}



</script>
@endsection
