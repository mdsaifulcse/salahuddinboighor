@extends('client.layouts.master')

@section('head')
    <title> Change Password | {{auth()->user()->name}} </title>
    <meta name="description" content=" " />
    <meta name="keywords" content="" />
    @endsection


@section('style')

    @endsection


@section('content')

    <div id="account-account" class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/account/account')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/account/account')}}">My Account</a></li>
            <li><a href="javascript:;">Change Password</a></li>
        </ul>

        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>
                Success: {{Session::get('success')}}
            </div>
        @endif

        <div class="row">

            <div class="col-md-7 col-lg-7 col-lg-offset-2 pull-md-right pull-lg-right">


                <div class="form-default">

                    {!! Form::open(array('route' => 'account.password','method'=>'POST','class'=>'form-horizontal','files'=>false)) !!}

                    <fieldset>
                        <legend>{{auth()->user()->name}}, Change Your Password</legend>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Old Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="current_password" required placeholder="" id="input-password" class="form-control">

                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="new_password" required placeholder="Min: 8 character" id="input-password" class="form-control">

                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-confirm">Password Confirm</label>
                            <div class="col-sm-9">
                                <input type="password" name="new_confirm_password" required placeholder="Password Confirm" id="input-confirm" class="form-control">

                                @if ($errors->has('new_confirm_password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('new_confirm_password') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend></legend>
                    </fieldset>

                    <label class="col-sm-3 control-label" for="input-confirm"></label>
                    <div class="buttons">
                        <div class="pull-left">
                            <input type="submit" value="Change Account" class="btn btn-default">
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>


            </div>



            <div class="col-md-3 col-lg-3 pull-md-left pull-lg-left ">

                @include('client.layouts.partials.user-account-aside')

            </div>

        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {


            $('[data-toggle="collapse"]').click(function() {
                $(this).toggleClass( "in" );
                if ($(this).hasClass("collapsed")) {

                    $(this).empty().addClass("fa fa-chevron-up panel-minimise pull-right ");
                } else {
                    $(this).empty().addClass("fa fa-chevron-down panel-minimise pull-right");
                }
            });


// document ready
        });
    </script>
    @endsection

