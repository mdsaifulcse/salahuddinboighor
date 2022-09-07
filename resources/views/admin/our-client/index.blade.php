@extends('layouts.vmsapp')

@section('title')
    Our Client | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Our Client | Create
@endsection

@section('subheader-action')
    @can('client')
        <a href="#faqModal" data-toggle="modal" data-target="#faqModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add Client
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
            <div class="modal fade" id="faqModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'client.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create new client</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{Form::label('name', 'Name', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('name',$value=old('name'),array('class'=>'form-control','placeholder'=>'Client name here','required','autofocus'))}}
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\OurClient::ACTIVE  => \App\Models\OurClient::ACTIVE , \App\Models\OurClient::INACTIVE  => \App\Models\OurClient::INACTIVE],[], ['class' => 'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="text" class="col-md-2 control-label">{{ __('Title') }}</label>

                                <div class="col-md-8">
                                    {{Form::text('title',$value=old('title'),array('class'=>'form-control','placeholder'=>'Client Title here','autofocus'))}}
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('title') }}</strong>
                    			</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text" class="col-md-2 control-label">{{ __('Link') }}</label>

                                <div class="col-md-8">
                                    {{Form::text('url',$value=old('url'),array('class'=>'form-control','placeholder'=>'Past or type link here','autofocus'))}}
                                    @if ($errors->has('url'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('url') }}</strong>
                    			</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{Form::label('Logo', 'Logo', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-3">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input type="file" id="file" style="display: none;" name="logo" onchange="photoLoad(this, this.id)" />
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
                            <th>Title</th>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($allData as $key=> $data)
                            <tr>
                                <td>{{$data->serial_num}}</td>

                                <td>{{$data->name}}</td>
                                <td>{{$data->title}}</td>
                                <td>
                                    @if(!empty($data->logo) && file_exists($data->logo))
                                        <img id="image_load{{$data->id}}" src="{{asset($data->logo)}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">

                                    @else
                                        <span class="text-danger text-center"> No Logo</span>

                                    @endif
                                </td>


                                <td><i class="{{($data->status==\App\Models\OurClient::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['client.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#faqModal{{$data->id}}" data-toggle="modal" data-target="#faqModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>




                                <!-- begin::modal -->

                                <div class="modal fade show" id="faqModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit Faq info | {{$data->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>
                                            {!! Form::open(array('route' => ['client.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-body">


                                                <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    {{Form::label('name', 'Name', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('name',$value=$data->name,array('class'=>'form-control','placeholder'=>'Client name here','required','autofocus'))}}
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\OurClient::ACTIVE  => \App\Models\OurClient::ACTIVE , \App\Models\OurClient::INACTIVE  => \App\Models\OurClient::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="text" class="col-md-2 control-label">{{ __('Title') }}</label>

                                                    <div class="col-md-8">
                                                        {{Form::text('title',$value=$data->title,array('class'=>'form-control','placeholder'=>'Client Title here','autofocus'))}}
                                                        @if ($errors->has('title'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('title') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="text" class="col-md-2 control-label">{{ __('Link') }}</label>

                                                    <div class="col-md-8">
                                                        {{Form::text('url',$value=$data->url,array('class'=>'form-control','placeholder'=>'Past or type link here','autofocus'))}}
                                                        @if ($errors->has('url'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('url') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                                    {{Form::label('Logo', 'Logo', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-3">
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            <!--  -->
                                                            @if(!empty($data->logo) && file_exists($data->logo))
                                                                <img id="logo_load{{$data->id}}" src="{{asset($data->logo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
                                                        </label>
                                                        <input type="file" id="file{{$data->id}}" style="display: none;" name="logo" onchange="photoLoad(this, this.id)" />
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
