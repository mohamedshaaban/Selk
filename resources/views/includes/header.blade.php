<header class="full-width">
    <div class="add_section full-width">
        <div class="container top-nav">
            <div class="pull-left">
                <a href="{{ url('/') }}">
                    <img src="/img/home.png" />
                    <span class="hidden-xs">{{
                        __("website.home_label")
                    }}</span></a
                >
                <a href="{{ route('switch_lang' , [$lang == 'en' ? 'ar' : 'en'])}}"
                    ><span class="hidden-xs">
                       {{ $lang == 'ar' ?  __("website.english_label") : __("website.arabic_label")   }}
                    </span
                    >
                    {{--  <span class="hidden-md hidden-lg hidden-sm">{{
                        __("website.en_label")
                    }}</span>  --}}
                    </a
                >
            </div>
            <div class="pull-right">
                @if(Auth::user())

                <a href="{{ route('logout') }}" class="register">{{
                    __("website.logout")
                }}</a> @else
                <a href="#" id="login-popup" data-toggle="modal" data-target="#login-reg"><span class="hidden-md hidden-lg hidden-sm"
                        ><img src="/img/account2.png" alt=""/></span
                    ><span class="hidden-xs">{{
                        __("website.login_register_label")
                    }}</span></a
                >
                @endif
                <a href="{{ route('customer.wishlist') }}"
                    ><span class="hidden-md hidden-lg hidden-sm"
                        ><img src="/img/wishlist2.png" alt=""/></span
                    ><span class="hidden-xs">{{
                        __("website.Wishlist_label")
                    }}</span></a
                >
                <a href="#" id="cartEnable" class=""
                    ><span class="hidden-md hidden-lg hidden-sm"
                        ><img src="/img/lock2.png" alt=""/></span
                    ><span class="hidden-xs">{{
                        __("website.my_cart_label")
                    }}</span></a
                >
    @include('includes.cart');
               @if(Auth::user())
                <a
                    href="{{ route('account-info') }}"
                    class="register"
                    >@else <a href="#" id="login-popup" data-toggle="modal" data-target="#login-reg">@endif<span class="hidden-md hidden-lg hidden-sm"
                        ><img src="/img/logout.png" alt=""/></span
                    ><span class="hidden-xs">{{
                        __("website.my_account_label")
                    }}</span></a
                >
            </div>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.add_section -->

    <div class="top_section full-width">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 fl_width_562 p_top_40">

                    <span>{{ __("website.choose_currency_label") }}:</span>
                    <form id="change_currency" action="{{route('change_currency')}}" method="get">
                    <select  name="currency" id="countries" style="width:80px;"
                    onchange="event.preventDefault();
                    document.getElementById('change_currency').submit();" >
                       @foreach($currencies as $currency)
                        <option
                            {{ $currency->id == $selected_currency ? 'selected' :'' }}
                            data-image="/images/flags/{{ strtolower($currency->symbol_en) . '.png'}}"
                            data-imagecss="flag kw"
                            value="{{$currency->id}}"
                            data-title="{{ $currency->symbol_en}}"
                            >&nbsp; {{ $currency->symbol_en}}</option
                        >
                      @endforeach
                    </select>
                    </form>
                    <!-- <a href="#" class="arab">{{ __("website.arabic") }}</a> -->
            </div>
            <!-- /.col-lg-4 -->
            <div class="col-lg-4 col-md-4 col-sm-4 fl_width_562 text-center">
                <a href="{{ url('/')}}">
                        <img
                            src="/img/logo.png"
                            alt="logo"
                            class="mCS_img_loaded"
                        />
                    </a>
                <!-- /.logo -->
            </div>
            <!-- /.col-lg-4 -->
            <div class="col-lg-4 col-md-4 col-sm-4 fl_width_562 p_top_40">
                <div class="search">
                    <form action="{{ route('website.product.index')}}" method="get">
                        <input autocomplete="off" id="search_input" list="possible_tags" value="{{request()->q}}" name="q" type="text" placeholder="Search here..."
                        />
                    </form>
                    <img src="/img/search.png" alt="" srcset="" />
                    <datalist id="possible_tags">

                    </datalist>
                </div>
                <!-- /.cart_box -->
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    </div>
    <!-- /.top_section -->

    <div class="navigation full-width">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse js-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/products?new=new">{{ __("website.new_label")  }}</a>
                        </li>
                        <li class="dropdown mega-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ __("website.categories_label")  }}</a
                            >
                            <ul class="dropdown-menu mega-dropdown-menu row">
                                <li
                                    class="col-lg-7 col-md-7 col-sm-12 col-xs-12"
                                >
                                    <h2>{{ __("website.categories_label")  }}</h2>
                                    <div class="row">
                                        <ul class="full-width block_elements">
                                            @foreach ($sharedCategories->where('top',1) as $category)
                                                <li class="col-lg-4 col-md-4 col-sm-4  fl_width_562">
                                                    @if($category->parent_id == 0)
                                                    <a href="{{route('website.categories.index' , ['category_id' => $category->id])}}"> {{$category->name_en}} </a>
                                                    @else
                                                    <a href="{{route('website.product.index' , ['categories' => $category->id])}}"> {{$category->name_en}} </a>                                                    
                                                    @endif
                                                </li>
                        @endforeach

                    </ul>
                </div>

                </li>
                <li class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <h2>{{ __("website.popular_now_label") }}</h2>
                    <div class="row">
                        <ul class="full-width custom_padding">

                            @foreach($popularProducts as $product)

                            <li class="col-lg-4 col-md-4 col-sm-4  for-small">
                                <a href="{{ route('website.product.show',['id'=> $product->slug_name] ) }}">
                                                    <img
                                                        src="{{ asset($product->main_image_path ) }}"
                                                        alt="image"
                                                        class="mCS_img_loaded"
                                                    />
                                                    <span>{{ $product->name }}</span>
                                                </a>
                                <!-- /.anchor_tag -->
                            </li>
                            @endforeach
                        </ul>
                        <!-- /.full-width -->
                    </div>
                    <!-- /.row -->
                </li>
                </ul>
                <!-- /.mega_dropdown_menu -->
                </li>
                <!-- /.mega-dropdown -->
                <li>
                    <a href="{{route('website.brands.index')}}">{{ __("website.brand_label")  }}</a>
                </li>

                <li>
                    <a href="{{route('website.characters.index')}}">{{ __("website.characters_label")  }}</a>
                </li>
                <li>
                    <a href="{{ route('website.product.shop_by_interest')}}">{{ __("website.shop_interest_label")  }}</a>
                </li>
                <li>
                    <a href="{{ route('user.giftCard') }}">{{ __("website.gift_card_label")  }}</a
                            >
                        </li>
                        <li>
                            <a href="{{ route('website.product.index' ,['sales' => 'sales'])}}">{{ __("website.sales_offers_label")  }}</a>
                </li>
                </ul>
        </div>
        <!-- /.nav-collapse -->

        <!-- /.search_box_cover -->
        </nav>
    </div>
    <!-- /.container -->
    </div>
    <!-- /.navigation -->
</header>
