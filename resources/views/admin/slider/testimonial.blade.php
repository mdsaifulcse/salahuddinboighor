@extends('layouts.vmsapp')

@section('title')
    Testimonial | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Testimonial | Create
@endsection

@section('subheader-action')
    @can('testimonial')
        <a href="#testimonialModal" data-toggle="modal" data-target="#testimonialModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Testimonial
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
            <div class="modal fade" id="testimonialModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'testimonial.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create new testimonial</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{Form::label('Name', ' Review Person', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::text('name',$value=old('name'),array('class'=>'form-control','placeholder'=>'Who\'s give review','required','autofocus'))}}
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\Testimonial::ACTIVE  => \App\Models\Testimonial::ACTIVE , \App\Models\Testimonial::INACTIVE  => \App\Models\Testimonial::INACTIVE], '', ['class' => 'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group  row ">
                                {{Form::label('Content', ' Content', array('class' => 'col-md-2 control-label'))}}
                                <div class=" col-md-8 col-lg-8 ">
                                    <label class="control-label"></label>

                                    <textarea class="form-control textarea" name="content" placeholder="Enter Content Here" required rows="5" value="" ></textarea>

                                </div>
                            </div>


                            <div class="form-group row  {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{Form::label('Name', ' Related topic', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-6">
                                    {{Form::text('related_with',$value=old('related_with'),array('class'=>'form-control','placeholder'=>'Related topic','required'=>false,'autofocus'))}}
                                    @if ($errors->has('related_with'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('related_with') }}</strong>
                    			</span>
                                    @endif
                                </div>
                                {{Form::label('Name', ' Review Rating', array('class' => 'col-md-1 control-label'))}}
                                <div class="col-md-2">
                                    {{Form::select('rating', array('1' => '1 Start', '2' => '2 Start', '3' => '3 Start', '4' => '4 Start', '5' => '5 Start'), '', ['required','class' => 'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group  row  {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                {{Form::label('icon_photo', 'Photo', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-3">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input type="file" id="file" style="display: none;" name="image" onchange="photoLoad(this, this.id)" accept="image/*" />
                                    @if ($errors->has('image'))
                                        <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                                    @endif
                                </div>

                                <?php $max=$max_serial+1; ?>
                                {{Form::label('Serial No.', 'Serial No.', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-2">
                                    {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}

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
                            <th>Review Rating</th>
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
                                <td><a href="#"><i class="{{$data->name}}"></i> {{$data->name}}</a></td>

                                <td><a href="#" target="_blank">{{$data->rating}} star</a></td>

                                <td><i class="{{($data->status==\App\Models\Testimonial::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['divisions.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#testimonialModal{{$data->id}}" data-toggle="modal" data-target="#testimonialModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>




                                <!-- begin::modal -->

                                <div class="modal fade show" id="testimonialModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit  States Info | {{$data->division}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>
                                            {!! Form::open(array('route' => ['testimonial.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-body">



                                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    {{Form::label('Name', ' Review Person', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-6">
                                                        {{Form::text('name',$value=$data->name,array('class'=>'form-control','placeholder'=>'Who\'s give review','required','autofocus'))}}
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\Testimonial::ACTIVE  => \App\Models\Testimonial::ACTIVE , \App\Models\Testimonial::INACTIVE  => \App\Models\Testimonial::INACTIVE], $data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>

                                                <div class="form-group  row ">
                                                    {{Form::label('Content', ' Content', array('class' => 'col-md-2 control-label'))}}
                                                    <div class=" col-md-8 col-lg-8 ">
                                                        <label class="control-label"></label>

                                                        <textarea class="form-control textarea" name="content" required placeholder="Enter Content Here" rows="5" value="" >{{$data->content}}</textarea>

                                                    </div>
                                                </div>


                                                <div class="form-group row  {{ $errors->has('related_with') ? 'has-error' : '' }}">
                                                    {{Form::label('Related topic', ' Related topic', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-6">
                                                        {{Form::text('related_with',$value=$data->related_with,array('class'=>'form-control','placeholder'=>'Related topic','required'=>false,'autofocus'))}}
                                                        @if ($errors->has('related_with'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('related_with') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>

                                                    {{Form::label('Review Rating', ' Review Rating', array('class' => 'col-md-1 control-label'))}}
                                                    <div class="col-md-2">
                                                        {{Form::select('rating', array('1' => '1 Start', '2' => '2 Start', '3' => '3 Start', '4' => '4 Start', '5' => '5 Start'), $data->rating, ['required','class' => 'form-control'])}}
                                                    </div>
                                                </div>


                                                <div class="form-group  row  {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                                    {{Form::label('icon_photo', 'Photo', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-3">
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            <!--  -->
                                                            @if(!empty($data->image) && file_exists($data->image))
                                                                <img id="image_load{{$data->id}}" src="{{asset($data->image)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
                                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                                        </label>
                                                        <input type="file" id="file{{$data->id}}" style="display: none;" name="image" onchange="photoLoad(this, this.id)" accept="image/*" />
                                                        @if ($errors->has('image'))
                                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                                                        @endif
                                                    </div>

                                                    <?php $max=$max_serial+1; ?>
                                                    {{Form::label('Serial No.', 'Serial No.', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}

                                                    </div>
                                                </div>


                                            </div><!-- end body -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-sm btn-success ">Submit</button>
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
