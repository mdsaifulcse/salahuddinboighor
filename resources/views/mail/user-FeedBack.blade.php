<!DOCTYPE html>
<html>
<head>
    <title>{{$userFeedBack->name}} | User Feedback</title>
    <style type="text/css">

        .reset-password a{background: #202e56;padding: 10px;border-radius: 5px;
            text-align:center; text-decoration: none;color: #fff;font-size: 13px;font-weight: bold;
            padding-top: 7px;padding-bottom: 7px;}
        .reset-password a:hover{background-color: green;}
    </style>
</head>
<body>
<div class="pull-content" style="width: 100%;margin: 0 auto;font-family: sans-serif;">
    <div class="content" style="background: #e2e2e2;padding:10px 20px;height: 60px;">
        <img width="240px" src="{{asset('images/default/logo.png')}}" alt="Tekblock">
        <h1 style="padding:0px;color: #000;font-size: 24px;margin: 0;float:right;line-height: 48px;">Sanbad 7 User Feed Back <?php echo date('m-d-Y')?></h1>
    </div>

    <div class="text-content" style="background: #c7c7c7;padding: 10px;">
        <div class="text-content-full" style="margin: 50px;margin-top: 0;">
            <p style="margin-bottom: 20px;">  <br>
            </p>
            <div class="reset-password" style="text-align: center;">

            </div>

            <h5 style="margin: 0 auto;text-align: left;margin-top: 10px;font-size: 14px;padding: 5px;font-weight: bold;font-style: italic;color:#000">
                {{'Name: '.$userFeedBack->name}},
                <br/>
                {{'Mobile: '. $userFeedBack->mobile}} , {{'  Email: '.$userFeedBack->email}}
                <br/>

                <span>Message: </span>
                <?php echo $userFeedBack->message?>

                <br/>
                @if(!empty($userFeedBack->image))

                <span>Attached File: </span> <br>

                    <a href="{{asset($userFeedBack->image)}}" target="_blank">
                       Click here to show image <img src="{{asset($userFeedBack->image)}}" alt="{{$userFeedBack->name}}" style="max-width:70%">
                    </a>

                    @endif
            </h5>


            {{--<p style="margin-top: -11px;font-weight: bold;">--}}
            {{--Thank you, <br/>--}}
            {{--Support Team <br/>--}}

            {{--</p>--}}
        </div>
    </div>

</div>
</body>
</html>