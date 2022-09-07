@extends('layouts.vmsapp')

@section('title')
    District | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    District | Create
@endsection

@section('subheader-action')
    @can('districts')
        <a href="#districtModal" data-target="#districtModal" data-toggle="modal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add District
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->


        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <!-- Modal Start -->
            <div class="modal fade" id="districtModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'districts.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create new social media</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{Form::label('district', 'district Name', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('district',$value=old('district'),array('class'=>'form-control','placeholder'=>'District Name','required','autofocus'))}}

                                    <input type="hidden" name="division_id" value="{{$division->id}}">

                                    @if ($errors->has('district'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('district') }}</strong>
                    			</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\District::ACTIVE  => \App\Models\District::ACTIVE , \App\Models\District::INACTIVE  => \App\Models\District::INACTIVE],[], ['class' => 'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">
                                {{Form::label('link', 'District Link', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('link',$value=old('link'),array('class'=>'form-control','placeholder'=>'Link Optional'))}}

                                    <input type="hidden" name="division_id" value="{{$division->id}}">

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
                                    <span>Category Serial</span>
                                </div>
                            </div>


                        </div><!-- end body -->

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
                            <th>District</th>
                            <th>URL</th>
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
                                <td><a href="{{route('districts.edit',$data->id)}}"><i class="{{$data->icon_class}}"></i> {{$data->district}}</a></td>
                                <td><a href="{{URL::to($data->link)}}" target="_blank">{{URL::to($data->link)}}</a></td>



                                <td><i class="{{($data->status==\App\Models\District::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['districts.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#districtModal{{$data->id}}" data-toggle="modal" data-target="#districtModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>



                                <!-- begin::modal -->

                                <div class="modal fade show" id="districtModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit District Info | {{$data->district}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            {!! Form::open(array('route' => ['districts.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-body">


                                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    {{Form::label('district', 'District Name', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('district',$value=$data->district,array('class'=>'form-control','placeholder'=>'District Name','required','autofocus'))}}

                                                        <input type="hidden" name="division_id" value="{{$division->id}}">

                                                        @if ($errors->has('district'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('district') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\District::ACTIVE  => \App\Models\District::ACTIVE , \App\Models\District::INACTIVE  => \App\Models\District::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>

                                                <div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">
                                                    {{Form::label('link', 'District Link', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('link',$value=$data->link,array('class'=>'form-control','placeholder'=>'District Link','required'))}}

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
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            <!--  -->
                                                            @if(!empty($data->icon_photo) && file_exists($data->icon_photo))
                                                                <img id="image_load{{$data->id}}" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
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
                                                        {{Form::text('icon_class',$data->icon_class,array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                                        <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/">ion icons</a></span>
                                                    </div>
                                                    <?php $max=$max_serial+1; ?>
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                        <span>Category Serial</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>

                                                <button type="button" class="btn btn-brand pull-right" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>


                                <!-- end::modal -->



                            </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Data Found! </td>
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
