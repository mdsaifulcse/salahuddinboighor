@extends('layouts.vmsapp')

@section('title')
    Categories | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Categories | Create
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
                        {!! Form::open(array('route' => 'categories.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new categories
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                 {{Form::label('category_name', __("admin.Category Name"), array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-8">
                                     {{Form::text('category_name',$value=old('category_name'),array('class'=>'form-control','placeholder'=>__('admin.Category Name'),'required','autofocus'))}}
                                 @if ($errors->has('category_name'))
                                     <span class="help-block"><strong class="text-danger">{{ $errors->first('category_name') }}</strong></span>
                                 @endif
                                 </div>

                                 <div class="col-md-2">
                                     {{Form::select('status', [\App\Models\Category::ACTIVE  => \App\Models\Category::ACTIVE , \App\Models\Category::INACTIVE  => \App\Models\Category::INACTIVE,\App\Models\Category::OTHER  => \App\Models\Category::OTHER],[], ['class' => 'form-control'])}}
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('category_name_bn') ? 'has-error' : '' }}">

                                 {{Form::label('category_name_bn', __("admin.Category Name Bn"), array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-8">
                                     {{Form::text('category_name_bn',$value=old('category_name_bn'),array('class'=>'form-control','placeholder'=>__('admin.Category Name Bn'),'required','autofocus'))}}
                                     @if ($errors->has('category_name_bn'))
                                         <span class="help-block"><strong class="text-danger">{{ $errors->first('category_name_bn') }}</strong></span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('url') ? 'has-error' : '' }}">
                                 {{Form::label('URL', 'Category Url', array('class' => 'col-md-2 control-label'))}}

                                 <div class="col-md-8">
                                     {{Form::text('link',$value=old('link'),array('class'=>'form-control','placeholder'=>'Optional'))}}

                                     @if ($errors->has('link'))
                                         <span class="help-block">
                        				    <strong class="text-danger">{{ $errors->first('link') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                                 <div class="col-md-2">
                                     {{Form::select('show_home', [\App\Models\Category::NO  => \App\Models\Category::NO , \App\Models\Category::YES  => \App\Models\Category::YES],[], ['class' => 'form-control'])}}
                                     <span class="text-success">Show at home page</span>
                                 </div>

                             </div>

                             <div class="form-group row">
                                 {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-10">
                                     {{Form::textArea('short_description',$value=old('short_description'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description for Home Page'])}}
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

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>SL</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th>Show Home page</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @forelse($allData as $data)
                            <tr>
                                <td>{{$data->serial_num}}</td>
                                <td><a href="{{route('categories.edit',$data->id)}}"><i class="{{$data->icon_class}}"></i> {{$data->category_name}}</a></td>
                                <td>{{$data->link}}</td>

                                <td>
                                    @can('sub-categories')
                                    <a class="btn btn-sm btn-sm btn-info" href='{{route('sub-categories.show',$data->id)}}'>Sub Category ({{$data->subCategoryData->count()}})</a>
                                    @endcan
                                </td>

                                <td>
                                    @if($data->status==\App\Models\Category::ACTIVE)
                                        <i class="fa fa-check-circle text-success"></i> {{$data->status}}
                                        @elseif($data->status==\App\Models\Category::INACTIVE)
                                        <i class="fa fa-times-circle text-danger"></i> {{$data->status}}
                                        @elseif($data->status==\App\Models\Category::OTHER)
                                        <i class="fa fa-bolt text-info"></i> {{$data->status}}
                                        @endif
                                </td>
                                <td>
                                    @if($data->show_home==\App\Models\Category::YES)
                                        <i class="fa fa-check-circle text-success"></i> {{$data->show_home}}
                                        @elseif($data->show_home==\App\Models\Category::NO)
                                        <i class="fa fa-times-circle text-danger"></i> {{$data->show_home}}
                                        @elseif($data->show_home==\App\Models\Category::OTHER)
                                        <i class="fa fa-bolt text-info"></i> {{$data->show_home}}
                                        @endif
                                </td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['categories.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#categoryModal{{$data->id}}" data-toggle="modal" data-target="#categoryModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>




                                <!-- begin::modal -->

                                <div class="modal fade show" id="categoryModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            {!! Form::open(array('route' => ['categories.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit  Category Info | {{$data->category_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            <div class="modal-body">



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
                                                        {{Form::select('status', [\App\Models\Category::ACTIVE  => \App\Models\Category::ACTIVE , \App\Models\Category::INACTIVE  => \App\Models\Category::INACTIVE,\App\Models\Category::OTHER  => \App\Models\Category::OTHER],$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>

                                                <div class="form-group row {{ $errors->has('category_name_bn') ? 'has-error' : '' }}"">

                                                {{Form::label('category_name_bn', __('Category Name Bn'), array('class' => 'col-md-2 control-label'))}}
                                                <div class="col-md-8">
                                                    {{Form::text('category_name_bn',$value=old('category_name_bn',$data->category_name_bn),array('class'=>'form-control','placeholder'=>__('Category Name Bn'),'required','autofocus'))}}
                                                    @if ($errors->has('category_name_bn'))
                                                        <span class="help-block"><strong class="text-danger">{{ $errors->first('category_name_bn') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>


                                                <div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">
                                                    {{Form::label('Link', 'URL', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('link',$value=$data->link,array('class'=>'form-control','placeholder'=>'Category Name','required','autofocus'))}}
                                                        @if ($errors->has('link'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('link') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-2">
                                                        {{Form::select('show_home', [\App\Models\Category::NO  => \App\Models\Category::NO , \App\Models\Category::YES  => \App\Models\Category::YES],$data->show_home, ['class' => 'form-control'])}}
                                                        <span class="text-success">Show at home page</span>
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
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            <!--  -->
                                                            @if(!empty($data->icon_photo))
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
                                                        {{Form::text('icon_class',$data->icon_class,array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
                                                        <span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/">ion icons</a></span>
                                                    </div>
                                                    <?php $max=$max_serial+1; ?>
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                        <span>Category Serial</span>
                                                    </div>
                                                </div>


                                            </div><!--end body-->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-brand">Submit</button>
                                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                            </div>
                                            {!! Form::close() !!}
                                        </div><!--end content-->

                                    </div>
                                </div>


                                <!-- end::modal -->



                            </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Menu Data ! </td>
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
