<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>Admin Login | {{\App\Models\Setting::first()->value('company_name')}}</title>
    <meta name="description" content="{{\App\Models\Setting::first()->value('company_slogan')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />

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
    <link href="{{asset('/')}}/assets/css/demo1/pages/login/login-4.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('/')}}/assets/css/demo1/style.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="{{asset('/public')}}/assets/media/logos/favicon.ico" />

    <style>
        body{
            background-color: #009688;
        }
    </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body >

<!-- begin:: Page -->
@yield('content')

<!-- end:: Page -->

<script src="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>


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
</body>

<!-- end::Body -->
</html>