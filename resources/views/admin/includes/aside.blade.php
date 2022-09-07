<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="{{URL::to('admin/home')}}">
                <img alt="Logo" src="{{asset(\App\Models\Setting::first()->value('favicon'))}}" style="width:50px;border-radius:50%" />
            </a>
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
								<span class="kt-svg-icon" >

										<i class="la la-angle-double-left la-2x" ></i>

                                </span>
                <span class="kt-svg-icon">
                   <i class="la la-angle-double-right la-2x" ></i>
                </span>
            </button>

            <!--
<button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
-->
        </div>
    </div>

    <!-- end:: Aside -->

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">

                @forelse($menus as $key=>$menu)

                    @canany(json_decode($menu->slug,true))
                    <li class="kt-menu__item  " aria-haspopup="true">
                        {{--activeSubMenu--}}

                        <?php
                        $menuToggle='';
                        $dropDownIcon='';
                        if (count($menu->activeSubMenu)>0)
                        {
                            $menuToggle='kt-menu__toggle';
                            $dropDownIcon="kt-menu__ver-arrow la la-angle-double-right";
                        }
                        ?>

                        <a href="{{URL::to($menu->url)}}" class="kt-menu__link {{$menuToggle}}" target="{{$menu->open_new_tab==\App\Models\Menu::OPEN_NEW_TAB? '_blank':''}}">
                            <span class="kt-menu__link-text">{{$menu->name}}</span>
                            <i class="{{$dropDownIcon}}"></i>
                        </a>

                        @if(count($menu->activeSubMenu)>0)


                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>

                                <ul class="kt-menu__subnav">
                                    @foreach($menu->activeSubMenu as $subMenu)

                                        @can(json_decode($subMenu->slug,true))
                                        <li class="kt-menu__item " aria-haspopup="true">
                                        <?php
                                        $menuToggle='';
                                        $dropDownIcon='';
                                        if (count($subMenu->activeSubSubMenu)>0)
                                        {
                                            $menuToggle='kt-menu__toggle';

                                            $dropDownIcon="kt-menu__ver-arrow la la-angle-double-right";
                                        }
                                        ?>

                                        <a href="{{URL::to($subMenu->url)}}" class="kt-menu__link {{$menuToggle}}" target="{{$subMenu->open_new_tab==\App\Models\SubMenu::OPEN_NEW_TAB? '_blank':''}}">
                                            <i class="kt-menu__link-bullet la la-angle-right">
                                            </i>
                                            <span class="kt-menu__link-text">{{$subMenu->name}}</span>

                                            <i class="{{$dropDownIcon}}"></i>

                                        </a>



                                        @if(count($subMenu->activeSubSubMenu)>0)

                                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>

                                                    <ul class="kt-menu__subnav">

                                                        @foreach($subMenu->activeSubSubMenu as $subSubMenu)
                                                            @can(json_decode($subSubMenu->slug,true))
                                                        <li class="kt-menu__item " aria-haspopup="true">
                                                            <a href="{{URL::to($subSubMenu->url)}}" class="kt-menu__link " target="{{$subSubMenu->open_new_tab==\App\Models\SubSubMenu::OPEN_NEW_TAB? '_blank':''}}">
                                                                <i class="kt-menu__link-bullet la la-angle-right">
                                                                </i>
                                                                <span class="kt-menu__link-text">{{$subSubMenu->name}}</span>
                                                            </a>
                                                        </li>
                                                            @endcan

                                                            @endforeach


                                                    </ul>
                                                </div>


                                            @endif
                                    </li>
                                        @endcan


                                        @endforeach

                                </ul>
                            </div>
                        @endif

                    </li>
                    @endcanany

                @empty

                    <li> No Menu Data</li>

                @endforelse

            </ul>
        </div>
    </div>

    <!-- end:: Aside Menu -->
</div>