<?php
namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;

use Illuminate\Http\Request;

use App\Http\Models\Site\Products;

class WishlistsController extends RestController {

    public function index(Request $request){
        $data = Products::getWishlists(explode(',', $request->ids));
        return $this->success($data);
    }

}
