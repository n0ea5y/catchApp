<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class SaleController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Log::debug($request);
        // return $request;
        // リクエストからデータを取得
        $data = $request->all();

        try {
            User::create($data);
            return response()->json(['status' => 'success', 'message' => 'User data was successfully saved.'], 200);
        } catch(\Throwable $th) {
        Log::debug($th->getMessage());
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        Log::debug($request);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
