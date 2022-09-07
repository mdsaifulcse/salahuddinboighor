<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title"> @yield('subheader')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                <h3> @yield('subheader-content') </h3>

            <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="flaticon2-search-1"></i></span>
                        </span>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">

                @yield('subheader-action')


            </div>
        </div>
    </div>
</div>

<!-- end:: Content Head -->