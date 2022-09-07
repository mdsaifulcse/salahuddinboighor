
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('head')
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/soconfig/css/lib.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/ie9-and-up.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/custom.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_categories/css/so-categories.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_call_for_price/css/jquery.fancybox.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_call_for_price/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_category_slider/css/slider.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_page_builder/css/style_render_38.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_page_builder/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_countdown/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_tools/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_newletter_custom_popup/css/style.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_page_builder/css/style_render_45.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_megamenu/so_megamenu.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_megamenu/wide-grid.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_searchpro/css/so_searchpro.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/so_sociallogin/css/so_sociallogin.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/layout2/orange.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/header/header2.css">
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/footer/footer2.css">
    <link href="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('/client/assets')}}/theme/so-supermarket/css/responsive.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet' type='text/css'>
    <style type="text/css">body, #wrapper{font-family:'Poppins', sans-serif}</style>
    <link  type="image/png" sizes="96x96" href="{{asset($setting->favicon)}}" rel="icon" />
    @yield('style')
</head>

<body class="common-home ltr layout-2">
<div id="wrapper" class="wrapper-fluid banners-effect-5">
<div class="so-pre-loader no-pre-loader"><div class="so-loader-line" id="line-load"></div></div>
@include('client.layouts.partials.header')
@yield('content')
 @include('client.layouts.partials.footer')
    <div class="back-to-top"><i class="fa fa-angle-up"></i></div>
</div>
<script src="{{asset('/client/assets')}}/javascript/jquery/jquery-2.1.1.min.js"></script>
<script src="{{asset('/client/assets')}}/javascript/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('/client/assets')}}/javascript/soconfig/js/libs.js"></script>
<script src="{{asset('/client/assets')}}/javascript/soconfig/js/so.system.js"></script>
<script src="{{asset('/client/assets')}}/javascript/soconfig/js/jquery.sticky-kit.min.js"></script>
<script src="{{asset('/client/assets')}}/javascript/lazysizes/lazysizes.min.js"></script>
<script src="{{asset('/client/assets')}}/theme/so-supermarket/js/so.custom.js"></script>
<script src="{{asset('/client/assets')}}/theme/so-supermarket/js/common.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_call_for_price/js/jquery.fancybox.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_call_for_price/js/script.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_page_builder/js/section.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_page_builder/js/modernizr.video.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_page_builder/js/swfobject.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_page_builder/js/video_background.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_countdown/js/jquery.cookie.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_tools/js/script.js"></script>
<script src="{{asset('/client/assets')}}/javascript/so_megamenu/so_megamenu.js"></script>
<script src="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
<!--end:: Global Optional Vendors -->
@if(Session::has('success'))
    <script type="text/javascript">
        swal.fire({
            type: 'success',
            title: '{{Session::get("success")}}',
            showConfirmButton: true,
            timer: 4000
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

</body>
</html>