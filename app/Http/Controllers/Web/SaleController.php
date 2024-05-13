<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Sale;
use Illuminate\Support\Carbon;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
        
        return Inertia::render('Sale/Show',[
            'userDetail' => $userDetail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
}
