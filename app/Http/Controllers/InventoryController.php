<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Store;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the current authenticated user
        $user = Auth::user();

        // Retrieve all stores for the user
        $inventoryDetails = Inventory::where('user_id', $user->id)->get();
        //dd($inventoryDetails, $user);
        return view('inventory', compact('inventoryDetails', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $storeId = Store::where('user_id', Auth::user()->id)->first()->id;
        
        //dd($saleId);
        $data = Inventory::create([
            'product_name' => $request->productName,
            'product_quantity' => $request->productQuantity,
            'product_price' => $request->productPrice,
            'user_id' => $userId,
            'store_id' => $storeId
        ]);
        return redirect('inventory')->with('success','Inventory created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }
    public function getValues($id){
        $data = Inventory::find($id);
        return response()->json($data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update($id, $product_name, $product_quantity, $product_price)
    {
        //dd($id ,$product_name, $product_quantity, $product_price);
        $updateProduct = Inventory::find($id);
        $updateProduct->product_name = $product_name;
        $updateProduct->product_quantity = $product_quantity;
        $updateProduct->product_price = $product_price;
        $updateProduct->save();
        //return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory)
    {
        $deleteProduct = Inventory::find($inventory)->delete();
        $message = "";
        if($deleteProduct){
            $message = "Product Deleted";
        }
        else{
            $message = "Some error occured";
        }
        return response()->json($message);
    }
}
