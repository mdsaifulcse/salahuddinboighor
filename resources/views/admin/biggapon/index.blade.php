@extends('layouts.vmsapp')

@section('title')
    Biggapon | Create
@endsection
<!-- begin:: Content Head -->
@section('subheader')
    Biggapon | Create
@endsection
@section('subheader-action')
    @can('slider')
        <a href="#sliderModal" data-toggle="modal" data-target="#sliderModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add Biggapon
        </a>
    @endcan
@endsection
<!-- end:: Content Head -->
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- Modal Start -->
        <div class="modal fade" id="sliderModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' => 'biggapons.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                    <div class="modal-header">
                        <h4 class="modal-title">Create new biggapon</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">

                            <div class="col-md-3">
                                {{Form::label('Biggapon Place', 'Biggapon Place', ['class' => 'control-label'])}}

                                {{Form::select('place', [
                                \App\Models\Biggapon::TOP  => \App\Models\Biggapon::TOP ,
                                \App\Models\Biggapon::MIDDLE  => \App\Models\Biggapon::MIDDLE,
                                \App\Models\Biggapon::BOTTOM  => \App\Models\Biggapon::BOTTOM,
                                \App\Models\Biggapon::SIDE=> \App\Models\Biggapon::SIDE
                                  ],[], ['class' => 'form-control','id'=>'place','required'=>true,'placeholder'=>'--Select--'])}}
                            </div>
                            <div class="col-md-3">
                                <label for="slide_photo" class="imageSize control-label">Image size(1200px wide) </label>
                                <label class="slide_upload" for="file">

                                    <img id="image_load" src="{{asset('images/default/default.png')}}" class="img img-responsive img-thumbnail">

                                </label>

                                <input id="file" style="display:none" required="" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                            </div>

                            <div class="col-md-3">
                                {{Form::label('serial', 'Serial', array('class' => ' control-label'))}}
                                {{Form::number('serial_num',$value=$max_serial,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"",'min'=>'0'))}}

                            </div>

                            <div class="col-md-3">
                                {{Form::label('Status', 'Status', array('class' => 'control-label'))}}
                                {{Form::select('status', [\App\Models\Biggapon::ACTIVE  => \App\Models\Biggapon::ACTIVE , \App\Models\Biggapon::INACTIVE  => \App\Models\Biggapon::INACTIVE],[], ['class' => 'form-control','required'=>true])}}

                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-2 control-label">{{ __('Target Link') }}</label>

                            <div class="col-md-10" >
                                <input type="text" class="form-control" name="target_url" value="{{old('target_url')}}" placeholder="Target Link Here"/>

                                @if ($errors->has('target_url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_url') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-4" style="display:block;">
                            {{Form::label('Show on', 'Show on', array('class' =>' control-label'))}}
                                {{Form::select('show_on_page',
                                 [\App\Models\Biggapon::HOME_PAGE  => \App\Models\Biggapon::HOME_PAGE ,
                                 \App\Models\Biggapon::DETAIL_PAGE=> \App\Models\Biggapon::DETAIL_PAGE,
                                 \App\Models\Biggapon::OTHER_PAGE=> \App\Models\Biggapon::OTHER_PAGE,
                                 ],
                                 [], ['class' => 'form-control','required'=>true,'id'=>'onPage','placeholder'=>'-- Select --'])}}
                            </div>
                        </div>
                    </div><!--end body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success ">Submit</button>
                        <a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
                    </div>
                    {!! Form::close(); !!}
                </div>
            </div>
        </div>
        <!-- Modal End -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->


            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>image</th>
                            <th>Show On Page</th>
                            <th>Place</th>
                            <th>Link</th>
                            <th>Serial</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        <?php $i=1; ?>
                        @forelse($alldata as $data)

                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <img src="{{asset($data->image)}}" style="width: 150px;
    height:auto;"/>
                                </td>

                                <td>{{$data->show_on_page}}</td>
                                <td>{{$data->place}}</td>

                                <td> <a href="{{$data->target_url}}" target="_blank"> {{$data->target_url}}</a> </td>
                                <td>{{$data->serial_num}}</td>

                                <td><i class="{{($data->status==\App\Models\Slider::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>
                                    {{Form::open(array('route'=>['biggapons.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id"))}}

                                    <a href='#sliderModal{{$data->id}}' data-target="#sliderModal{{$data->id}}" data-toggle="modal" title="Edit User" class="btn btn-info btn-sm">
                                        <i class="la la-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="return deleteConfirm('deleteForm{{$data->id}}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                                <!-- Modal Start -->
                                <div class="modal fade" id="sliderModal{{$data->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            {!! Form::open(['route' => ['biggapons.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Biggapon Info </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group row">

                                                    <div class="col-md-3">
                                                        {{Form::label('Biggapon Place', 'Biggapon Place', ['class' => 'control-label'])}}

                                                        {{Form::select('place', [
                                                        \App\Models\Biggapon::TOP  => \App\Models\Biggapon::TOP ,
                                                         \App\Models\Biggapon::MIDDLE  => \App\Models\Biggapon::MIDDLE,
                                                          \App\Models\Biggapon::BOTTOM  => \App\Models\Biggapon::BOTTOM,
                                                          \App\Models\Biggapon::SIDE=> \App\Models\Biggapon::SIDE
                                                          ],$data->place, ['class' => 'form-control','id'=>'placeEdit','required'=>true,'placeholder'=>'--Select--'])}}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="slide_photo" class="imageSize control-label">
                                                            @if($data->place==\App\Models\Biggapon::SIDE)
                                                                Image size(336 X 280)
                                                                @else
                                                                Image size(1200px wide)
                                                            @endif
                                                        </label>
                                                        <label class="slide_upload" for="file{{$data->id}}">
                                                            {{--@if(file_exists($data->image))--}}

                                                            @if(file_exists($data->image))

                                                            <img id="image_load{{$data->id}}" src="{{asset($data->image)}}" class="img img-responsive img-thumbnail">
                                                                @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" class="img img-responsive img-thumbnail">
                                                            @endif
                                                        </label>
                                                        <input id="file{{$data->id}}" style="display:none" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{Form::label('serial', 'Serial', array('class' => ' control-label'))}}
                                                        {{Form::number('serial_num',$value=$data->serial_num,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"",'min'=>'0'))}}

                                                    </div>

                                                    <div class="col-md-3">
                                                        {{Form::label('Status', 'Status', array('class' => 'control-label'))}}
                                                        {{Form::select('status', [\App\Models\Biggapon::ACTIVE  => \App\Models\Biggapon::ACTIVE , \App\Models\Biggapon::INACTIVE  => \App\Models\Biggapon::INACTIVE],$data->status, ['class' => 'form-control','required'=>true])}}

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="text" class="col-md-2 control-label">{{ __('Target Link') }}</label>

                                                    <div class="col-md-10" >
                                                        <input type="text" class="form-control" name="target_url" value="{{old('target_url',$data->target_url)}}" placeholder="Target Link Here"/>

                                                        @if ($errors->has('target_url'))
                                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_url') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    {{--style="@if($data->place==\App\Models\Biggapon::SIDE) display:block @else display:none @endif "--}}
                                                    <div class="col-md-4" style="display:block">
                                                        {{Form::label('Show on', 'Show on', array('class' =>' control-label'))}}

                                                        {{Form::select('show_on_page', [\App\Models\Biggapon::HOME_PAGE  => \App\Models\Biggapon::HOME_PAGE ,  \App\Models\Biggapon::DETAIL_PAGE=> \App\Models\Biggapon::DETAIL_PAGE,\App\Models\Biggapon::OTHER_PAGE=> \App\Models\Biggapon::OTHER_PAGE],$data->show_on_page, ['class' => 'form-control','required'=>true,'id'=>'onPageEidt','placeholder'=>'-- Select --'])}}
                                                    </div>
                                                </div>
                                            </div><!--end body -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-sm btn-success ">Update</button>
                                                <a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
                                            </div>
                                            {!! Form::close(); !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal End -->
                            </tr>
                        @empty
                            <tr> <td colspan="7" class="text-center">No Biggapon Data Found !</td></tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- kt-container -->
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

@section('script')

    <link rel="stylesheet" href="{{asset('/client/assets')}}/common/plugins/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/common/plugins/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/common/plugins/daterangepicker/js/daterangepicker.js"></script>
    <script>
        $('#place').on('click',function () {
            var place=$(this).val()

            if (place=="<?php echo \App\Models\Biggapon::SIDE;?>")
            {
                $('.imageSize').html('Image size(336 X 280)')

                $('#onPage').attr('required',true)
                //$('#onPage').parent().css({'display':'block'})
            }else {
                $('.imageSize').html('Image size(1000 X 100)')

                $('#onPage').attr('required',false)
                //$('#onPage').parent().css({'display':'none'})
            }
        })
    </script>

    <script>
        $('#placeEdit').on('click',function () {

            var place=$(this).val()

            if (place=="<?php echo \App\Models\Biggapon::SIDE;?>")
            {
                $('.imageSize').html('Image size(336 X 280)')

                $('#onPageEidt').attr('required',true)
                //$('#onPageEidt').parent().css({'display':'block'})
            }else {
                $('.imageSize').html('Image size(1000 X 100)')

                $('#onPageEidt').attr('required',false)
                //$('#onPageEidt').parent().css({'display':'none'})
            }
        })
    </script>



    <script>
        $(function() {

            var today=new Date()

            $('#activeTill').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(new Date().setDate(new Date().getDate() + 30)),
                locale: {
                    format: 'MM-DD-YYYY'
                }
            });

            $('#activeTillEdit').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(new Date().setDate(new Date().getDate() + 60)),
                locale: {
                    format: 'MM-DD-YYYY'
                }
            });
                {{--@if($request->has('dateFrom'))--}}
                {{--$('#dateFrom').val("{{$request->dateFrom}}");--}}
                {{--@else--}}
                {{--$('#dateFrom').val('');--}}
                {{--@endif--}}
        });

    </script>


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

<!-- Good -->
