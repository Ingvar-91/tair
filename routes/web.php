<?php

/*Route::get('/image', function(){
    //$img = Image::make('foo.jpg')->heighten(300)->resizeCanvas(100, 0, 'center', true);

    //$img = Image::make('1.jpg')->crop(1280, 500, 500, 0);
    $img = Image::make('1.jpg')->heighten(500);
    return $img->response('jpg');
});*/

Route::group(['domain' => '{subdomain}.'.config('app.domain')], function(){
    Route::get('/', ['uses' => 'Site\ShopsController@index'])->name('shop')->where('id', '[\d]+');
    Route::get('/filter', ['uses' => 'Site\ShopsController@index']);
});

Route::group(['domain' => config('app.domain')], function(){
    Route::get('/', ['uses' => 'Site\HomeController@index'])->name('home');

    Route::get('/about', ['uses' => 'Site\AboutController@index'])->name('about');

    Route::get('/rules', ['uses' => 'Site\RulesController@index'])->name('rules');

    Route::get('/faq', ['uses' => 'Site\FaqController@index'])->name('faq');

    Route::get('/photo', ['uses' => 'Site\PhotoController@index'])->name('photo');
    Route::get('/photo/getPhotosAlbum/{id}', ['uses' => 'Site\PhotoController@getPhotosAlbum'])->name('get.photo')->where('id', '[\d]+');

    Route::get('/category/{id}', ['uses' => 'Site\CategoriesController@index'])->name('category')->where('id', '[\d]+');

    Route::get('/video', ['uses' => 'Site\VideoController@index'])->name('video');
    Route::get('/video/nextPage', ['uses' => 'Site\VideoController@index']);

    Route::get('/wishlists', ['uses' => 'Site\WishlistsController@index'])->name('wishlists');

    Route::get('/delivery', ['uses' => 'Site\DeliveryController@index'])->name('delivery');

    Route::get('/contacts', ['uses' => 'Site\ContactsController@index'])->name('contacts');

    Route::get('/products/{category_id}', ['uses' => 'Site\ProductsController@index'])->name('products')->where('id', '[\d]+');
    Route::get('product/{id}', ['uses' => 'Site\ProductsController@product'])->name('product')->where('id', '[\d]+');
    Route::get('/filter', ['uses' => 'Site\ProductsController@index']);

    Route::get('/comments', ['uses' => 'Site\ProductCommentsController@index']);
    Route::post('/comments/add', ['uses' => 'Site\ProductCommentsController@add']);

    Route::get('/order/{id}', ['uses' => 'Site\OrderController@index'])->name('order')->where('id', '[\d]+');
    Route::post('/order/{id}', ['uses' => 'Site\OrderController@add'])->name('order.add')->where('id', '[\d]+');
    Route::get('/order/getDistricts', ['uses' => 'Site\OrderController@getDistricts']);
    Route::get('/order/getDelivery', ['uses' => 'Site\OrderController@getDelivery']);

    Route::get('/cart', ['uses' => 'Site\CartController@index'])->name('cart');

    Route::get('/compare', ['uses' => 'Site\CompareController@index'])->name('compare');

    Route::get('/search', ['uses' => 'Site\SearchController@index'])->name('search');

    Route::get('/messages', ['uses' => 'Site\MessagesController@index'])->name('messages');

    //отзывы о товаре
    Route::get('/reviews-product/{id}', ['uses' => 'Site\ReviewController@getAllReviewsProduct'])->name('reviews.product')->where('id', '[\d]+');

    //отзывы о магазине
    Route::get('/reviews-shop/{id}', ['uses' => 'Site\ReviewController@getAllReviewsShop'])->name('reviews.shop')->where('id', '[\d]+');
    
});


//авторизованный юзер
Route::group(['middleware' => 'auth'], function() {
    //профиль
    Route::get('/profile', ['uses' => 'Site\ProfileController@index'])->name('profile');
    Route::put('/profile', ['uses' => 'Site\ProfileController@edit'])->name('profile.edit');
    
    //текущие заказы
    Route::get('/current-orders', ['uses' => 'Site\OrdersController@currentOrders'])->name('current-orders');
    
    //текущий заказ
    Route::get('/current-order/{id}', ['uses' => 'Site\OrdersController@currentOrder'])->name('current-order')->where('id', '[\d]+');
    //вывести на печать текущий заказ
    Route::get('/current-order/{id}/print', ['uses' => 'Site\OrdersController@currentOrderPrint'])->name('current-order-print')->where('id', '[\d]+');
    
    //история заказов
    Route::get('/orders', ['uses' => 'Site\OrdersController@index'])->name('orders');
    
    //ОТЗЫВЫ О ТОВАРЕ
    Route::get('/reviews-products', ['uses' => 'Site\ProfileController@getAllReviewsProductsUser'])->name('review.products.user.get');
    Route::post('/review-product', ['uses' => 'Site\ReviewController@addReviewProduct'])->name('review.product.add');
    
    //ОТЗЫВЫ О МАГАЗИНЕ
    Route::get('/reviews-shops', ['uses' => 'Site\ProfileController@getAllReviewsShopsUser'])->name('review.shops.user.get');
    Route::post('/review-shop', ['uses' => 'Site\ReviewController@addReviewShop'])->name('review.shop.add');
    
    //магазины юзера
    Route::group(['prefix' => 'shops'], function(){
        //получить магазины
        Route::get('/', ['uses' => 'Site\VendorShopsController@index'])->name('vendor.shops.form');
        //добавить магазин
        //Route::get('/add', ['uses' => 'Site\VendorShopsController@addForm'])->name('vendor.shops.add.form');
        //Route::post('/add', ['uses' => 'Site\VendorShopsController@add'])->name('vendor.shops.add');
        //редактировать магазины
        Route::get('/edit', ['uses' => 'Site\VendorShopsController@editForm'])->name('vendor.shops.edit.form');
        Route::put('/edit', ['uses' => 'Site\VendorShopsController@edit'])->name('vendor.shops.edit');
    });
    
    //товары юзера
    Route::group(['prefix' => 'products-vendor'], function() {
        //товары юзера
        Route::get('/', ['uses' => 'Site\VendorProductsController@index'])->name('vendor.products.form');
        //добавить товар
        Route::get('/add', ['uses' => 'Site\VendorProductsController@addForm'])->name('vendor.products.add.form');
        Route::post('/add', ['uses' => 'Site\VendorProductsController@add'])->name('vendor.products.add');
        //редактировать товар
        Route::get('/edit', ['uses' => 'Site\VendorProductsController@editForm'])->name('vendor.products.edit.form');
        Route::put('/edit', ['uses' => 'Site\VendorProductsController@edit'])->name('vendor.products.edit');
        //добавить файл
        Route::post('/uploadFiles', ['uses' => 'Site\VendorProductsController@uploadFiles'])->name('vendor.products.uploadFiles');
        //удалить файл
        Route::delete('/removeImageProduct', ['uses' => 'Site\VendorProductsController@removeImageProduct'])->name('vendor.products.removeImageProduct');
        //мягкое удаление товара
        Route::delete('/remove', ['uses' => 'Admin\ProductsController@remove'])->name('vendor.products.remove');
    });
    
    //КАТЕГОРИИ ТОВАРОВ
    Route::group(['prefix' => 'products-vendor/categories'], function(){
        Route::get('/', ['uses' => 'Site\ProductCategoriesController@index'])->name('products-vendor.categories.form');
        Route::get('/getCategory', ['uses' => 'Site\ProductCategoriesController@getCategory']);
        Route::post('/add', ['uses' => 'Site\ProductCategoriesController@add'])->name('products-vendor.categories.add');
        Route::put('/edit', ['uses' => 'Site\ProductCategoriesController@edit'])->name('products-vendor.categories.edit');
        Route::delete('/remove', ['uses' => 'Site\ProductCategoriesController@remove'])->name('products-vendor.categories.remove');
    });
    
    //ХАРАКТЕРИСТИКИ
    Route::group(['prefix' => 'vendor-chars'], function(){
        Route::get('/chars', ['uses' => 'Site\CharsController@index']);
        //Route::post('/add', ['uses' => 'Site\CharsController@add'])->name('admin.chars.add');
        //Route::put('/edit', ['uses' => 'Site\CharsController@edit'])->name('admin.chars.edit');
        //Route::put('/editParent', ['uses' => 'Site\CharsController@editParent'])->name('admin.chars.editParent');
        //Route::delete('/removeParent', ['uses' => 'Site\CharsController@removeParent'])->name('admin.chars.removeParent');
        //Route::delete('/remove', ['uses' => 'Site\CharsController@remove'])->name('admin.chars.remove');
    });
    
});

//ПРОФИЛЬ
/*Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function() {
    Route::get('/', ['uses' => 'Site\ProfileController@index'])->name('profile');
    Route::put('/', ['uses' => 'Site\ProfileController@edit'])->name('profile.edit');
});*/

//АВТОРИЗАЦИЯ
Route::group(['prefix' => 'login', 'middleware' => 'guest'], function() {
    Route::get('/', ['uses' => 'Auth\LoginController@index'])->name('login');//форма входа для пользователя
    Route::post('/', ['uses' => 'Auth\LoginController@login']);//отправка данных для авторизации пользователя
});
//РЕГИСТРАЦИЯ
Route::group(['prefix' => 'register'], function() {
    Route::group(['middleware' => 'guest'], function() {
        Route::get('/', ['uses' => 'Auth\RegisterController@index'])->name('register');//форма регистрации
        Route::post('/', ['uses' => 'Auth\RegisterController@createUser']);//отправка данных для регистрации нового пользователя
    });
    
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/verifiMailForm', ['uses' => 'Auth\RegisterController@confirmMailForm'])->name('verifiMailForm');//форма отправки письма для верификации пользователя
        Route::post('/sendMailConfirm', ['uses' => 'Auth\RegisterController@sendMailConfirm'])->name('sendMailConfirm');//отправить письмо для верификации пользователя
    });
    Route::get('/verifi', ['uses' => 'Auth\RegisterController@verification'])->name('verifi');//верификация юзера по токену
});

//ВОССТАНОВЛЕНИЕ ПАРОЛЯ
Route::group(['prefix' => 'password', 'middleware' => 'guest'], function() {
    Route::get('/reset', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'])->name('reset.email.form');//форма ввода email для восстановления пароля
    Route::post('/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'])->name('password.reset');//отправить на почту инструкции для восстановления пароля
    Route::get('/reset/email', ['uses' => 'Auth\ResetPasswordController@showResetForm'])->name('reset.password.form');//форма сброса пароля
    Route::post('/reset', ['uses' => 'Auth\ResetPasswordController@reset'])->name('password.reset.send');//
});

//РАЗЛОГИНИТЬСЯ
Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');

//АДМИНКА
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    
    Route::get('/', ['uses' => 'Admin\HomeController@index']);
    
    //ГЛАВНЫЙ ФИЛЬТР
    Route::group(['prefix' => 'filter'], function(){
        Route::get('/', ['uses' => 'Admin\FilterController@index'])->name('admin.filter.form');
        //Route::get('/add', ['uses' => 'Admin\FilterController@addForm'])->name('admin.filter.add.form');
        //Route::get('/edit', ['uses' => 'Admin\FilterController@editForm'])->name('admin.filter.edit.form');
        //Route::post('/add', ['uses' => 'Admin\ProductsController@add'])->name('admin.products.add');
        Route::put('/edit', ['uses' => 'Admin\FilterController@edit'])->name('admin.filter.edit');
        //Route::delete('/remove', ['uses' => 'Admin\ProductsController@remove'])->name('admin.products.remove');*/
    });
     
    //ГОРОДА
    Route::group(['prefix' => 'cities'], function(){
        Route::get('/', ['uses' => 'Admin\CitiesController@index'])->name('admin.cities.form');
        Route::get('/add', ['uses' => 'Admin\CitiesController@addForm'])->name('admin.cities.add.form');
        Route::get('/edit', ['uses' => 'Admin\CitiesController@editForm'])->name('admin.cities.edit.form');
        Route::post('/add', ['uses' => 'Admin\CitiesController@add'])->name('admin.cities.add');
        Route::put('/edit', ['uses' => 'Admin\CitiesController@edit'])->name('admin.cities.edit');
        Route::delete('/remove', ['uses' => 'Admin\CitiesController@remove'])->name('admin.cities.remove');
    });
    
    //РАЙОНЫ
    Route::group(['prefix' => 'districts'], function(){
        Route::get('/', ['uses' => 'Admin\DistrictsController@index'])->name('admin.districts.form');
        Route::get('/add', ['uses' => 'Admin\DistrictsController@addForm'])->name('admin.districts.add.form');
        Route::get('/edit', ['uses' => 'Admin\DistrictsController@editForm'])->name('admin.districts.edit.form');
        Route::post('/add', ['uses' => 'Admin\DistrictsController@add'])->name('admin.districts.add');
        Route::put('/edit', ['uses' => 'Admin\DistrictsController@edit'])->name('admin.districts.edit');
        Route::delete('/remove', ['uses' => 'Admin\DistrictsController@remove'])->name('admin.districts.remove');
    });
    
    //МАГАЗИНЫ
    Route::group(['prefix' => 'shops'], function(){
        Route::get('/', ['uses' => 'Admin\ShopsController@index'])->name('admin.shops.form');
        Route::get('/add', ['uses' => 'Admin\ShopsController@addForm'])->name('admin.shops.add.form');
        Route::get('/edit', ['uses' => 'Admin\ShopsController@editForm'])->name('admin.shops.edit.form');
        Route::post('/add', ['uses' => 'Admin\ShopsController@add'])->name('admin.shops.add');
        Route::put('/edit', ['uses' => 'Admin\ShopsController@edit'])->name('admin.shops.edit');
        Route::delete('/remove', ['uses' => 'Admin\ShopsController@remove'])->name('admin.shops.remove');
        
        Route::post('/uploadFiles', ['uses' => 'Admin\ShopsController@uploadFiles']);
        Route::delete('/removeImageProduct', ['uses' => 'Admin\ShopsController@removeImageProduct']);
    });
    
    //СЛАЙДЕР
    Route::group(['prefix' => 'slider'], function(){
        Route::get('/', ['uses' => 'Admin\SliderController@index']);
        Route::post('/uploadFiles', ['uses' => 'Admin\SliderController@uploadFiles']);
        Route::delete('/removeImageProduct', ['uses' => 'Admin\SliderController@removeImageProduct']);
        Route::put('/edit', ['uses' => 'Admin\SliderController@edit']);
        /*Route::get('/add', ['uses' => 'Admin\SliderController@addForm'])->name('admin.slider.add.form');
        Route::get('/edit', ['uses' => 'Admin\SliderController@editForm'])->name('admin.slider.edit.form');
        Route::post('/add', ['uses' => 'Admin\SliderController@add'])->name('admin.slider.add');
        Route::put('/edit', ['uses' => 'Admin\SliderController@edit'])->name('admin.slider.edit');
        Route::delete('/remove', ['uses' => 'Admin\SliderController@remove'])->name('admin.slider.remove');*/
    });
    
    //POSTS - GALLERY
    /*
    Route::group(['prefix' => 'posts-gallery'], function(){
        Route::get('/', ['uses' => 'Admin\ProductsGalleryController@index'])->name('admin.posts_gallery.form');
        Route::post('/uploadFiles', ['uses' => 'Admin\ProductsGalleryController@uploadFiles'])->name('admin.posts_gallery.upload');
        Route::delete('/removeImageProduct', ['uses' => 'Admin\ProductsGalleryController@removeImageProduct'])->name('admin.posts_gallery.remove');
        Route::put('/edit', ['uses' => 'Admin\ProductsGalleryController@edit'])->name('admin.posts_gallery.edit');
    });
    */
    
    //БРЕНДЫ
    Route::group(['prefix' => 'brands'], function(){
        Route::get('/', ['uses' => 'Admin\BrandsController@index']);
        Route::post('/uploadFiles', ['uses' => 'Admin\BrandsController@uploadFiles']);
        Route::delete('/removeImageProduct', ['uses' => 'Admin\BrandsController@removeImageProduct']);
        Route::put('/edit', ['uses' => 'Admin\BrandsController@edit']);
    });
    
    //КАТЕГОРИИ МАГАЗИНОВ
    Route::group(['prefix' => 'shop_categories'], function(){
        Route::get('/', ['uses' => 'Admin\ShopCategoriesController@index'])->name('admin.shop_categories.form');
        Route::get('/add', ['uses' => 'Admin\ShopCategoriesController@addForm'])->name('admin.shop_categories.add.form');
        Route::get('/edit', ['uses' => 'Admin\ShopCategoriesController@editForm'])->name('admin.shop_categories.edit.form');
        Route::post('/add', ['uses' => 'Admin\ShopCategoriesController@add'])->name('admin.shop_categories.add');
        Route::put('/edit', ['uses' => 'Admin\ShopCategoriesController@edit'])->name('admin.shop_categories.edit');
        Route::delete('/remove', ['uses' => 'Admin\ShopCategoriesController@remove'])->name('admin.shop_categories.remove');
    });
    
    //ОТЗЫВЫ
    Route::group(['prefix' => 'reviews'], function(){
        Route::get('/', ['uses' => 'Admin\ReviewsController@index'])->name('admin.reviews.form');
        Route::delete('/remove', ['uses' => 'Admin\ReviewsController@remove'])->name('admin.reviews.remove');
        /*Route::get('/add', ['uses' => 'Admin\ShopCategoriesController@addForm'])->name('admin.shop_categories.add.form');
        Route::get('/edit', ['uses' => 'Admin\ShopCategoriesController@editForm'])->name('admin.shop_categories.edit.form');
        Route::post('/add', ['uses' => 'Admin\ShopCategoriesController@add'])->name('admin.shop_categories.add');
        Route::put('/edit', ['uses' => 'Admin\ShopCategoriesController@edit'])->name('admin.shop_categories.edit');
        Route::delete('/remove', ['uses' => 'Admin\ShopCategoriesController@remove'])->name('admin.shop_categories.remove');*/
    });
        
    //ПОЛЬЗОВАТЕЛИ
    Route::group(['prefix' => 'users'], function(){
        Route::get('/', ['uses' => 'Admin\UsersController@index'])->name('admin.users.form');
        Route::get('/add', ['uses' => 'Admin\UsersController@addForm'])->name('admin.users.add.form');
        Route::get('/edit', ['uses' => 'Admin\UsersController@editForm'])->name('admin.users.edit.form');
        Route::post('/add', ['uses' => 'Admin\UsersController@add'])->name('admin.users.add');
        Route::put('/edit', ['uses' => 'Admin\UsersController@edit'])->name('admin.users.edit');
        Route::delete('/remove', ['uses' => 'Admin\UsersController@remove'])->name('admin.users.remove');
    });

    //КОММЕНТАРИИ
    Route::group(['prefix' => 'comments'], function(){
        Route::get('/', ['uses' => 'Admin\ProductCommentsController@index'])->name('admin.comments.form');
        Route::get('/getAllHistoryComment', ['uses' => 'Admin\ProductCommentsController@getAllHistoryComment']);
        Route::get('/getComment', ['uses' => 'Admin\ProductCommentsController@getComment']);
        Route::post('/add', ['uses' => 'Admin\ProductCommentsController@add'])->name('admin.comments.add');
        Route::put('/edit', ['uses' => 'Admin\ProductCommentsController@edit'])->name('admin.comments.edit');
        Route::put('/editStatus', ['uses' => 'Admin\ProductCommentsController@editStatus']);
        Route::delete('/remove', ['uses' => 'Admin\ProductCommentsController@remove'])->name('admin.comments.remove');
    });

    //НОВОСТИ
    /*Route::group(['prefix' => 'news'], function(){
        Route::get('/', ['uses' => 'Admin\NewsController@index'])->name('admin.news.form');
        Route::get('/add', ['uses' => 'Admin\NewsController@addForm'])->name('admin.news.add.form');
        Route::get('/edit', ['uses' => 'Admin\NewsController@editForm'])->name('admin.news.edit.form');
        Route::post('/add', ['uses' => 'Admin\NewsController@add'])->name('admin.news.add');
        Route::put('/edit', ['uses' => 'Admin\NewsController@edit'])->name('admin.news.edit');
        Route::delete('/remove', ['uses' => 'Admin\NewsController@remove'])->name('admin.news.remove');
        Route::post('/addImage', ['uses' => 'Admin\NewsController@addImage']);
    });*/

    //ТОВАРЫ
    Route::group(['prefix' => 'products'], function(){
        Route::get('/getProductInfo', ['uses' => 'Admin\ProductsController@getProductInfo']);
        Route::put('/editStatus', ['uses' => 'Admin\ProductsController@editStatus']);
        Route::get('/', ['uses' => 'Admin\ProductsController@index'])->name('admin.products.form');
        Route::get('/add', ['uses' => 'Admin\ProductsController@addForm'])->name('admin.products.add.form');
        Route::get('/add-copy', ['uses' => 'Admin\ProductsController@addFormCopy'])->name('admin.products.add-copy.form');
        Route::get('/edit', ['uses' => 'Admin\ProductsController@editForm'])->name('admin.products.edit.form');
        Route::post('/add', ['uses' => 'Admin\ProductsController@add'])->name('admin.products.add');
        Route::post('/addCopy', ['uses' => 'Admin\ProductsController@addCopy'])->name('admin.products.addCopy');
        Route::put('/edit', ['uses' => 'Admin\ProductsController@edit'])->name('admin.products.edit');
        Route::delete('/remove', ['uses' => 'Admin\ProductsController@remove'])->name('admin.products.remove');
        Route::post('/uploadFiles', ['uses' => 'Admin\ProductsController@uploadFiles'])->name('admin.products.uploadFiles');
        Route::delete('/removeImageProduct', ['uses' => 'Admin\ProductsController@removeImageProduct'])->name('admin.products.removeImageProduct');
        Route::get('/getLastProduct', ['uses' => 'Admin\ProductsController@getLastProduct']);
    });
    
    //КАТЕГОРИИ ТОВАРОВ
    Route::group(['prefix' => 'categories'], function(){
        Route::get('/', ['uses' => 'Admin\ProductCategoriesController@index'])->name('admin.categories.form');
        Route::get('/getCategory', ['uses' => 'Admin\ProductCategoriesController@getCategory']);
        Route::post('/add', ['uses' => 'Admin\ProductCategoriesController@add'])->name('admin.categories.add');
        Route::post('/edit', ['uses' => 'Admin\ProductCategoriesController@edit'])->name('admin.categories.edit');
        Route::delete('/remove', ['uses' => 'Admin\ProductCategoriesController@remove'])->name('admin.categories.remove');
    });
    
    //ХАРАКТЕРИСТИКИ
    Route::group(['prefix' => 'chars'], function(){
        Route::get('/', ['uses' => 'Admin\CharsController@index'])->name('admin.chars.form');
        Route::post('/add', ['uses' => 'Admin\CharsController@add'])->name('admin.chars.add');
        Route::put('/edit', ['uses' => 'Admin\CharsController@edit'])->name('admin.chars.edit');
        Route::put('/sort', ['uses' => 'Admin\CharsController@sort'])->name('admin.chars.sort');
        Route::put('/editParent', ['uses' => 'Admin\CharsController@editParent'])->name('admin.chars.editParent');
        Route::delete('/removeParent', ['uses' => 'Admin\CharsController@removeParent'])->name('admin.chars.removeParent');
        Route::delete('/remove', ['uses' => 'Admin\CharsController@remove'])->name('admin.chars.remove');
    });

    //ЗАКАЗЫ
    Route::group(['prefix' => 'orders'], function(){
        Route::get('/', ['uses' => 'Admin\OrdersController@index'])->name('admin.orders.form');
        Route::get('/edit', ['uses' => 'Admin\OrdersController@editForm'])->name('admin.orders.edit.form');
        Route::put('/edit', ['uses' => 'Admin\OrdersController@edit'])->name('admin.orders.edit');
        Route::delete('/remove', ['uses' => 'Admin\OrdersController@remove'])->name('admin.orders.remove');
    });
    
    //ТИПЫ МАГАЗИНОВ
    Route::group(['prefix' => 'shops_type'], function(){
        Route::get('/', ['uses' => 'Admin\ShopsTypeController@index'])->name('admin.shops_type.form');
    });
    
    //History Product
    Route::group(['prefix' => 'history_product'], function(){
        Route::get('/', ['uses' => 'Admin\HistoryProductController@index']);
        
    });
    
    
    
});