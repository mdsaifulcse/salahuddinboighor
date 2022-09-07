@extends('layouts.vmsapp')

@section('title')
    States | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    States | Create
@endsection

@section('subheader-action')
    @can('divisions')
        <a href="#divisionModal" data-toggle="modal" data-target="#divisionModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add States
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->


            <!-- Modal Start -->
            <div class="modal fade" id="divisionModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'divisions.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create new State</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{Form::label('division', 'States Name', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('division',$value=old('division'),array('class'=>'form-control','placeholder'=>'States Name','required','autofocus'))}}
                                    @if ($errors->has('division'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('division') }}</strong>
                    			</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\Division::ACTIVE  => \App\Models\Division::ACTIVE , \App\Models\Division::INACTIVE  => \App\Models\Division::INACTIVE],[], ['class' => 'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">
                                {{Form::label('link', 'States Link', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('link',$value=old('link'),array('class'=>'form-control','placeholder'=>'Optional'))}}

                                    @if ($errors->has('link'))
                                        <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-2">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input type="file" id="file" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" />
                                    @if ($errors->has('icon_photo'))
                                        <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('icon_photo') }}</strong>
                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <b>OR</b>
                                </div>
                                <div class="col-md-5">
                                    {{Form::text('icon_class','',array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                    <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/">ion icons</a></span>
                                </div>
                                <?php $max=$max_serial+1; ?>
                                <div class="col-md-2">
                                    {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                    <span>States Serial</span>
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

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>SL</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Sub States</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @forelse($allData as $data)
                            <tr>
                                <td>{{$data->serial_num}}</td>
                                <td><a href="{{route('divisions.edit',$data->id)}}"><i class="{{$data->icon_class}}"></i> {{$data->division}}</a></td>
                                <td><a href="{{URL::to($data->link)}}" target="_blank">{{URL::to($data->link)}}</a></td>

                                <td>
                                    <a class="btn btn-xs btn-sm btn-info" href='{{route('districts.show',$data->id)}}'>Sub States ({{$data->districtData->count()}})</a>
                                </td>

                                <td><i class="{{($data->status==\App\Models\Division::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['divisions.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#divisionModal{{$data->id}}" data-toggle="modal" data-target="#divisionModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>




                                <!-- begin::modal -->

                                <div class="modal fade show" id="divisionModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit  States Info | {{$data->division}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                {!! Form::open(array('route' => ['divisions.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}


                                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    {{Form::label('division', 'States Name', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('division',$value=$data->division,array('class'=>'form-control','placeholder'=>'States Name','required','autofocus'))}}
                                                        @if ($errors->has('division'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('division') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\Division::ACTIVE  => \App\Models\Division::ACTIVE , \App\Models\Division::INACTIVE  => \App\Models\Division::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>


                                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    {{Form::label('division', 'States Link', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('link',$value=$data->link,array('class'=>'form-control','placeholder'=>'States Link','required'))}}
                                                        @if ($errors->has('division'))
                                                            <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('division') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                                    {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-2">
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            <!--  -->
                                                            @if(!empty($data->icon_photo) && file_exists($data->icon_photo))
                                                                <img id="image_load{{$data->id}}" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
                                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                                        </label>
                                                        <input type="file" id="file{{$data->id}}" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" />
                                                        @if ($errors->has('icon_photo'))
                                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('icon_photo') }}</strong>
                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-1">
                                                        <b>OR</b>
                                                    </div>
                                                    <div class="col-md-5">
                                                        {{Form::text('icon_class','',array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                                        <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/">ion icons</a></span>
                                                    </div>
                                                    <?php $max=$max_serial+1; ?>
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                        <span>States Serial</span>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-2">
                                                    </div>
                                                    <div class="col-10">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>



                                                {!! Form::close() !!}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-brand pull-left" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- end::modal -->



                            </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Data Found ! </td>
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
