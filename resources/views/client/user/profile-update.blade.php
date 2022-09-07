@extends('client.layouts.master')

@section('head')
    <title> Profile Update | {{auth()->user()->name}} </title>
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
            <li><a href="javascript:;">Update Profile</a></li>
        </ul>

        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>
                Success: {{Session::get('success')}}
            </div>
        @endif

        <div class="row">

            <div class="col-md-7 col-lg-7 col-lg-offset-2 pull-md-right pull-lg-right">


                <div class="form-default">

                    {!! Form::open(array('route' => 'account.profile','method'=>'POST','class'=>'form-horizontal','files'=>true)) !!}

                    <fieldset>
                        <legend>{{auth()->user()->name}}, Update Your Personal Details</legend>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Full Name <sup>*</sup> </label>
                            <div class="col-sm-9">
                                <input type="text" name="name" value="{{old('name',auth()->user()->name)}}" required placeholder="Full Name" class="form-control">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Mobile <sup>*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" name="mobile" value="{{old('mobile',auth()->user()->mobile)}}" required placeholder="Mobile No." class="form-control">

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Email <sup>*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" name="email" value="{{old('email',auth()->user()->email)}}" required placeholder="Email Address" class="form-control">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Company Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="company_name" value="{{old('company_name',$user->profile?$user->profile->company_name:'')}}"  placeholder="Your Company Name" class="form-control">

                                @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Another Contact</label>
                            <div class="col-sm-9">
                                <input type="text" name="contact" value="{{old('contact',$user->profile?$user->profile->contact:'')}}" placeholder="Another contact number" class="form-control">

                                @if ($errors->has('contact'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('contact') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Address <sup>*</sup></label>
                            <div class="col-sm-9">
                                <textarea name="address" placeholder="Your address here" required class="form-control" rows="4">{{old('address',$user->profile?$user->profile->address:'')}}</textarea>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password">Your Profile</label>
                            <div class="col-sm-9">

                                <label class="slide_upload" for="file">
                                    <!--  -->

                                    @if(isset($user->profile->avatar))
                                        <img id="image_load" src="{{asset($user->profile->avatar)}}" style="width: 150px;height: 150px;cursor:pointer">
                                    @else

                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 150px; height: 150px;cursor:pointer;">

                                    @endif
                                </label>
                                <input id="file" style="display:none" name="avatar" type="file" onchange="photoLoad(this,this.id)" accept="image/*">


                            @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('avatar') }}</strong>
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
                            <input type="submit" value="Update Profile" class="btn btn-default">
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
    <script type="text/javascript">


        function photoLoad(input,image_load) {
            var target_image='#'+$('#'+image_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

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

