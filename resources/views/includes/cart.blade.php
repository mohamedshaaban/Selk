<div class="cart_box" id="cart_bx">
    <cart-dropdown :currency="{{$currencies->where('id',$selected_currency)->first()}}"></cart-dropdown>
    <a href="/checkout/my_cart" class="button-crt" type="button">{{ __("website.view_shopping_label") }}
        </a>
</div>