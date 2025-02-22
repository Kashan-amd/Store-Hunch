<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Store;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $countSales = Sale::get()
            ->where('store_id', $user->id)->count();
    
        $countInventory = Inventory::get()
            ->where('store_id', $user->id)->count();
    
        $countExpenses = Expense::get()
            ->where('store_id', $user->id)->count();
    
        $data = [
            'countSales' => $countSales,
            'countInventory' => $countInventory,
            'countExpenses' => $countExpenses,
        ];

        //dd($data);

        return view('home', compact('data'));
    }
}
