@extends('client.layouts.master')

@section('head')
    <title> About Us | {{$setting->company_name}} </title>
    <meta name="description" content="" /><meta name="keywords" content=" " />
@endsection


@section('style')

    @endsection

@section('content')

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{URL::to('/')}}">About Us</a></li>
        </ul>

    <section class="box-white" style="margin-top: 0px;">
        <div class="container">
            <div class="box-white padding15 marginTopBottom20">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <h2 class="no-margin"> About {{$setting->company_name}} </h2>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="box-white paddingBottom20">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <img alt="Demoonews.com" src="{{asset('/client')}}/media/common/placeholder-xs.png" data-src="{{asset($setting->logo)}}" class="lazyload" style="width:100%;">
                </div>
                <div class="col-sm-8">
                    <?php
                    echo $setting->short_description;
                    ?>
                    <br>

                        <?php
                        echo $setting->description;
                        ?>
                </div>
            </div>
        </div>
    </section>

    </div>

    @endsection


@section('script')

    @endsection