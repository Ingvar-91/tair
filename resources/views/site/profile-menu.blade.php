<div class="">
    <div class="list-group" id="orders-menu">
        @if(Auth::check() and (Auth::user()->role == 3))
            <a href="{{Route('vendor.shops.form')}}" class="list-group-item @if(request()->is('shops')) active @endif"> <i class="fa fa-shopping-bag"></i> Мои магазины</a>
        @endif
        <a href="{{Route('profile')}}" class="list-group-item @if (request()->is('profile')) active @endif"><i class="fa fa-address-card-o" aria-hidden="true"></i> Личные данные</a>
        <a href="{{Route('current-orders')}}" class="list-group-item @if (request()->is('current-orders')) active @endif"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Текущие заказы</a>
        <a href="{{Route('orders')}}" class="list-group-item @if (request()->is('orders')) active @endif"><i class="fa fa-file-text-o" aria-hidden="true"></i> История заказов</a>
        <a href="{{Route('review.products.user.get')}}" class="list-group-item @if (request()->is('reviews-products')) active @endif"><i class="fa fa-comments-o" aria-hidden="true"></i>Мои отзывы о товарах</a>
        <a href="{{Route('review.shops.user.get')}}" class="list-group-item @if (request()->is('reviews-shops')) active @endif"><i class="fa fa-comments" aria-hidden="true"></i>Мои отзывы о магазинах</a>
    </div>
</div>