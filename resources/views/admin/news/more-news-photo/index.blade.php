@extends('layouts.vmsapp')

@section('title')
    classified More Photo
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    classified More Photo for > {{$news->title}}
@endsection

@section('subheader-action')
    @can('news-list')
        <a href="#moreNewsPhotoModal" data-toggle="modal" data-target="#moreNewsPhotoModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Add New
        </a>
    @endcan

    @can('news-list')
        <a href="{{ route('news.index') }}" class="btn btn-success pull-right">
            <i class="la la-angle-left"></i> Back to All classified
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
            <div class="modal fade" id="moreNewsPhotoModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'more-news-photo.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}

                        <input type="hidden" name="news_id" value="{{$news->id}}" >
                        <div class="modal-header">
                            <h4 class="modal-title">Add More classified Photo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{Form::label('classified Details', 'classified Details', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-10">
                                    <div class="">
                                        {!! Form::textArea('description', $value=old('description'), ['rows'=>8,'placeholder' => 'classified Details Here ','class' => 'form-control textarea','required'=>false]) !!}


                                        <strong class="text-default pull-right description-error"><span id="character_count">0</span> /5000 </strong>

                                        @if ($errors->has('description'))
                                            <span class="help-block">
														<strong class="text-danger">{{ $errors->first('description') }}</strong>
												</span>
                                        @endif
                                    </div>
                                    <span id="descriptionError" class="text-danger"></span>
                                </div>

                            </div>


                            <div class="form-group row {{ $errors->has('photo') ? 'has-error' : '' }}">
                                {{Form::label('Image', 'Image', array('class' => 'col-md-2 control-label'))}} (750x390)
                                <div class="col-md-2">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input class="newsImage" type="file" id="file" style="display: none;" name="photo" onchange="photoLoad(this, this.id)" />

                                    @if ($errors->has('photo'))
                                        <span class="help-block" style="display:block">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <span class="text-danger text-center newsImageError" style="display:none">Image is Required  </span>

                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\NewsDetailPhoto::ACTIVE  => \App\Models\NewsDetailPhoto::ACTIVE , \App\Models\NewsDetailPhoto::INACTIVE  => \App\Models\NewsDetailPhoto::INACTIVE],[], ['class' => 'form-control'])}}
                                </div>
                            </div>

                        </div><!--end body -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success " onclick="return ValidateCharacterLength()">Submit</button>
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
                            <th>Title</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @forelse($allData as $data)
                            <tr>
                                <td>{{$i++}}</td>
                                <td> {{$news->title}} </td>
                                <td>
                                    <img src="{{asset($data->photo)}}" style="width:80px">
                                </td>

                                <td><i class="{{($data->status==\App\Models\NewsDetailPhoto::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['more-news-photo.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#editNewsPhotoModal{{$data->id}}" data-toggle="modal" data-target="#editNewsPhotoModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>


                                <!-- begin::modal -->

                                <div class="modal fade show" id="editNewsPhotoModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        {!! Form::open(array('route' => ['more-news-photo.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit photo for > {{$news->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                                    {{Form::label('classified Details', 'classified Details', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-10">
                                                        <div class="">
                                                            {!! Form::textArea('description', $value=old('description',$data->description), ['rows'=>8,'placeholder' => 'classified Details Here ','class' => 'form-control textarea','required'=>false]) !!}


                                                            <strong class="text-default pull-right description-error"><span id="character_count">0</span> /5000 </strong>
                                                            @if ($errors->has('description'))
                                                                <span class="help-block">
                                                                    <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span id="descriptionError" class="text-danger"></span>
                                                    </div>

                                                </div>


                                                <div class="form-group row {{ $errors->has('photo') ? 'has-error' : '' }}">
                                                    {{Form::label('Image', 'Image', array('class' => 'col-md-2 control-label'))}} (750x390)
                                                    <div class="col-md-2">
                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">

                                                            @if(!empty($data->photo) && file_exists($data->photo))
                                                            <img id="image_load{{$data->id}}" src="{{asset($data->photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @else
                                                                <img id="image_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                                            @endif
                                                        </label>
                                                        <input class="newsImage" type="file" id="file{{$data->id}}" style="display: none;" name="photo" onchange="photoLoad(this, this.id)" />

                                                        @if ($errors->has('photo'))
                                                            <span class="help-block" style="display:block">
                                                                <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-danger text-center newsImageError" style="display:none">Image is Required  </span>

                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\NewsDetailPhoto::ACTIVE  => \App\Models\NewsDetailPhoto::ACTIVE , \App\Models\NewsDetailPhoto::INACTIVE  => \App\Models\NewsDetailPhoto::INACTIVE],[], ['class' => 'form-control'])}}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <button type="button" class="btn btn-brand pull-right" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
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

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.textarea',
            menubar: false,
            theme: 'modern',
            plugins: 'image code link lists textcolor imagetools colorpicker ',
            browser_spellcheck: true,
            toolbar1: 'formatselect | bold italic strikethrough | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            // enable title field in the Image dialog
            image_title: true,
            setup: function (ed) {
                ed.on('keyup', function (e) {
                    var count = CountCharacters();
                    document.getElementById("character_count").innerHTML = "Characters: " + count;
                });
            }
        });


        function CountCharacters() {
            var body = tinymce.get("description").getBody();
            var content = tinymce.trim(body.innerText || body.textContent);
            return content.length;
        };
        function ValidateCharacterLength() {
            var max = 5000;
            var count = CountCharacters();
            if (count > max) {
                alert("Maximum " + max + " characters allowed.")
                return false;
            }else if(count<=10) {
                alert("Minimum " + 50 + " characters required for news description")

                return false;
            }else{

                var imgVal = $('.newsImage').val();
                if(imgVal=='')
                {
                    $('.newsImageError').show();
                    return false;
                }else{
                    $('.newsImageError').hide();
                }

                return;
            }
        }

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
