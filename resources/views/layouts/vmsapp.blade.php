<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
    <base href="../">
    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>
    @yield('title')
    </title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->
    <!--end:: Global Mandatory Vendors -->
    <link href="{{asset('/')}}/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/general/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/general/morris.js/morris.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/general/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <!--end:: Global Optional Vendors -->
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('/')}}/assets/css/demo1/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('/')}}/assets/css/demo1/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/css/demo1/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/css/demo1/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/assets/css/demo1/skins/aside/dark.css" rel="stylesheet" type="text/css" />
    @yield('style')
    <link href="{{asset('/')}}/assets/vendors/custom.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset(\App\Models\Setting::first()->value('favicon'))}}" />
</head>
<!-- end::Head -->
<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        {{--<a href="demo1/index.html">--}}
            {{--<img alt="Logo" src="{{asset('/')}}/assets/media/logos/logo-light.png" />--}}
        {{--</a>--}}
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
        @include('admin.includes.aside')
        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            @include('admin.includes.header')
            @include('include.alerts')
            <!-- end:: Header -->
            <!-- begin:: Content Head -->
            @include('admin.includes.content-header')
            <!-- end:: Content Head -->
            <!-- begin:: content -->
            @yield('content')
            <!-- end:: content -->
            <!-- begin:: Footer -->
            @include('admin.includes.footer')
            <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->
<!-- begin::Sticky Toolbar -->
<ul class="kt-sticky-toolbar" style="margin-top: 30px;display:none;">
    <li class="kt-sticky-toolbar__item kt-sticky-toolbar__item--brand" data-toggle="kt-tooltip" title="Layout Builder" data-placement="left">
        <a href="#"><i class="flaticon2-gear"></i></a>
    </li>
</ul>
<!--begin:: Global Mandatory Vendors -->
<script src="{{asset('/')}}/assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/js/demo1/scripts.bundle.js" type="text/javascript"></script>
<!--end:: Global Mandatory Vendors -->
<script src="{{asset('/')}}/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/js/demo1/pages/crud/forms/widgets/select2.js" type="text/javascript"></script>
<script src="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!--end:: Global Optional Vendors -->
@if(Session::has('success'))
    <script type="text/javascript">
        swal.fire({
            type: 'success',
            title: '{{Session::get("success")}}',
            showConfirmButton: true,
            timer: 2000
        })
    </script>
  @endif
  @if(Session::has('error'))
    <script type="text/javascript">
        swal.fire({
            type: 'error',
            title: '{{Session::get("error")}}',
            showConfirmButton: true
        })
    </script>
  @endif
<script type="text/javascript">
    function deleteConfirm(id){
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                $("#"+id).submit();
            }
        })
        }
      //  Student Activation Warning -------------
    function activationConfirm(id){
          swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, active  ist!'
          }).then((result) => {
              if (result.value) {
              $("#"+id).submit();
          }
      })
      }
  </script>
@yield('script')
<!--end::Page Scripts -->
</body>
<!-- end::Body -->
</html>