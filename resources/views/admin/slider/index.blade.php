@extends('layouts.vmsapp')

@section('title')
    Slider | List
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Slider | Create
@endsection

@section('subheader-action')
    @can('slider')
        <a href="#sliderModal" data-toggle="modal" data-target="#sliderModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add Slider
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
                    {!! Form::open(['route' => 'slider.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                    <div class="modal-header">
                        <h4 class="modal-title">Create new slider</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="text" class="col-md-2 control-label">{{ __('Caption') }}</label>

                            <div class="col-md-8" >
                                <textarea id="text" type="text" class="form-control" name="caption" value="" required placeholder="Slider caption"></textarea>

                                @if ($errors->has('caption'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('caption') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="text" class="col-md-2 control-label">{{ __('Overview') }}</label>

                            <div class="col-md-8">
                                <textarea id="text" type="text" class="form-control" name="overview" value="" rows="5" required placeholder="Slider overview"></textarea>

                                @if ($errors->has('overview'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('overview') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="slide_photo" class="col-md-2 control-label">Photo min size(1600 X 450) </label>
                            <div class="col-md-2">
                                <label class="slide_upload" for="file">

                                    <img id="image_load" src="{{asset('images/default/default.png')}}" class="img img-responsive img-thumbnail">

                                </label>

                                <input id="file" style="display:none" required="" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                            </div>

                            {{Form::label('serial', 'Serial', array('class' => 'col-md-1 control-label'))}}
                            <div class="col-md-2">
                                {{Form::number('serial_num',$value=$max_serial,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"",'min'=>'0'))}}
                            </div>

                            {{Form::label('Status', 'Status', array('class' => 'col-md-1 control-label'))}}
                            <div class="col-md-2">
                                {{Form::select('status', [\App\Models\Slider::ACTIVE  => \App\Models\Slider::ACTIVE , \App\Models\Slider::INACTIVE  => \App\Models\Slider::INACTIVE],[], ['class' => 'form-control'])}}
                            </div>

                        </div>


                        <div class="form-group row">
                            <label for="slide_photo" class="col-md-1 control-label"></label>

                            {{Form::label('link', 'Link', array('class' => 'col-md-1 control-label'))}}
                            <div class="col-md-5">
                                {{Form::text('url',$value=old('url'),array('class'=>'form-control','placeholder'=>'Enter link','required'=>false))}}
                            </div>

                            {{Form::label('Button Text', 'Button Text', array('class' => 'col-md-2 control-label'))}}
                            <div class="col-md-3">
                                {{Form::text('button_text',$value=old('button_text'),array('class'=>'form-control','placeholder'=>'Button Text','required'=>false))}}
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Caption</th>
                            <th>image</th>
                            <th>Link</th>
                            <th>Serial</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        <?php $i=1; ?>
                        @forelse($alldata as $data)

                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$data->caption}}</td>
                                <td>
                                    <img src="{{$data->image}}" style="width: 100px;
    height: 100px;"/>
                                </td>

                                <td> <a href="{{$data->url}}" target="_blank"> {{$data->url}}</a> </td>
                                <td>{{$data->serial_num}}</td>
                                <td>{{date('d-M-Y',strtotime($data->created_at))}}</td>

                                <td><i class="{{($data->status==\App\Models\Slider::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>
                                    {{Form::open(array('route'=>['slider.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id"))}}

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
                                            {!! Form::open(['route' => ['slider.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit slider Info </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group row">
                                                    <label for="text" class="col-md-2 control-label">{{ __('Caption') }}</label>

                                                    <div class="col-md-8" >
                                                        <textarea id="text" type="text" class="form-control" name="caption" value="" required placeholder="Slider caption">{{$data->caption}}</textarea>

                                                        @if ($errors->has('caption'))
                                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('caption') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="text" class="col-md-2 control-label">{{ __('Overview') }}</label>

                                                    <div class="col-md-8">
                                                        <textarea id="text" type="text" class="form-control" name="overview" value="" rows="5" required placeholder="Slider overview">{{$data->overview}}</textarea>

                                                        @if ($errors->has('overview'))
                                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('overview') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="slide_photo" class="col-md-2 control-label">Photo min size(1600 X 450) </label>
                                                    <div class="col-md-2">
                                                        <label class="slide_upload" for="file{{$data->id}}">

                                                            @if(!empty($data->image))
                                                                <img id="image_load{{$data->id}}" src="{{asset($data->image)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
                                                        </label>

                                                        <input id="file{{$data->id}}" style="display:none" name="image" type="file" accept="image/*" onchange="photoLoad(this,this.id)">
                                                    </div>

                                                    {{Form::label('serial', 'Serial', array('class' => 'col-md-1 control-label'))}}
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$value=$data->serial_num,array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"",'min'=>'0'))}}
                                                    </div>

                                                    {{Form::label('Status', 'Status', array('class' => 'col-md-1 control-label'))}}
                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\Slider::ACTIVE  => \App\Models\Slider::ACTIVE , \App\Models\Slider::INACTIVE  => \App\Models\Slider::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <label for="slide_photo" class="col-md-1 control-label"></label>

                                                    {{Form::label('link', 'Link', array('class' => 'col-md-1 control-label'))}}
                                                    <div class="col-md-5">
                                                        {{Form::text('url',$value=$data->url,array('class'=>'form-control','placeholder'=>'Enter link','required'=>false))}}
                                                    </div>

                                                    {{Form::label('Button Text', 'Button Text', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-3">
                                                        {{Form::text('button_text',$value=$data->button_text,array('class'=>'form-control','placeholder'=>'Button Text','required'=>false))}}
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


                            </tr>





                        @empty

                            <tr>
                                <td colspan="7" class="text-center">No Slider Data Found !</td>
                            </tr>

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
