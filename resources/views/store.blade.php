@extends('layouts.app')

@section('content')
<section class="pt-5">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <h1>Store</h1>
                <div class="card">
                    <div class="card-header">{{ __('Store info') }}</div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Store Name</th>
                                    <th scope="col">Store Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($storeDetails as $key)
                                <tr>
                                    <td>{{ $key->store_name }}</td>
                                    <td>{{ $key->store_address }}</td>
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
                    <div class="card-header">{{ __('Add Store') }}</div>
                    <!-- <div class="card-body">
                       <h5>Cannot make anymore store!</h5>
                    </div> -->
                    <div class="card-body">
                        <form action="{{ route('addStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                <input type="text" class="form-control" name="storeName" placeholder="Store Name">
                                </div>
                                <div class="col">
                                <input type="text" class="form-control" name="storeAddress" placeholder="Store Address">
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
@endsection
