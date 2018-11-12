<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Site\ProductComments;

class ProductCommentsController extends Controller{

    const tmpl = 'site/comments/';

    public function index(Request $request){
        if ($request->ajax()) {
            $result = $this->buildTree(ProductComments::getComments($request->product_id, $request->parent_id, $request->offset));
            return response()->json(['comments' => $result]);
        }
    }
    
    public function add(Request $request){
        if ($request->ajax()) {
            $id = ProductComments::add($request);
            return response()->json(['error' => empty($id), 'id' => $id]);
            
        }
    }

}
