
<!DOCTYPE html>
<html lang="en">
<head>
    <title> {{$setting->company_name}} | khujlei paibaa </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href=""/>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{asset('/client/assets')}}/javascript/bootstrap/css/bootstrap.min.css">
    <link href="{{asset('/')}}/assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i" rel="stylesheet">

</head>
<body>

<style>
    .paddingBottom{
        padding-bottom: 20px;
    }
    .register-form{
        padding: 50px;
    }
    .register-form .only-border-bottom{
        border: none;
        border-bottom: 1px solid #d5d5d5;
        border-radius: 0px;
        box-shadow: none;
    }
    .login_btn{
        border-radius: 50px;
        margin-left: 41%;
        padding: 7px 15px;
        color: #004eff;
        border: 1px solid #E91E63;
    }
    .social-login{
        padding:30px;
        margin-top: 4%;
    }
    .social-login a{
        display: flex;
        overflow: hidden;
        background: #4267b2;
        height: 41px;
        width: 100%;
        text-align: center;
        font-size: 17px;
        color: #fff;
        border-radius: 0px;
        border: 1px solid #4267b2;
        margin-bottom: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 6px;
    }
    .social-login a img{
        padding-right: 5px;
    }
    @media  only screen and (max-width :768px) {
        .register-form{
            padding-top: 10px;
        }
        .social-login{
            margin-top: 0%;
        }
    }

</style>
<div class="paddingBottom"> </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
            <a href="{{URL::to('/')}}" class=" ">
                <img src="{{asset($setting->logo)}}" alt="{{$setting->company_name}}" class="img-responsive center-block" style="width:150px;">
            </a>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
            <div class="text-center">
                <h1>{{$setting->company_name}} SING IN</h1>
                <h5> New to {{$setting->company_name}} ? <a href="{{URL::to('register.html')}}"> Create an Account </a></h5>


            </div>
        </div>
    </div>
</div>
<hr>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="border-right: 1px solid #aeaaaa;">
            <div class="register-form">

                    {!! Form::open(['url'=>'/login','id'=>'clientReg','method'=>'POST']) !!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group has-feedback">
                                <input class="form-control only-border-bottom" placeholder="Mobile/Email *" required name="mobile" type="text">
                            </div>
                        </div>

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

                        <div class="col-sm-12">
                            <div class="form-group has-feedback">
                                <input class="form-control only-border-bottom" placeholder="Password *" min="8" required name="password" type="password" value="">
                            </div>
                        </div>



                    </div>
                    <div class="form-group">
                        <button type="submit"  class="buttons login_btn text-center" value="Login">
                            Sign In
                        </button>
                    </div>
                    <div class="form-info">
                        <p class="text-center "></p>
                    </div>
                {!! Form::close() !!}
            </div>
        </div><!-- Register area -->

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="list-unstyled list-inline social-login">
                <a href="#" class="facebook"> <img src="{{asset('client/fb.png')}}" alt=""> Continue with Facbook</a>
                <a href="#" class="google" style="background-color: #2687d5ad;"> <img src="{{asset('client/google_p.png')}}" alt=""> <span>Continue with Google</span></a>
            </div>
        </div><!-- social register area -->
    </div>
</div>


<!--===============================================================================================-->

<!--===============================================================================================-->
<script src="{{asset('/client/assets')}}/javascript/jquery/jquery-2.1.1.min.js"></script>
<script src="{{asset('/client/assets')}}/javascript/bootstrap/js/bootstrap.min.js"></script>
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
</html>
