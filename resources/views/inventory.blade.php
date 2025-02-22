@extends('layouts.app')

@section('content')
<div class="modal" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="card-title" id="exampleModalLabel">Update Product</h4>
          </div>
          <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="modal_productName" placeholder="Product Name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="modal_productQuantity" placeholder="Product Quantity">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="modal_productPrice" placeholder="Product Price">
                        </div>
                        <input type="hidden" id="modal_inventoryId" name="modal_inventoryId" value="">
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer from-group">
            <p onclick="updateProduct()" style="height:2.5rem;" class='btn btn-success' value="">Update</p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
          </div>
      </div>
  </div>  
</div>

<section class="pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <h1>Inventory</h1>
                <div class="card">
                    <div class="card-header">{{ __('Total Inventory') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered" id="myTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Quantity</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Acton</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $inventoryDetails as $key )
                                <tr>
                                    <td>{{ $key->product_name}}</td>
                                    <td>{{ $key->product_quantity }}</td>
                                    <td>${{ $key->product_price }}</td>
                                    <td>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-round">
                                        <i id="{{$key->id}}" onclick="fetchValues({{$key->id}})" class="user_dialog" data-toggle="modal" data-target="#editProduct">Update</i>
                                    </button>
                                    <!-- <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-round">
                                        <i id="{{ $key->id}}" onclick="deleteProduct(this.id)">Delete</i>
                                    </button> -->
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
                    <div class="card-header">{{ __('Add Product') }}</div>

                    <div class="card-body">
                        <form action="{{ route('storeProduct') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                <input type="text" class="form-control" name="productName" placeholder="Product Name">
                                </div>
                                <div class="col">
                                <input type="text" class="form-control" name="productQuantity" placeholder="Product Quantity">
                                </div>
                                <div class="col">
                                <input type="number" class="form-control" name="productPrice" placeholder="Product Price">
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

function deleteProduct(id){
    var request = new XMLHttpRequest();
    request.open("GET", "deleteproduct/"+id, false);
    request.send();
    // document.getElementById('deleted').innerHTML = request.response;
    location.reload();
  }
  function updateProduct(){
    var id = document.getElementById('modal_inventoryId').value;

    var product_name = document.getElementById('modal_productName').value;
    var product_quantity = document.getElementById('modal_productQuantity').value;
    var product_price = document.getElementById('modal_productPrice').value;

    var request = new XMLHttpRequest();
    request.open("GET", "updateproduct/"+id+"/"+product_name+"/"+product_quantity+"/"+product_price, false);
    request.send();
    //console.log(request.response);
    location.reload();
  }
  function fetchValues(inventoryId){
    var request = new XMLHttpRequest();
    request.open("get", "getvaluesforupdate/" + inventoryId, false);
    request.send();
    var response = JSON.parse(request.response);
    //console.log(request.response);
    
    document.getElementById('modal_productName').value = response.product_name;
    document.getElementById('modal_productQuantity').value = response.product_quantity;
    document.getElementById('modal_productPrice').value = response.product_price;
    document.getElementById('modal_inventoryId').value = inventoryId;

  }
</script>
@endsection
