<p>{{$nameSite}}</p>
<p>
    Был добавлен или отредактирован товар в магазине: <a href="{{Route('shop', ['id' => $shopId])}}">{{$shopName}}</a>
</p>
<p>
    Ссылка на товар в админ панели - <a href="{{Route('admin.products.edit', ['id' => $product_id, 'shop_type' => $shop_type_id])}}">Ссылка на товар</a>
</p>
<p>
    Ссылка на товар на сайте - <a href="{{Route('product', ['id' => $product_id])}}">Ссылка на товар</a>
</p>