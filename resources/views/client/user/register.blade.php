@extends('client.layouts.master')

@section('head')
    <title> Register New User  </title>
    <meta name="description" content="Register New User , Create Account, Sign Up " />
    <meta name="keywords" content="Register New User , Create Account, Sign Up" />
    @endsection


@section('style')

    @endsection


@section('content')

    <div id="account-register" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="javascript:;">New Account</a></li>
            <li><a href="javascript:;">Register</a></li>
            <li><a href="javascript:;">Create New Account By Fill Up Below Form</a></li>
        </ul>
        <div class="row">
            <div id="content" class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">

                {!! Form::open(array('route' => 'register','method'=>'POST','class'=>'form-horizontal','files'=>false,'style'=>'padding:25px;margin-bottom:25px;border:2px dashed #6f0c81;')) !!}
                    <fieldset id="account">
                        <legend>Your Personal Details</legend>
                        <div class="form-group " style="display:  none ;">
                            <label class="col-sm-2 control-label">Customer Group</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="customer_group_id" value="1" checked="checked">
                                        Default</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input-firstname">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{old('name')}}" required placeholder="First Name" id="input-firstname" class="form-control">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input-telephone">Mobile</label>
                            <div class="col-sm-10">
                                <input type="number" name="mobile" value="{{old('mobile')}}" required placeholder="Your mobile" id="input-telephone" class="form-control">
                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{old('email')}}" required placeholder="E-Mail" id="input-email" class="form-control" autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend>Your Password</legend>
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input-password">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" required placeholder="Min: 8 character" id="input-password" class="form-control">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-confirm">Password Confirm</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" required placeholder="Password Confirm" id="input-confirm" class="form-control">
                                @if ($errors->has('confirm_password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                    </fieldset>

                <div class="form-group">
                    <div class="col-md-2"></div>
                    <label class="col-sm-4" for="input-confirm">
                        <input type="submit" value="Create Account" class="btn" style="background-color: #280c2d;">
                    </label>
                    <div class="col-sm-6 text-right">
                        Already have account? <a href="#" data-target="#so_sociallogin" data-toggle="modal" class="btn btn-default">login page</a>

                    </div>
                </div>

                {!! Form::close() !!}
            </div>

            {{--<aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">--}}
                {{--<span id="close-sidebar" class="fa fa-times"></span>--}}

                {{--@include('client.layouts.partials.user-account-aside')--}}

            {{--</aside>--}}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('/client/assets')}}/javascript/so_home_slider/js/owl.carousel.js"></script>
    @endsection

