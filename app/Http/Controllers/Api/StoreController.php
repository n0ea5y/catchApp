<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stores = Store::select('store_name as title', 'id as value')->get();
        return response()->json($stores);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * 全ての店舗を配列形式で取得します。
     * 配列のキーは店舗のID（value）、値は店舗名（title）です。
     *
     * @return array 店舗のIDをキーとし、店舗名を値とする連想配列
     */
    public function getAllShopObj () {
        $stores = Store::select('store_name as title', 'id as value')->get();
        Log::debug($stores);
        return $stores;
    }
}
