@extends('layouts.vmsapp')

@section('title')
    Pges | List
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Page | Create
@endsection

@section('subheader-action')
    @can('pages')
        <a href="#pagesModal" data-toggle="modal" data-target="#pagesModal" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Page
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
            <div class="modal fade" id="pagesModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        {!! Form::open(['route' => 'pages.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
                        <div class="modal-header">
                            <h4 class="modal-title">Create new page</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{Form::label('title', ' Page Title', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-8">
                                    {{Form::text('title',$value=old('title'),array('class'=>'form-control','placeholder'=>'Page title here','required','autofocus'))}}
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('title') }}</strong>
                    			</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', [\App\Models\Page::ACTIVE  => \App\Models\Page::ACTIVE , \App\Models\Page::INACTIVE  => \App\Models\Page::INACTIVE], '', ['class' => 'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group  row ">
                                {{Form::label('description', ' Page Details', array('class' => 'col-md-2 control-label'))}}
                                <div class=" col-md-8 col-lg-10 ">
                                    <label class="control-label"></label>

                                    <textarea class="form-control textarea" name="description" placeholder="Page Details Here" rows="5" value="{{old('description')}}" ></textarea>

                                </div>
                            </div>





                            <div class="form-group  row  {{ $errors->has('photo') ? 'has-error' : '' }}">
                                {{Form::label('icon_photo', 'Photo', array('class' => 'col-md-2 control-label'))}}
                                <div class="col-md-3">
                                    <label class="upload_photo upload icon_upload" for="file">
                                        <!--  -->
                                        <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                        {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                    </label>
                                    <input type="file" id="file" style="display: none;" name="photo" onchange="photoLoad(this, this.id)" accept="image/*" />
                                    @if ($errors->has('photo'))
                                        <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('photo') }}</strong>
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
                            <th>Title</th>
                            <th>Photo</th>
                            <th>Link</th>
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
                                <td>
                                    {{$data->title}}
                                </td>

                                <td>
                                    @if(isset($data->pagePhoto) && file_exists($data->pagePhoto->photo))
                                        <img id="logo_load" src="{{asset($data->pagePhoto->photo)}}" style="max-width: 80px;border: 2px dashed #2783bb; cursor: pointer">
                                    @else
                                        <h4 class="text-danger text-center">No Photo</h4>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{URL::to('/page/'.$data->link)}}" target="_blank">{{URL::to('/page/'.$data->link)}}</a>
                                </td>

                                <td><i class="{{($data->status==\App\Models\Page::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>



                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['pages.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#pagesModal{{$data->id}}" data-toggle="modal" data-target="#pagesModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>




                                <!-- begin::modal -->

                                <div class="modal fade show" id="pagesModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit  Page Info | {{$data->division}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>
                                            {!! Form::open(array('route' => ['pages.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-body">


                                                <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                                    {{Form::label('title', ' Page Title', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('title',$value=$data->title,array('class'=>'form-control','placeholder'=>'Page title here','required','autofocus'))}}
                                                        @if ($errors->has('title'))
                                                            <span class="help-block">
                                                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{Form::select('status', [\App\Models\Page::ACTIVE  => \App\Models\Page::ACTIVE , \App\Models\Page::INACTIVE  => \App\Models\Page::INACTIVE], $data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>

                                                <div class="form-group row {{ $errors->has('link') ? 'has-error' : '' }}">
                                                    {{Form::label('link', ' Page Link', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('link',$value=$data->link,array('class'=>'form-control','placeholder'=>'Page title here','required','autofocus'))}}
                                                        @if ($errors->has('link'))
                                                            <span class="help-block">
                                                                    <strong class="text-danger">{{ $errors->first('link') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group  row ">
                                                    {{Form::label('description', ' Page Details', array('class' => 'col-md-2 control-label'))}}
                                                    <div class=" col-md-8 col-lg-10 ">
                                                        <label class="control-label"></label>

                                                        <textarea class="form-control textarea" name="description" placeholder="Page Details Here" rows="5" value="{{old('description')}}" ><?php echo $data->description;?></textarea>

                                                    </div>
                                                </div>





                                                <div class="form-group  row  {{ $errors->has('photo') ? 'has-error' : '' }}">
                                                    {{Form::label('icon_photo', 'Photo', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-3">

                                                        <label class="upload_photo upload icon_upload" for="file{{$data->id}}">
                                                            @if(isset($data->pagePhoto) && file_exists($data->pagePhoto->photo))
                                                                <img id="logo_load{{$data->id}}" src="{{asset($data->pagePhoto->photo)}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                                            @else
                                                                <img id="logo_load{{$data->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 90px;border: 2px dashed #2783bb; cursor: pointer">
                                                            @endif

                                                        </label>
                                                        <input type="file" id="file{{$data->id}}" style="display: none;" name="photo" onchange="photoLoad(this, this.id)" accept="image/*" />
                                                        @if ($errors->has('photo'))
                                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('photo') }}</strong>
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
