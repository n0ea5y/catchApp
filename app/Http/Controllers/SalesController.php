<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
class SalesController extends Controller
{
    public function getSales(String $id)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $sale = Sale::where('users_id', $id)
            ->whereBetween('created_date', [$startDate, $endDate])
            ->orderBy('created_date')
            ->get();

        return $sale;
    }

    public function show ($id) {
        $userDetail = User::find($id);
        
        return Inertia::render('Sale/Show',[
            'userDetail' => $userDetail,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'stores_id' => 'required',
            'customer_payment' => 'required',
            'created_date' => 'required',
        ]);

        try {
            $sale = new Sale();
            $sale->fill($request->all());
            $sale->save();

            return response()->json(['status' => 'success', 'message' => 'Sale data was successfully saved.'], 200);
        } catch (\Throwable $th) {

             return (['status' => 'error', 'message' => $th->getMessage()]);
        }

    }

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
}
