<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Brands extends Model {

    public $table = 'brands';
    public $timestamps = false;

    public static function edit($request) {
        $images = '';
        if ($request->images) {
            $images = implode('|', $request->images);
        }
        return Brands::where('id', $request->id)->update([
            'images' => $images
        ]);
    }

    public static function getAll() {
        return Brands::get();
    }

}
