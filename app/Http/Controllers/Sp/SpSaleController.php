<?php

namespace App\Http\Controllers\Sp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SpSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        return Inertia::render('Sp/Sale/Index', ['userId' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stores_id' => 'required',
            'customer_payment' => 'required',
            'created_date' => 'required',
        ]);

        if(!$validated) return;

        try {

            $sale = new Sale();
            $sale->fill($request->all());
            $sale->save();

            return response()->json(['status' => 'success', 'message' => 'Sale data was successfully saved.'], 200);
        } catch (\Throwable $th) {

             return (['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userDetail = User::find($id);
        
        return Inertia::render('Sp/Sale/Show',[
            'userDetail' => $userDetail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request, String $saleId) {
        $sale = Sale::where('id', $saleId)->firstOrFail();
        // return $sale;
        $validated = $request->validate([
            'stores_id' => 'required',
            'customer_payment' => 'required',
            'created_date' => 'required',
        ]);

        try {
            $sale->update($request->all());
            return (['status' => 'success', 'message' => 'Sale created successfully']);
        } catch (\Throwable $th) {

             return (['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::find($id);
        $sale->delete();
    }

    public function getSales(Request $request)
    {
        $year = Carbon::now()->year;
        $month = $request->input('month');

        $startDate = Carbon::create($year, $month, 1);
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $sale = Sale::where('users_id', $request['userId'])
            ->whereBetween('created_date', [$startDate, $endDate])
            ->orderBy('created_date')
            ->get();

        return $sale;
    }

    public function getSaleTotalList (Request $request) {

        $userId = $request['userId'];
        
        $year = Carbon::now()->year;
        $month = $request->input('month');

        $startDate = Carbon::create($year, $month, 1);
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $totalSale = Sale::join('users', 'sales.users_id', '=', 'users.id')
        ->where('users_id', $userId)
        ->whereBetween('created_date', [$startDate, $endDate])
        ->selectRaw('sales.stores_id, users.commission, SUM(customer_payment) as total_customer_payment')
        ->groupBy('sales.stores_id', 'users.commission')
        ->get();
        
    return $totalSale;
    }

}
