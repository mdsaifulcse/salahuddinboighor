<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="demo1/index.html">
                <img alt="Logo" src="{{asset('/')}}/assets/media/logos/logo-light.png" />
            </a>
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">


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
                <li class="kt-menu__item  kt-menu__item--active" aria-haspopup="true">
                    <a href="{{URL::to('/home')}}" class="kt-menu__link ">
                        <span class="kt-menu__link-text">Dashboard</span>
                    </a>
                </li>


                <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">

                        <span class="kt-menu__link-text">Applications</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>

                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">

                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                <span class="kt-menu__link">
                                    <span class="kt-menu__link-text">Applications</span>
                                </span>
                            </li>

                            <li class="kt-menu__item " aria-haspopup="true">
                                <a href="{{URL::to('vehicle')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet la la-angle-double-right">
                                            </i> <span class="kt-menu__link-text"> Vehicle</span>

                                </a>
                            </li>

                            <li class="kt-menu__item " aria-haspopup="true">
                                <a href="{{URL::to('users')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet la la-angle-double-right">
                                       </i> <span class="kt-menu__link-text"> Users</span>
                                </a>
                            </li>

                            <li class="kt-menu__item " aria-haspopup="true">
                                <a href="{{URL::to('roles')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet la la-angle-double-right">
                                        </i> <span class="kt-menu__link-text"> Role</span>
                                </a>
                            </li>

                            <li class="kt-menu__item " aria-haspopup="true">
                                <a href="{{URL::to('permission')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet la la-angle-double-right">
                                        </i> <span class="kt-menu__link-text"> Permission</span>
                                </a>
                            </li>

                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <span class="kt-menu__link-text">Users</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>

                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="#" class="kt-menu__link ">
                                                <i class="kt-menu__link-bullet la la-angle-double-right"></i>
                                                <span class="kt-menu__link-text">Edit User</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>

                </li>
            </ul>
        </div>
    </div>

    <!-- end:: Aside Menu -->

</div>