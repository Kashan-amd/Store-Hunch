<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
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
        $storeId = Store::where('id', $user->id)->get();

        // Retrieve all stores for the user
        $storeDetails = Store::where('user_id', $user->id)->get();

        //dd($userId);
        return view('store', compact('storeDetails','storeId')); 
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
        $store_exists = Store::where('user_id', $userId)->first();
        if($store_exists){
            return redirect('store')->with('error', 'Cannot make more than one Store!');
        }
        //dd($request);
        $data = Store::create([
            'store_name' => $request->storeName,
            'store_address' => $request->storeAddress,
            'user_id' => Auth::user()->id
        ]);
        return redirect('store')->with('success', 'Store created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($store)
    {
        $deleteStore = Store::find($store)->delete();
        $message = "";
        if($deleteProduct){
            $message = "Store Deleted";
        }
        else{
            $message = "Some error occured";
        }
        return response()->json($message);
    }
}
