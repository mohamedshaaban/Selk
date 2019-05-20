<div class="col-md-3">
    <div class="side-box-act">
        <h4>{{ __('website.my_account_label')}}</h4>
        <ul>
            <li><a class="{{ (\Request::route()->getName() == 'customer.my_profile') ? 'active' : '' }}" href="{{ route('customer.my_profile') }}">{{ __('website.my_profile_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.address_book') ? 'active' : '' }}" href="{{ route('customer.address_book') }}">{{ __('website.address_book_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.wishlist') ? 'active' : '' }}" href="{{ route('customer.wishlist') }}">{{ __('website.wish_list_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.order_history') ? 'active' : '' }}" href="{{ route('customer.order_history') }}">{{ __('website.order_history_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.order_track') ? 'active' : '' }}" href="{{ route('customer.order_track') }}">{{ __('website.track_order_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.notification_setting') ? 'active' : '' }}" href="{{ route( 'customer.notification_setting') }}">{{ __('website.notification_setting_label')}}</a></li>
            <li><a class="{{ (\Request::route()->getName() == 'customer.shop_by_interest') ? 'active' : '' }}" href="{{ route( 'customer.shop_by_interest') }}">{{ __('website.shop_by_interests')}}</a></li>
        </ul>
    </div>
</div>