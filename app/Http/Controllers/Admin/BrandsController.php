<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Http\Models\Admin\Brands;

use App\Files\UploadImages;
use App\Files\UploadImage;

class BrandsController extends Controller {
    
    use UploadImages;
    //use UploadImage;

    const tmpl = 'admin/brands/'; //путь до шаблонов
    
    public function index(Request $request) {
        $this->data['brands'] = Brands::getAll()->first();
        
        return view(self::tmpl . 'index', $this->data);
    }
    
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){
            $fileName = $this->UploadImages($request->file, 'logo_brands', 1);
            //$fileName = $this->uploadImage($request->file, 'logo_brands', 'resizeByHeight');
            return response()->json(['fileName' => $fileName]);
        }
    }
    
    public function removeImageProduct(Request $request){
        if($request->ajax()){
            $result = $this->removeImage($request->image, 'logo_brands');
            return response()->json(['error' => empty($result)]);
        }
    }
    
    public function edit(Request $request){
        if($request->ajax()){
            $result = Brands::edit($request);
            return response()->json(['error' => empty($result)]);
        }
    }


}
