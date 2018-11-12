<?php

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api\v1'
        ], function () {

    // ТОВАРЫ
    Route::group(['prefix' => 'products'], function() {
        Route::get('getProductsByCategory/{category_id}', ['uses' => 'Site\ProductsController@getProductsByCategory'])->name('products')->where('category_id', '[\d]+');
        Route::get('/getById/{id}', ['uses' => 'Site\ProductsController@getById'])->where('id', '[\d]+');
        Route::get('/getAllNovelty', ['uses' => 'Site\ProductsController@getAllNovelty']);
    });

    // КАТЕГОРИИ
    Route::group(['prefix' => 'productCategories'], function() {
        Route::get('/getById/{id}', ['uses' => 'Site\ProductCategoriesController@getById'])->where('id', '[\d]+');
        Route::get('/getAll', ['uses' => 'Site\ProductCategoriesController@getAll']);
    });

    // МАГАЗИНЫ
    Route::group(['prefix' => 'shops'], function() {
        Route::get('/getAll', ['uses' => 'Site\ShopsController@getAll']);
        Route::get('/getById/{id}', ['uses' => 'Site\ShopsController@getById'])->where('id', '[\d]+');
        Route::get('/getProducts/{id}', ['uses' => 'Site\ShopsController@getProducts'])->where('id', '[\d]+');
        Route::get('/getAllEntPlaces', ['uses' => 'Site\ShopsController@getAllEntPlaces']);
        Route::get('/getShopTop', ['uses' => 'Site\ShopsController@getShopTop']);
    });
    
    // ИНТЕРЕСНЫЕ МЕСТА
    Route::group(['prefix' => 'entPlaces'], function() {
        Route::get('/getAll', ['uses' => 'Site\EntPlacesController@getAll']);
    });
    
    // ВСЕ ТОВАРЫ ДНЯ
    Route::group(['prefix' => 'productDay'], function() {
        Route::get('/getAll', ['uses' => 'Site\ProductDayController@getAll']);
    });
    
    // КОНТАКТЫ
    Route::group(['prefix' => 'contacts'], function() {
        Route::get('/getAllNumbers', ['uses' => 'Site\ContactsController@getAllNumbers']);
    });
    
    // ДОМАШНЯЯ СТРАНИЦА
    Route::group(['prefix' => 'home'], function() {
        Route::get('/', ['uses' => 'Site\HomeController@index']);
        Route::get('/getAllBrands', ['uses' => 'Site\HomeController@getAllBrands']);
    });
    
    // ФОТОГАЛЕРЕЯ
    Route::group(['prefix' => 'photo'], function() {
        Route::get('/getAllAlbum', ['uses' => 'Site\PhotoController@getAllAlbum']);
        Route::get('/getPhotosAlbum/{id}', ['uses' => 'Site\PhotoController@getPhotosAlbum'])->where('id', '[\d]+');
    });
    
    Route::get('/wishlists', ['uses' => 'Site\WishlistsController@index']);
    
    // ПОИСК
    Route::post('/search', ['uses' => 'Site\SearchController@search']);
	
    // FILES TEST
    Route::post('upload', ['uses' => 'Site\UploadController@upload']);
    
    /* КОГДА АВТОРИЗОВАНЫ */
    Route::group(['prefix' => 'auth'], function() {
        Route::get('userExist', 'AuthController@userExist');
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        
        Route::group(['middleware' => 'auth:api'], function() {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
        });
    });
    
    
    
});



/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
