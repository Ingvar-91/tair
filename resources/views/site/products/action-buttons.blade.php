<div class="actions-button">
    <div class="@if(Helper::isCart($id)) remove-cart @else add-cart @endif" data-id="{{$id}}">
        <div>
            <div class="text-block">
                <span class="icon">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                </span>
                @if(Helper::isCart($id))
                <span class="text">Убрать из корзины</span>
                @else    
                <span class="text">Добавить в корзину</span>
                @endif
            </div>
        </div>
    </div>

    <div class="@if(Helper::isWishlist($id)) remove-wishlist @else add-wishlist @endif" data-id="{{$id}}">
        <div>
            <div class="text-block">
                <span class="icon">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                </span> 
                @if(Helper::isWishlist($id))
                <span class="text">Убрать из списка</span>
                @else    
                <span class="text">Желаемые</span>
                @endif
            </div>
        </div>
    </div>

    <div class="@if(Helper::isCompare($id)) remove-compare @else add-compare @endif" data-id="{{$id}}">
        <div>
            <div class="text-block">
                <span class="icon">
                    <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                </span>
                @if(Helper::isCompare($id))
                <span class="text">Убрать из списка</span>
                @else    
                <span class="text">Сравнить</span>
                @endif
            </div>
        </div>
    </div>
</div>