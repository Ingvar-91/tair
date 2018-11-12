<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Http\Models\Admin\Reviews;
use App\Http\Models\Admin\Products;


class ReviewsController extends Controller {
    
    const tmpl = 'admin/reviews/'; //путь до шаблонов

    public function index(Request $request) {
        if ($request->ajax()) {
            $fields = $this->getFieldsDataTables($request); //получаем значения полей от плагина dataTables при ajax запросе
            $items = Reviews::getDataForDataTables($fields); //получаем данные для DataTables
            if ($items) {
                foreach ($items as $item) {
                    $item->actions = view(self::tmpl . 'data-table-action', ['id' => $item->id])->render();
                }
                $recordsTotal = Reviews::queryWhere(false, $fields)->count();
                if ($request->input('search')['value']) $recordsFiltered = $items->count();
                else $recordsFiltered = $recordsTotal;
                return response()->json([
                    'data' => $items,
                    'recordsTotal' => $recordsTotal,
                    'recordsFiltered' => $recordsFiltered
                ]);
            }
        }
        return view(self::tmpl . 'index', $this->data);
    }
    
    public function addForm(){ 
        return view(self::tmpl.'add', $this->data);
    }
    
    /*public function add(Request $request){
        $result = Reviews::add($request);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно добавлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при добавлении данных.');
    }*/
    
    /*public function editForm(Request $request){
        $this->data['shop_category'] = ShopCategories::getById($request->id);
        return view(self::tmpl.'edit', $this->data);
    }*/
    
    /*public function edit(Request $request){
        $result = ShopCategories::edit($request);
        if($result) return redirect()->back()->with('message-success', 'Данные успешно обновлены.');
        else return redirect()->back()->with('message-error', 'Произошла ошибка при обновлении данных.');
    }*/
    
    public function remove(Request $request){
        if ($request->ajax()) {
            $review = Reviews::getById($request->id);
            $remove = Reviews::remove($request);
            
            if($remove and ($review->type == 1)){
                //если тип 1, товар
                $reviews = Reviews::getAllReviewsProduct($review->product_id, 'all');

                //рачитать общий рейтинг
                $rating = 0;
                $countReviews = count($reviews);
                if($reviews){
                    foreach ($reviews as $review){
                        $rating += $review->rating;
                    }
                }
                $rating = $rating / $countReviews;
                Products::updateRating($review->product_id, $rating, $countReviews);
            }
            return response()->json(['error' => empty($remove)]);
        }
    }

}
