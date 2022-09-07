@extends('layouts.vmsapp')

@section('title')
    Menu
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Menu
@endsection

@section('subheader-action')
    @can('menu')
        <a href="{{ route('menu.index') }}" class="btn btn-success pull-right">
            Go Menu List
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                    <div class="kt-portlet">
                        {!! Form::open(array('route' => ['menu.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Update Menu
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">

                            <div class="form-group row   {{ $errors->has('name') ? 'has-error' : '' }}">

                                <div class="col-md-6">
                                    <strong>Menu Name</strong>
                                    {{Form::text('name',$data->name,array('class'=>'form-control','placeholder'=>'Name *','required'))}}
                                </div>
                                <div class="col-md-6">
                                    <strong>Menu Name Bangla</strong>
                                    {{Form::text('name_bn',$data->name_bn,array('class'=>'form-control','placeholder'=>'Name Bangla *','required'))}}
                                </div>
                            </div>

                            <div class="form-group row  {{ $errors->has('url') ? 'has-error' : '' }}">

                                <div class="col-md-6">
                                    <strong>URL</strong>
                                        {{Form::text('url',$data->url,['class'=>'form-control','placeholder'=>'URL *','required'])}}

                                        @if ($errors->has('url'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('url') }}</strong>
                                                </span>
                                        @endif
                                </div>

                                <div class="col-md-4 col-lg-4">
                                    <div class="input-group">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text">Icon Class:</label>
                                            </span>

                                        {{Form::text('icon_class',$data->icon_class,['class'=>'form-control','placeholder'=>'Ex: fa fa-folder'])}}
                                        @if ($errors->has('icon_class'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('icon_class') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group ">
                                    <div class="col-md-2">
                                        <label class="slide_upload profile-image" for="file">

                                            @if(!empty($data->big_icon) && file_exists($data->big_icon))

                                                <img id="image_load" src="{{asset($data->big_icon)}}" style="width: 100px;height:auto; cursor:pointer;border-radius:50%;">

                                                @else
                                                <img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 100px;height: auto; cursor:pointer;border-radius:50%;">
                                            @endif
                                        </label>

                                        <input id="file" style="display:none" name="icon" type="file" onchange="photoLoad(this,this.id)" accept="image/*">
                                        @if ($errors->has('icon'))
                                            <span class="help-block text-danger">
                                                    <strong>The icon image dimensions(Y, X) should not be less then 120 and grater then 240</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-3">
                                    <strong> Menu As </strong>
                                    {{Form::select('menu_as', ['Category'=>'Category','Author'=>'Author'],'', ['id'=>'menuAs','placeholder'=>'--Select One--','class' => ' form-control'])}}
                                </div>

                                <div class="col-md-4">
                                    <strong> Menu As Category</strong>
                                    {{Form::select('category_id', $categories,$data->category_id, ['id'=>'Category','placeholder'=>'--Select Category--','class' => ' form-control'])}}
                                </div>
                                <div class="col-md-4">
                                    <strong>Menu As Author</strong>
                                    {{Form::select('author_id', $authors,$data->author_id, ['id'=>'Author','placeholder'=>'--Select Author--','class' => ' form-control'])}}
                                </div>
                            </div>


                            <div class="form-group row">

                                {{Form::label('serial_num', 'Others', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-2">
                                    {{Form::number('serial_num',$data->serial_num,['class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max_serial",'min'=>'0','required'=>true])}}
                                    <small> Serial </small>
                                </div>

                                <div class="col-md-3">
                                    {{Form::select('menu_for', $menuFor,$data->menu_for, ['class' => 'form-control'])}}
                                    <small> Menu For </small>
                                </div>

                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\Menu::ACTIVE  => \App\Models\Menu::ACTIVE , \App\Models\Menu::INACTIVE  => \App\Models\Menu::INACTIVE],$data->status, ['class' => 'form-control'])}}
                                    <small> Status </small>
                                </div>

                                <div class="col-md-3">
                                    {{Form::select('open_new_tab', [\App\Models\Menu::NO_OPEN_NEW_TAB  => \App\Models\Menu::NO_OPEN_NEW_TAB , \App\Models\Menu::OPEN_NEW_TAB  => \App\Models\Menu::OPEN_NEW_TAB],$data->open_new_tab, ['class' => 'form-control'])}}
                                    <small> Open New Tab? </small>
                                </div>

                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-3 col-form-label">Permission</label>
                                <div class="col-9">
                                    {!! Form::select('slug[]', $permissions,json_decode($data->slug), array('id'=>'kt_select2_3','class' => 'form-control kt-select2','multiple'=>true,'required'=>true)) !!}

                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                        </div> <!-- end kt-portlet__body -->


                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        @can('menu')
                                            <a href="{{route('menu.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <!--End::Row-->

        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->

@endsection

@section('script')
    <script type="text/javascript">

        $('#menuAs').on('click',function () {
            let menuAs=$(this).val()

            if(menuAs=='Category'){
                $('#Category').attr('required',true)
                $('#Category').parent().css('display','block')

                $('#Author').attr('required',false)
                $('#Author').parent().css('display','none')

            }else if(menuAs=='Author') {
                $('#Category').attr('required',false)
                $('#Category').parent().css('display','none')

                $('#Author').attr('required',true)
                $('#Author').parent().css('display','block')
            }else{
                $('#Category').attr('required',false)
                $('#Author').attr('required',false)
            }
        })

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