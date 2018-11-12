<?php

/*SITE*/
// Home
Breadcrumbs::register('home', function($breadcrumbs){
    $breadcrumbs->push('Главная', route('home'));
});

// Home > News
Breadcrumbs::register('news', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Новости', route('news'));
});

// Home > News > Post
Breadcrumbs::register('news.post', function($breadcrumbs, $post){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Новости', route('news'));
    $breadcrumbs->push($post->title, route('news.post', ['id' => $post->id]));
});

// Home > Shop
Breadcrumbs::register('shop', function($breadcrumbs, $shop){
    $breadcrumbs->parent('home');
    $breadcrumbs->push($shop->title, route('shop', ['id' => $shop->id]));
});

// Home > About
Breadcrumbs::register('about', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('О нас', route('about'));
});

// Home > Faq
Breadcrumbs::register('faq', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Пользовательское соглашение', route('faq'));
});

// Home > rules
Breadcrumbs::register('rules', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Политика конфиденциальности', route('rules'));
});

// Home > Contacts
Breadcrumbs::register('contacts', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Контакты', route('contacts'));
});

// Home > Search
Breadcrumbs::register('search', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Результат поиска', route('search'));
});

// Home > Profile
Breadcrumbs::register('profile', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Профиль', route('profile'));
});

// Home > reviews-shops
Breadcrumbs::register('reviews-shops', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои отзывы о магазине', route('review.shops.user.get'));
});

// Home > reviews-product
Breadcrumbs::register('reviews-product', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои отзывы о товаре', route('review.products.user.get'));
});

// Home > current-orders
Breadcrumbs::register('current-orders', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Текущие заказы', route('current-orders'));
});

// Home > current-order
Breadcrumbs::register('current-order', function($breadcrumbs, $order){
    $breadcrumbs->parent('home');
    if($order->status == 1){
        $breadcrumbs->push('Текущие заказы', route('current-orders'));
    }
    elseif($order->status == 2){
        $breadcrumbs->push('Текущие заказы', route('current-orders'));
    }
    elseif($order->status == 3){
        $breadcrumbs->push('История заказов', route('orders'));
    }
    elseif($order->status == 4){
        $breadcrumbs->push('История заказов', route('orders'));
    }
    $breadcrumbs->push('Заказ №'.str_pad($order->id, 6, '0', STR_PAD_LEFT), route('current-order', ['id' => $order->id]));
});

// Home > Orders
Breadcrumbs::register('orders', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('История заказов', route('orders'));
});

// Home > Delivery
Breadcrumbs::register('delivery', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Доставка', route('delivery'));
});

// Home > Login
Breadcrumbs::register('login', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Форма входа', route('login'));
});

// Home > reset.password
Breadcrumbs::register('reset.password.form', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Назначить новый пароль', route('reset.password.form'));
});

// Home > reset.email
Breadcrumbs::register('reset.email.form', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Восстановление пароля', route('reset.email.form'));
});

// Home > Register
Breadcrumbs::register('register', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Форма регистрации', route('register'));
});

// Home > Wishlists
Breadcrumbs::register('wishlists', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Желаемые товары', route('wishlists'));
});

// Home > Сompare
Breadcrumbs::register('compare', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Желаемые товары', route('compare'));
});

// Home > Products > Product
Breadcrumbs::register('product', function($breadcrumbs, $product, $categories){
    $breadcrumbs->parent('home');
    foreach ($categories as $category) {
        $breadcrumbs->push($category->title, route('category', ['id' => $category->id]));
    }
    $breadcrumbs->push($product->title, route('product', ['product_id' => $product->id, 'category_id' => $product->category_id]));
});

// Home > Cart
Breadcrumbs::register('cart', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Корзина', route('cart'));
});

// Home > Order
Breadcrumbs::register('order', function($breadcrumbs, $shop){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Оформление заказа', route('order', ['id' => $shop->shop_id]));
});

// Home > Shops
Breadcrumbs::register('shops', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои магазины', route('vendor.shops.form'));
});

// Home > Shops > Edit
Breadcrumbs::register('shops.edit', function($breadcrumbs, $shop){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои магазины', route('vendor.shops.form'));
    $breadcrumbs->push('Редактировать - '.$shop->title, route('vendor.shops.edit.form'));
});

// Home > Products
Breadcrumbs::register('vendor.products.form', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои магазины', route('vendor.shops.form'));
    $breadcrumbs->push('Мои товары', route('vendor.products.form'));
});

// Home > Products > Add
Breadcrumbs::register('vendor.products.add.form', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои магазины', route('vendor.shops.form'));
    $breadcrumbs->push('Добавить товар', route('vendor.products.add.form'));
});

// Home > Products > Edit
Breadcrumbs::register('vendor.products.edit.form', function($breadcrumbs, $product){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Мои магазины', route('vendor.shops.form'));
    $breadcrumbs->push('Мои товары', route('vendor.products.form', ['shop_id' => $product->shop_id]));
    $breadcrumbs->push($product->title, route('vendor.products.edit.form'));
});



// Home > reviews.product
Breadcrumbs::register('reviews.product', function($breadcrumbs, $product){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Отзывы о товаре', route('reviews.product', ['id' => $product->id]));
});

// Home > reviews.shop
Breadcrumbs::register('reviews.shop', function($breadcrumbs, $shop){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Отзывы о магазине', route('reviews.shop', ['id' => $shop->id]));
});

// Home > Photo
Breadcrumbs::register('photo', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Фотогалерея', route('photo'));
});

// Home > Photo-Album
Breadcrumbs::register('photoAlbum', function($breadcrumbs, $data){
    $breadcrumbs->parent('photo');
    $breadcrumbs->push($data['title'], route('get.photo', ['id' => $data['album_id']]));
});

// Home > Video
Breadcrumbs::register('video', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Видеогалерея', route('video'));
});

/*ADMIN*/
//users
Breadcrumbs::register('admin.users.form', function($breadcrumbs){
    $breadcrumbs->push('Пользователи', route('admin.users.form'));
});

Breadcrumbs::register('admin.users.edit.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.users.form');
    $breadcrumbs->push('Редактировать пользователя', route('admin.users.edit.form'));
});

Breadcrumbs::register('admin.users.add.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.users.form');
    $breadcrumbs->push('Добавить пользователя', route('admin.users.add.form'));
});

//comments
Breadcrumbs::register('admin.comments.form', function($breadcrumbs){
    $breadcrumbs->push('Комментарии', route('admin.comments.form'));
});

//news
Breadcrumbs::register('admin.news.form', function($breadcrumbs){
    $breadcrumbs->push('Новости', route('admin.news.form'));
});

Breadcrumbs::register('admin.news.edit.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.news.form');
    $breadcrumbs->push('Редактировать новость', route('admin.news.edit.form'));
});

Breadcrumbs::register('admin.news.add.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.news.form');
    $breadcrumbs->push('Добавить новость', route('admin.news.add.form'));
});

Breadcrumbs::register('products', function($breadcrumbs, $categories){
    $breadcrumbs->parent('home');
    foreach ($categories as $category) {
        $breadcrumbs->push($category->title, route('category', ['id' => $category->id]));
    }
});

//products
Breadcrumbs::register('admin.products.form', function($breadcrumbs){
    $breadcrumbs->push('Товары', route('admin.products.form'));
});

Breadcrumbs::register('admin.products.edit.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.products.form');
    $breadcrumbs->push('Редактировать товар', route('admin.products.edit.form'));
});

Breadcrumbs::register('admin.products.add.form', function($breadcrumbs){
    $breadcrumbs->parent('admin.products.form');
    $breadcrumbs->push('Добавить товар', route('admin.products.add.form'));
});

//orders
Breadcrumbs::register('admin.orders.form', function($breadcrumbs){
    $breadcrumbs->push('Заказы', route('admin.orders.form'));
});


/*
// Home > Blog
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});
*/

/*ADMIN*/

