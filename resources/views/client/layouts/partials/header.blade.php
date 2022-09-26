<header id="header" class=" variant typeheader-2">

    {{--Header data came fromm AppServiceProvider--}}
    <div class="header-bottom hidden-compact navbar-fixed-top">
        <div class="container">
            <div class="row">
                <div class="bottom1 menu-vertical col-lg-2 col-md-3">
                    <div class="responsive megamenu-style-dev">
                        <div class="so-vertical-menu no-gutter">

                            <nav class="navbar-default">
                                <div class=" container-megamenu  container   vertical  ">
                                    <div id="menuHeading">
                                        <div class="megamenuToogle-wrapper">
                                            <div class="megamenuToogle-pattern">
                                                <div class="container">
                                                    <div><span></span><span></span><span></span></div>
                                                    {{__('frontend.All Departments')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="navbar-header">
                                        <button type="button" id="show-verticalmenu" data-toggle="collapse"  class="navbar-toggle">
                                            <i class="fa fa-bars"></i>
                                            <span>  {{__('frontend.All Departments')}}</span>
                                        </button>
                                    </div>

                                    <div class="vertical-wrapper">

                                        <span id="remove-verticalmenu" class="fa fa-times"></span>

                                        <div class="megamenu-pattern">
                                            <div class="container">
                                                <ul class="megamenu"
                                                    data-transition="slide" data-animationtime="300">
                                                    @forelse($menus as $key=>$menu)
                                                        <?php
                                                        $dropDownIcon='';
                                                        $subMenu=count($menu->activeClientSubMenu);
                                                        if ($subMenu>0){$dropDownIcon='fa fa-angle-right';}
                                                        ?>
                                                        <li class="item-vertical  item-style2 with-sub-menu hover" >
                                                            <p class='close-menu'></p>
                                                            <a href="{{url($menu->url)}}" class="clearfix" >
                                                                <span><strong>{{$menu->name_bn}}</strong></span>
                                                                <b class="{{$dropDownIcon}}" ></b>
                                                            </a>
                                                            @if($subMenu>0)
                                                                <div class="sub-menu" style="width:720px">

                                                                    <div class="content">
                                                                        <div class="row">
                                                                            @foreach($menu->activeClientSubMenu->chunk(10) as $subMenuData)
                                                                                <div class="col-sm-4">
                                                                                    <ul class="subcategory ">
                                                                                        @foreach($subMenuData as $key=>$sData)
                                                                                            <li>
                                                                                                <a href="{{url($sData->url)}}" class="title-submenu ">
                                                                                                    {{$sData->name_bn}}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div><!-- end col-4 submenu -->
                                                                            @endforeach
                                                                        </div> <!-- end row -->
                                                                        <div class="border"></div>
                                                                        <!--another row-->
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </li>

                                                    @empty
                                                        <li class="item-vertical " >
                                                            <p class='close-menu'></p>
                                                            <a href="javascript:;" class="clearfix" >
                                                                <span>
                                                                    <strong>
                                                                    {{__('frontend.No Data Found')}}
                                                                    </strong>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="main-menu-w col-lg-10 col-md-9">
                    <div class="responsive megamenu-style-dev">
                        <nav class="navbar-default">
                            <div class=" container-megamenu   horizontal ">
                                <div class="navbar-header">
                                    <button type="button" id="show-megamenu" data-toggle="collapse"  class="navbar-toggle">
                                        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="megamenu-wrapper">
                                    <span id="remove-megamenu" class="fa fa-times"></span>
                                    <div class="megamenu-pattern">
                                        <div class="container">
                                            <ul class="megamenu"
                                                data-transition="slide" data-animationtime="500">
                                                <li class="home">
                                                    @if(Auth::check())
                                                        <a href="{{URL::to('/account/account')}}"><span><strong> {{__('frontend.My Account')}} </strong></span></a>
                                                    @else
                                                        <a href="{{URL::to('/')}}"><span><strong>   {{__('frontend.Home')}}   </strong></span></a>
                                                    @endif
                                                </li>
                                                @forelse($menus as $key=>$menu)
                                                    <?php
                                                    $dropDownIcon='';
                                                    $subMenu=count($menu->activeClientSubMenu);

                                                    if ($subMenu>0){$dropDownIcon='caret';}
                                                    ?>
                                                    <li class=" item-style2 with-sub-menu hover">
                                                        <p class='close-menu'></p>
                                                        <a href="{{URL::to($menu->url)}}" class="clearfix" ><strong> {{$menu->name_bn}} </strong><b class="{{$dropDownIcon}}"></b></a>
                                                        @if($subMenu>0)
                                                            <div class="sub-menu" style="width:100%;">
                                                                <div class="content">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="categories ">
                                                                                <div class="row">
                                                                                    @foreach($menu->activeClientSubMenu->chunk(14) as $subMenuInfo)
                                                                                        <div class="col-sm-3 col-md-3 static-menu">
                                                                                            <div class="menu">
                                                                                                <ul>
                                                                                                    @foreach($subMenuInfo as $key=>$subMenu)
                                                                                                        <li> <a href="{{URL::to($subMenu->url)}}" class="">{{$subMenu->name_bn}}</a></li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end row-->
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @empty
                                                @endforelse

                                                {{--Header data came fromm AppServiceProvider--}}

                                                @if(Auth::check())
                                                    <li class="item-special pull-right"> <a href="{{URL::to('account/account')}}" style="font-weight: 600;font-size: 15px;"  class="clearfix">{{auth()->user()->name}}
                                                            {{--@if(isset(auth()->user()->profile->avatar))--}}
                                                                {{--<img id="image_load" src="{{asset(auth()->user()->profile->avatar)}}" style="width: 20px;border-radius:50%;cursor:pointer">--}}
                                                            {{--@else--}}
                                                                {{--<img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 20px;border-radius:50%;cursor:pointer">--}}

                                                            {{--@endif--}}
                                                        </a>
                                                    </li>

                                                    <li class="item-special pull-right">
                                                        <a href="javascript:void(0)" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"  class="clearfix">
                                                            {{--<i class="fa fa-sign-out"></i>--}}
                                                            {{__('frontend.Sign Out')}} &nbsp; |</a>
                                                    </li>

                                                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                @else

                                                    <li class="item-special pull-right"> <a href="{{URL::to('/register.html')}}"  class="clearfix">
                                                            {{--<i class="fa fa-user"></i>--}}
                                                            {{__('frontend.Register')}}</a></li>

                                                    <li class="item-special pull-right"><a href="#" data-target="#so_sociallogin" data-toggle="modal"  class="clearfix">
                                                            {{--<i class="fa fa-sign-in"></i>--}}
                                                            {{__('frontend.Login')}}&nbsp; |</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-top hidden-compact">
        <div class="container">

            <div class="row">

                <div class="header-top-right col-lg-12 col-md-12 col-sm-6 col-xs-6">

                    {{--Header data came fromm AppServiceProvider--}}

                    {{--<div class="pull-right telephone hidden-xs hidden-sm hidden-md" >--}}
                        {{--<ul>--}}
                            {{--<li><i class="fa fa-envelope"></i>Email: {{$setting->email1}}</li>--}}
                            {{--<li><i class="fa fa-phone"></i>Hotline: {{$setting->mobile_no1}}</li>--}}
                            {{--@if(Auth::check())--}}
                                {{--<li> <a href="{{URL::to('account/account')}}" style="font-weight: 600;font-size: 15px;">{{auth()->user()->name}}--}}
                                        {{--@if(isset(auth()->user()->profile->avatar))--}}
                                            {{--<img id="image_load" src="{{asset(auth()->user()->profile->avatar)}}" style="width: 30px;border-radius:50%;cursor:pointer">--}}
                                        {{--@else--}}
                                            {{--<img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 30px;border-radius:50%;cursor:pointer">--}}

                                        {{--@endif--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:void(0)" onclick="event.preventDefault();--}}
                                        {{--document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i> Sign Out</a>--}}
                                {{--</li>--}}

                                {{--<form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--@else--}}
                                {{--<li><a href="#" data-target="#so_sociallogin" data-toggle="modal"><i class="fa fa-user-o"></i> Login</a></li>--}}
                                {{--<li> <a href="{{URL::to('/register.html')}}">Register</a></li>--}}
                            {{--@endif--}}

                        {{--</ul>--}}
                    {{--</div>--}}

                    <div class="hidden-lg account" id="my_account" style="margin-top: 40px;"> <!-- for mobile -->

                        @if(Auth::check())
                            <a href="" title="My Account " class="btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-caret-down"> {{auth()->user()->name}}</span></a>
                            @else
                            <a href="{{URL::to('/register.html')}}" title="My Account " class="btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-caret-down">{{__('frontend.My Account')}}</span></a>
                        @endif

                        <ul class="dropdown-menu ">

                            @if(Auth::check())
                                <li><a href="{{URL::to('/')}}"  title="Continue Shopping "> {{__('frontend.Continue Shopping')}}</a></li>
                                <li><a href="{{URL::to('/cart-products')}}"  title="View Shopping Cart"><i class="fa fa-cart-plus"></i> {{__('frontend.View Shopping Cart')}}</a></li>
                                <li><a href="{{URL::to('/wish-list-products')}}"  title="View Wishlist"><i class="fa fa-cart-plus"></i> {{__("frontend.View Wishlist")}}</a></li>
                                <li><a href="{{URL::to('/orders/history')}}"  title="Change Password"><i class="fa fa-archive"></i> {{__("frontend.Order History")}}</a></li>
                                <li><a href="{{URL::to('/account/profile')}}"  title="Edit Profile"><i class="fa fa-pencil"></i> {{__('frontend.Edit Profile')}}</a></li>
                                <li><a href="{{URL::to('/account/password')}}"  title="Change Password"><i class="fa fa-key"></i> {{__('frontend.Change Password')}}</a></li>
                                <a href="javascript:void(0)" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i> {{__('frontend.Sign Out')}}</a>

                                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                            <li><a href="#" data-target="#so_sociallogin" data-toggle="modal">{{__('frontend.Login')}}</a> </li>
                            <li><a href="{{URL::to('/register.html')}}">{{__('frontend.Register')}}</a></li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="header-middle ">
        <div class="container">
            <div class="row">
                <div class="navbar-logo col-lg-2 col-md-3 col-sm-12 col-xs-12">
                    <div class="logo">
                        <a href="{{URL::to('/')}}">
                            <img class="lazyload"  src="{{asset($setting->logo)}}" data-src="{{asset($setting->logo)}}" title="{{$setting->company_name}} " alt="{{$setting->company_name}}" style="width: 150px;margin-top: 0px" /></a>
                    </div>
                </div>

                <div class="middle2 col-lg-8 col-md-8 col-sm-6 col-xs-6">
                    <div class="search-header-w">
                        <div class="icon-search hidden-lg hidden-md"><i class="fa fa-search"></i></div>

                        <div id="sosearchpro" class="sosearchpro-wrapper so-search ">

                            <form method="GET" action="{{route('book.search')}}" id="productSearch">
                                <div id="search0" class="search input-group form-group">

                                    <div class="select_category filter_type  icon-select hidden-sm hidden-xs">
                                        <select class="no-border" name="category_id">
                                            <option value="">{{__('frontend.All Departments')}} </option>
                                            @forelse($categories as $key=>$categoryData)
                                                <option value="{{$categoryData->id}}">{{$categoryData->category_name_bn}} </option>
                                                @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <input class="autosearch-input form-control" type="search" value="{{old('search',isset($request)?$request->search:'')}}" autocomplete="off" placeholder="{{__('frontend.Search here')}}..." name="search">

                                    <button type="submit" class="button-search btn btn-default btn-lg" name="submit_search"><i class="fa fa-search"></i><span>{{__('frontend.Search')}}</span></button>
                                </div>
                                <input type="hidden" name="route" value="product/search"/>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="middle3 col-lg-2 col-md-2 col-sm-6 col-xs-6">
                    <div class="shopping_cart">
                        <div id="cart" class="btn-shopping-cart">
                            <?php $currency=$setting->currency;?>
                            @if(count($cartProducts)>0)
                                <ul class="dropdown-menu pull-right shoppingcart-box">
                                    <li class="content-item">
                                        <table class="table table-striped" style="margin-bottom:10px;">
                                            <tbody>
                                            <?php $totalAmount=0;?>
                                            @foreach($cartProducts as $cartProduct)
                                                <tr>
                                                    <td class="text-center size-img-cart">
                                                        <a href="">
                                                            <img class="img-thumbnail lazyautosizes lazyloaded" data-sizes="auto" src="{{asset($cartProduct->product_image)}}" data-src="{{asset($cartProduct->product_image)}}" alt="{{$cartProduct->product_name}}" title="{{$cartProduct->product_name}}" sizes="57px"></a>
                                                    </td>
                                                    <td class="text-left"><a href="">{{$cartProduct->product_name}}</a>
                                                    </td>
                                                    <td class="text-right">x {{$cartProduct->qty}}</td>
                                                    <td class="text-right"> {{$currency.$cartProduct->qty*$cartProduct->price}}</td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-xs" title="Remove"
                                                           onclick="event.preventDefault();
                                    document.getElementById({{$cartProduct->id}}).submit();"><i class="fa fa-trash-o"></i> </a>

                                                        {!! Form::open(array('route' => ['cart-products.destroy',$cartProduct->id],'method'=>'DELETE','id'=>"$cartProduct->id")) !!}
                                                        <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$cartProduct->id}}")'><i class="la la-trash"></i></button>
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>

                                                <?php $totalAmount+=$cartProduct->qty*$cartProduct->price;?>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </li>

                                    <li>
                                        <div class="checkout clearfix">
                                            <a href="{{route('cart-products.index')}}" class="btn btn-view-cart btn-sm inverse"> View Cart</a>
                                            <a href="{{URL::to('wish-list-products')}}" class="btn btn-warning btn-sm "> Wishlist</a>
                                            @if(Auth::check())
                                                <a href="{{URL::to('/checkout/checkout')}}" class="btn btn-checkout btn-sm pull-right">Checkout</a>
                                                @else
                                                <a href="{{URL::to('/checkout/checkout')}}" class="btn btn-checkout btn-sm pull-right"  data-target="#so_sociallogin" data-toggle="modal" >Checkout</a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>

                            <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                                <div class="shopcart">
										  <span class="icon-c">
											<i class="fa fa-shopping-bag"></i>
										  </span>
                                    <div class="shopcart-inner">
                                        <p class="text-shopping-cart">
                                            {{__('frontend.My cart')}}
                                        </p>


                                        <span class="total-shopping-cart cart-total-full">
                                            <span class="items_cart">{{$cartProducts->count('qty')}}</span>
                                            <span class="items_cart2"> item(s)</span>
                                            <span class="items_carts">({{$currency}}:{{$totalAmount}} )</span>
                                        </span>

                                    </div>
                                </div>
                            </a>


                                @else
                                <a data-loading-text="Loading... " class="btn-group top_cart dropdown-toggle" data-toggle="dropdown">
                                    <div class="shopcart">
										  <span class="icon-c">
											<i class="fa fa-shopping-bag"></i>
										  </span>
                                        <div class="shopcart-inner">
                                            <p class="text-shopping-cart">
                                                {{__('frontend.My cart')}}
                                            </p>


                                            <span class="total-shopping-cart cart-total-full">
                                            <span class="items_cart">0</span>
                                            <span class="items_cart2"> item(s)</span>
                                            <span class="items_carts">(0.0 )</span>
                                        </span>

                                        </div>
                                    </div>
                                </a>
                                    <ul class="dropdown-menu pull-right shoppingcart-box">
                                        <li>
                                            <p class="text-center empty">{{__('frontend.Your shopping cart is empty')}}!</p>
                                        </li>
                                    </ul>
                                @endif
                        </div>

                    </div>
                    <ul class="login-w hidden-md hidden-sm hidden-xs hidden-md hidden-lg">
                        @if(Auth::check())
                        <li><a href="{{URL::to('/account/account')}}"> <span> {{substr(auth()->user()->name,0,16)}}</span> </a></li>
                        <li class="logout">


                            <a href="javascript:void(0)" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i>{{__('frontend.Sign Out')}} </a>

                            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                @csrf
                            </form>


                        </li>
                        @else{{__('frontend.My Account')}}
                            <li><a href="{{URL::to('/account/account')}}"><span>{{__('frontend.My Account')}}</span></a></li>
                            <li class="logout">
                                <a href="javascript:void(0)"> <i class="fa fa-sign-in"></i> </a>

                                <a href="#" data-target="#so_sociallogin" data-toggle="modal" >{{__('frontend.Login')}}</a>/<a href="{{URL::to('/register.html')}}">{{__('frontend.Register')}}</a>


                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <!-- main menu was here -->

    <div class="modal fade in" id="so_sociallogin" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog block-popup-login">
            <a href="javascript:void(0)" title="Close" class="close close-login fa fa-times-circle" data-dismiss="modal"></a>
            <div class="tt_popup_login"><strong>Sign in Or Register</strong></div>
            <div class="block-content">
                <div class=" col-reg registered-account">
                    <div class="block-content">
                        <form class="form form-login" action="{{route('login')}}" method="POST" id="login-form">
                            @csrf
                            <fieldset class="fieldset login" data-hasrequired="* Required Fields">
                                <div class="field email required email-input">
                                    <div class="control">
                                        <input type="text" name="mobile" autocomplete="off" id="email" class="input-text" required title="Email / Mobile" placeholder="Email / Mobile">
                                        @if ($errors->has('mobile'))
                                            <span class="help-block">
                                            <strong class="text-warning text-center">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                        @endif
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="field password required pass-input">
                                    <div class="control">
                                        <input name="password" type="password" autocomplete="off" required class="input-text" id="pass" title="Password" placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong class="text-warning">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="secondary ft-link-p"><a class="action remind" href="#"><span>Forgot Your Password?</span></a></div>
                                <div class="actions-toolbar">
                                    <div class="primary"><button type="submit" class="action login primary" name="send" id="send2"><span>Login</span></button></div>
                                </div>
                                <div class=" form-group" style="display:none;">
                                    <label class="control-label">Login with your social account</label>
                                    <div>
                                        <a href="#" class="btn btn-social-icon btn-sm btn-google-plus"><i class="fa fa-google fa-fw" aria-hidden="true"></i></a>
                                        <a href="" class="btn btn-social-icon btn-sm btn-facebook"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>
                                        <a href="" class="btn btn-social-icon btn-sm btn-twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>
                                        <a href="" class="btn btn-social-icon btn-sm btn-linkdin"><i class="fa fa-linkedin fa-fw" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="col-reg login-customer">
                    <h2>NEW HERE?</h2>
                    <p class="note-reg">Registration is free and easy!</p>
                    <ul class="list-log">
                        <li>Faster checkout</li>
                        <li>Save shipping addresses</li>
                        <li>View and track orders and more</li>
                    </ul>
                    <a href="{{URL::to('/register.html')}}" class="btn-reg-popup" title="Register">Create an account</a>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div> <!-- end login -->


</header>