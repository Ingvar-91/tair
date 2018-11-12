<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Http\Models\Admin\Posts;

use App\Files\UploadImages;

class PostsGalleryController extends Controller {
    
    use UploadImages;

    const tmpl = 'admin/posts/'; //путь до шаблонов
    
    public function index(Request $request) {
        $this->data['posts'] = Posts::getByType(request()->shop_type, request()->page);
        $this->data['posts']->images = $this->data['posts']->extra;
        dd($this->data['posts']);
        return view(self::tmpl . 'index', $this->data);
    }
    
    public function uploadFiles(Request $request){
        if($request->hasFile('file')){
            $fileName = $this->UploadImages($request->file, 'post_gallery', 1, 'imposition');
            return response()->json(['fileName' => $fileName]);
        }
    }
    
    public function removeImageProduct(Request $request){
        if($request->ajax()){
            $result = $this->removeImages($request->image, 'post_gallery');
            return response()->json(['error' => empty($result)]);
        }
    }
    
    public function edit(Request $request){
        if($request->ajax()){
            $result = Posts::edit($request);
            return response()->json(['error' => empty($result)]);
        }
    }
    
    //форма добавления новой записи
    /*public function addForm(){
        return view(self::tmpl.'add', $this->data);
    }
    
    //добавить запись
    public function add(Request $request){
        //загружаем изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'slider');
        }
        
        $result = Slider::add($request, $fileNames);
        
        if($result){
            return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        }
        
        return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }
    
    //форма редактирования записи
    public function editForm(Request $request){
        $this->data['slider'] = Slider::getById($request->id);
        return view(self::tmpl.'edit', $this->data);
    }
    
    //сохранить изменения записи
    public function edit(Request $request){
        
        //загружаем новые изображения
        $fileNames = '';
        if($request->hasFile('images')){
            $fileNames = $this->uploadImages($request->file('images'), 'slider');
            $data = Slider::getById($request->id);
            if($fileNames) $this->removeImages($data->images, 'slider');
        }
        
        //обновляем
        $update = Slider::edit($request, $fileNames);
        if($update){
            return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        }
        return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }
    
    public function remove(Request $request){
        if ($request->ajax()) {
            $data = Slider::getById($request->id);
            $this->removeImages($data->images, 'slider');
            
            $result = Slider::remove($request);
            return response()->json(['error' => empty($result)]);
        }
    }*/

}
