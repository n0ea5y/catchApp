<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoresController extends Controller
{
    /**
     * 全ての店舗を配列形式で取得します。
     * 配列のキーは店舗のID（value）、値は店舗名（title）です。
     *
     * @return array 店舗のIDをキーとし、店舗名を値とする連想配列
     */
    public function getAllShopArrya () {
        $stores = Store::select('store_name as title', 'id as value')->get();

        return $stores;
    }
    
}
