<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Shops extends Model{
    
    //получить данные для DateTables
    public static function getDataForDataTables($fields){
        $query = Shops::orderBy($fields['nameColumn'], $fields['dirOrder']);
        
        if($fields['searchValue']){//если задана строка поиска
            $columns = $fields['columns'];
            $searchValue = $fields['searchValue'];
            $query->Where(function ($query) use ($columns, $searchValue) {
                $arrayWord = explode(' ', trim($searchValue));
                foreach ($arrayWord as $value) {
                    $query->orWhere('title', 'like', '%'.$value.'%');
                    $query->orWhere('vacancy', 'like', '%'.$value.'%');
                    $query->orWhere('contacts', 'like', '%'.$value.'%');
                    $query->orWhere('about', 'like', '%'.$value.'%');
                }
            });
            return $query->get();
        }
        else return $query->limit($fields['limit'])->offset($fields['offset'])->get();
    }
    
    public static function queryWhere($query = false, $fields = false){
        if(!$query) $query = Shops::orderBy('id', 'desk');
        
        return $query;
    }
    
    public static function getById($id){
        return Shops::where('id', '=', $id)->firstOrFail();
    }
    
    public static function add($request, $images = '', $logo = '', $preview_frontpage = '') {
		$dz_image_name = '';
		
		if(isset($request->dz_image_name)){
			$dz_image_name = implode('|', $request->dz_image_name);
		}
		
        return Shops::insertGetId([
            'title' => $request->title,
            'vacancy' => $request->vacancy,
            'contacts' => $request->contacts,
            'about' => $request->about,
            'status' => $request->status,
            'shop_type_id' => $request->shop_type_id,
            'event' => $request->event,
            'min_price' => $request->min_price,
            'cost_delivery' => $request->cost_delivery,
            'schedule' => $request->schedule,
            'phone_numbers' => $request->phone_numbers,
            'short_description' => $request->short_description,
            'images' => $images,
            'payment_methods' => serialize($request->payment_methods),
            'delivery_methods' => serialize($request->delivery_methods),
            'logo' => $logo,
            'pano' => $request->pano,
            'to_top' => $request->to_top,
            'link_whatsapp' => $request->link_whatsapp,
            'main_phone' => $request->main_phone,
            'preview_frontpage' => $preview_frontpage,
            'site_link' => $request->site_link,
            'map_2gis_url' => $request->map_2gis_url,
            'instagram' => $request->instagram,
            'placeholder' => $request->placeholder,
            'as_shop' => $request->as_shop,
            'gallery' => $dz_image_name,
            'slider_title' => $request->slider_title
        ]);
    }
    
    public static function edit($request, $images = '', $logo = '', $preview_frontpage = '') {
        $updete = [
            'title' => $request->title,
            'vacancy' => $request->vacancy,
            'contacts' => $request->contacts,
            'status' => $request->status,
            'shop_type_id' => $request->shop_type_id,
            'event' => $request->event,
            'min_price' => $request->min_price,
            'cost_delivery' => $request->cost_delivery,
            'schedule' => $request->schedule,
            'phone_numbers' => $request->phone_numbers,
            'short_description' => $request->short_description,
            'about' => $request->about,
            'pano' => $request->pano,
            'payment_methods' => serialize($request->payment_methods),
            'delivery_methods' => serialize($request->delivery_methods),
            'link_whatsapp' => $request->link_whatsapp,
            'main_phone' => $request->main_phone,
            'to_top' => $request->to_top,
            'site_link' => $request->site_link,
            'map_2gis_url' => $request->map_2gis_url,
            'instagram' => $request->instagram,
            'placeholder' => $request->placeholder,
            'as_shop' => $request->as_shop,
            'slider_title' => $request->slider_title
        ];
        if($images) $updete['images'] = $images;
        if($request->dz_image_name) $updete['gallery'] = implode('|', $request->dz_image_name);
        if($logo) $updete['logo'] = $logo;
        if($preview_frontpage) $updete['preview_frontpage'] = $preview_frontpage;
        return Shops::where('id', $request->id)->update($updete);
    }
    
    public static function remove($request){
        return Shops::where('id', '=', $request->id)->delete();
    }
    
    public static function getAll(){
        return Shops::get();
    }
    
}