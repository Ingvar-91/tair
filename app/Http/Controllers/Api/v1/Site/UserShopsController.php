<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Auth;
use App\Http\Models\Site\UsersShops;
use App\Http\Models\Site\Shops;
use App\Http\Models\Site\ShopCategories;
use App\Http\Models\Admin\ShopCategoriesRelations;
use App\Files\UploadImages;
use App\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Models\Admin\Users;

class UserShopsController extends RestController {

    use UploadImages;

    public function getAll(): Response {
        $shops = UsersShops::getShopsUser(Auth::user()->id);
        //$shops = UsersShops::getShopsUser(63);
        if($shops){
            foreach ($shops as $shop) {
                if ($shop->preview_frontpage) {
                    $shop->preview_frontpage = config('app.apiUrl') . config('filesystems.preview_frontpage.path') . $shop->preview_frontpage;
                }
            }
        }
        return $this->success($shops);
    }

    //добавить запись
    /* public function add(Request $request){
      //загружаем изображения
      $fileNames = '';
      if($request->hasFile('images')){
      $fileNames = $this->uploadImages($request->file('images'), 'shops');
      }
      $id = Shops::add($request, $fileNames);

      if($id){
      UsersShops::addShop(Auth::user()->id, $id);
      ShopCategoriesRelations::add($request->shop_categories_relations, $id);
      return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
      }
      return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
      } */

    //форма редактирования записи
    /*public function editForm(Request $request) {
        $this->data['shop'] = Shops::getById($request->id);
        $shop_categories = ShopCategories::getAll();
        $relations = ShopCategoriesRelations::getAllRelation($request);

        foreach ($shop_categories as $shop_category) {
            $shop_category->check = false;
            foreach ($relations as $relation) {
                if ($shop_category->id == $relation->shop_category_id)
                    $shop_category->check = true;
            }
        }
        $this->data['shop_categories'] = $shop_categories;

        return view(self::tmpl . 'edit', $this->data);
    }*/

    //сохранить изменения записи
    /*public function edit(Request $request) {
        $update = Shops::edit($request);
        if ($update) {

            //ShopCategoriesRelations::add($addRelations, $request->id);
            //ShopCategoriesRelations::removeInId($removeArrIds);
            //return back()->with('message-success', 'Данные успешно обновлены, магазин будет вновь доступен после проверки');
            return back()->with('message-success', 'Данные успешно обновлены');
        }

        return back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }*/

}
