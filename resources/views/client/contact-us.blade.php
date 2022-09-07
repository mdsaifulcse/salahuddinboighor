@extends('client.layouts.master')

@section('head')
    <title> Contact Us | {{$setting->company_name}} </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
@endsection

@section('style')

    <style>
        .custom-font{
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
    }
        .contactList ul li{
            font-size: 18px;
            padding:8px 5px;
        }
    </style>

    @endsection

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/contact.htm')}}">Contact Us</a></li>
        </ul>

    <section style="margin-top: 0px;">
        <div class="container">
            <div class="padding15 marginTopBottom20">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <h2 class="paddingBottom20 marginBottom20"> Get in touch </h2>
                            <hr>
                            @if (Session::has('success'))
                                <h3 style="text-align: center;color: #86bc42;"><i class="fa fa-check-circle"></i> {!! session('success') !!}</h3>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row contactPage box-white">

                    <div class="col-sm-6 col-md-6 col-lg-6 contactList">
                        <div class="box-white padding20">
                            <h2>Please contact us in the following ways:</h2>
                            <ul>
                                <li> <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <span>Address: </span>
                                    {{$setting->address1}}
                                </li>
                                <li><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Phone: <a href="tel:+1{{$setting->mobile_no1}}"><strong>{{$setting->mobile_no1}}</strong></a></li>
                                <li><i class="fa fa-phone-square" aria-hidden="true"></i> Mobile: <a href="fax:+1{{$setting->mobile_no2}}"><strong>{{$setting->mobile_no2}}</strong></a></li>
                                <li><i class="fa fa-envelope" aria-hidden="true"></i> Email: <a href="cdn-cgi/l/email-protection.htm#8801700000000"><strong><span class="__cf_email__" data-cfemail="8801700000000">{{$setting->email1}}</span></strong>
                                    </a>
                                    <a href="cdn-cgi/l/email-protection.htm#8801700000000"><strong><span class="__cf_email__" data-cfemail="8801700000000">{{','.$setting->email2}}</span></strong></a></li>

                                <li><i class="fa fa-cog" aria-hidden="true"></i> Please read our <a href="{{url('/page/privacy-policy')}}" class="text-black"><strong>privacy policy</strong></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="box-white single-block auto shadow padding20" style="border-left:1px solid #cecece;box-shadow:0 1px 4px 0 #f6f6f6;padding:20px">
                                <h2>Send your massage</h2>

                                    {!! Form::open(['url'=>'user-feedback','method'=>'POST','class'=>'form-horizontal','files'=>true]) !!}

                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <input type="text" name="name" value="{{old('name')}}" size="100" class="form-control custom-font" placeholder="Name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">

                                        <div class="col-md-6 ">
                                            <input type="text" name="mobile" value="{{old('mobile')}}" size="20" class="form-control custom-font" placeholder="Mobile no." required="">
                                            @if ($errors->has('mobile'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-6 ">
                                                <input type="email" name="email" value="{{old('email')}}" size="100" required="" class="form-control custom-font" aria-required="true" aria-invalid="false" placeholder="Email">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                        <br>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <textarea name="message" cols="40" rows="5" class="form-control custom-font" placeholder="Message" required >{{old('message')}}</textarea>
                                            @if ($errors->has('message'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('message') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="upload_photo upload icon_upload" style="margin-top:10px" for="file">
                                                    <!--  -->
                                                    <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                                    {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                                </label>
                                                <input type="file" id="file" style="display: none;" name="image" onchange="photoLoad(this, this.id)" accept="image/*" />
                                                <span>Attach your file, Max size 2Mb</span>
                                                @if ($errors->has('image'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                                    </span>
                                                @endif

                                                <br>

                                                <input type="submit" class="btn btn-success" value="SUBMIT">

                                            </div>
                                        </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <section style="margin-top: 0px;">
        <div class="container-fluid">
            <div class="padding15 marginTopBottom20">
                <div class="row contactPage">
                    <div class="col-sm-12">
                        <div class="box-white single-block auto shadow padding20">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.693751878496!2d-73.90413788473145!3d40.74676377932813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25f1cc31296bd%3A0x511771f5336b33ee!2s39-06%2062nd%20St%2C%20Flushing%2C%20NY%2011377!5e0!3m2!1sen!2sus!4v1592971036221!5m2!1sen!2sus" width="400" height="300" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

@endsection