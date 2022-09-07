@extends('layouts.vmsapp')

@section('title')
    Categories | Edit
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Categories | Edit
@endsection

@section('subheader-action')
    @can('categories')
        <a href="{{ route('categories.index') }}" class="btn btn-success pull-right">
            Categories List
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

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                    <div class="kt-portlet">
                        {!! Form::open(['route' => ['categories.update',$data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true]) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Update category Info
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                 {{Form::label('category_name', 'Category Name', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-8">
                                     {{Form::text('category_name',$value=$data->category_name,array('class'=>'form-control','placeholder'=>'Category Name','required','autofocus'))}}
                                     @if ($errors->has('category_name'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('category_name') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                                 <div class="col-md-2">
                                     {{Form::select('status', [\App\Models\Category::ACTIVE  => \App\Models\Category::ACTIVE , \App\Models\Category::INACTIVE  => \App\Models\Category::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                 </div>
                             </div>

                             <div class="form-group row">
                                 {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-10">
                                     {{Form::textArea('short_description',$value=$data->short_description, ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description for Home Page'])}}
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                 {{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-2">
                                     <label class="upload_photo upload icon_upload" for="file">
                                         <!--  -->
                                         @if(!empty($data->icon_photo) && file_exists($data->icon_photo))
                                         <img id="image_load" src="{{asset($data->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                         @else
                                             <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                             @endif
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

                        </div> <!-- end kt-portlet__body -->


                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        @can('menu-list')
                                        <a href="{{route('categories.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
                                            @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
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
