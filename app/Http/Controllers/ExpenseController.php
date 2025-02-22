<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
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
        $expeseDetails = Expense::where('user_id', $user->id)->get();
        return view('expenses', compact('expeseDetails'));
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
        //dd($request);
        $data = Expense::create([
            'expense_type' => $request->expenseType,
            'expense_amount' => $request->expenseAmount,
            'expense_date' => $request->expenseDate,
            'user_id' => $userId,
            'store_id' => $storeId
        ]);
        return redirect('expenses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }
    public function getValues($id){
        $data = Expense::find($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update($id, $expense_type, $expense_amount, $expense_date)
    {
        //dd($id ,$expense_type, $expense_amount, $expense_date);
        $updateExpense = Expense::find($id);
        $updateExpense->expense_type = $expense_type;
        $updateExpense->expense_amount = $expense_amount;
        $updateExpense->expense_date = $expense_date;
        $updateExpense->save();
        //return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($expense)
    {
        $deleteExpense = Expense::find($expense)->delete();
        $message = "";
        if($deleteProduct){
            $message = "Expense Deleted";
        }
        else{
            $message = "Some error occured";
        }
        return response()->json($message);
    }
}
