<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Admin\HistoryProduct;


class HistoryProductController extends Controller {
    
    const tmpl = 'admin/history_product/'; //путь до шаблонов
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $record = HistoryProduct::getById($request->id);
            $record->data = unserialize($record->data);
            return response()->json(['error' => false, 'response' => $record]);
        }
    }
    
    

}
