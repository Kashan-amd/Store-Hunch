<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Store;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
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
        $saleDetails = Sale::where('user_id', $user->id)->get();

        $saleRecord = array();
        foreach ($saleDetails as $key) {
            array_push($saleRecord, [
                'id' => $key->id,
                'inventory_name' => Inventory::where('id', $key->inventory_id)->first()->product_name,
                'date' => $key->sale_date,
                'quantity' => $key->sale_quantity,
                'price' => $key->sale_amount,
            ]);
        }
        //dd($saleRecord[0]['inventory_name']); 
        
        $inventoryDetails = Inventory::where('user_id', $user->id)->get();
        //dd($inventoryDetails, $saleDetails);
        return view('sales', compact('saleRecord', 'inventoryDetails'));
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
        //dd($request);
        $id = $request->productId;

        $productQty = Inventory::find($id);
        //dd($productQty->product_quantity, " - ", $request->saleQuantity); 
        
        if($request->saleQuantity > $productQty->product_quantity){
            return redirect('sales')->with('error', 'Sorry, You have selected more '.$productQty->product_name.' than in inventory! Check again.');
        }
        else{
            $userId = Auth::user()->id;
            $storeId = Store::where('user_id', Auth::user()->id)->first()->id;
            //dd($storeId);
            $data = Sale::create([
                'sale_date' => $request->saleDate,
                'sale_amount' => $request->saleAmount,
                'sale_quantity' => $request->saleQuantity,
                'inventory_id' => $request->productId,
                'user_id' => $userId,
                'store_id' => $storeId
            ]);
    
            //update quantity in inventory(database) 
            $newQuantity = $productQty->product_quantity - $request->saleQuantity;
            $productQty->product_quantity = $newQuantity;
            $productQty->save();
    
            return redirect('sales')->with('success', 'Sale created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }
    public function getValues($id){
        $data = Sale::find($id);
        $product = Inventory::join('sales', 'sales.inventory_id', '=', 'inventories.id')
                   ->where('sales.id', $id)
                   ->select('inventories.*')
                   ->first();
        return response()->json(['data' => $data, 'product' => $product]);
    }
    
    public function getPrice($id){
        $product = Inventory::find($id);
        return response()->json($product);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update($id, $sale_date, $sale_amount, $sale_quantity)
    {
        $productQty = Inventory::find($id);
        //dd($productQty->product_quantity, " - ", $request->saleQuantity); 

        //dd($id ,$sale_date, $sale_amount);
        $updateSale = Sale::find($id);
        $updateSale->sale_date = $sale_date;
        $updateSale->sale_amount = $sale_amount;
        $updateSale->sale_quantity = $sale_quantity;

        //update quantity in inventory(database) 
        $newQuantity = $productQty->product_quantity - $updateSale->sale_quantity;
        $productQty->product_quantity = $newQuantity;
        $productQty->save();

        $updateSale->save();
        //return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($sale)
    {
        $deleteSale = Sale::find($sale)->delete();
        $message = "";
        if($deleteSale){
            $message = "Sale Deleted";
        }
        else{
            $message = "Some error occured";
        }
        return response()->json($message);
    }
}
