@extends('layouts.vmsapp')

@section('title')
{{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	{{$title}}
@endsection

@section('subheader-action')
    @can('user-list')
        <a href="{{ route('publishers.index') }}" class="btn btn-success pull-right">
          <i class="la la-list"></i> Go Publisher list
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
				{!! Form::open(array('route' => 'publishers.store','method'=>'POST','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
										<div class="kt-portlet__head form-header">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title">
													Create new publisher by fill up required data
												</h3>
											</div>
										</div>

										<!--begin::Form-->

                                        
											<div class="kt-portlet__body">
												 
												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Name <sup class="text-danger">*</sup></label>
													<div class="col-9">
                                                    {!! Form::text('name', $value=old('name'), array('placeholder' => 'Name','class' => 'form-control','required'=>true)) !!}
                                                    
                                                    @if ($errors->has('name'))
                                                    <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
													</div>
												</div>

												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Mobile </label>
													<div class="col-9">
                                                   {!! Form::text('mobile', $value=old('mobile'), array('placeholder' => 'Mobile','class' => 'form-control','required'=>false)) !!}
                                                    
                                                   @if ($errors->has('mobile'))
                                                    <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                                    @endif
													</div>
												</div>

												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Email</label>
													<div class="col-9">
                                                   {!! Form::email('email', $value=old('email'), array('placeholder' => 'Email address','class' => 'form-control','required'=>false)) !!}

                                                   @if ($errors->has('email'))
                                                    <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
													</div>
												</div>


												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Address</label>
													<div class="col-9">
														{!! Form::text('address1', $value=old('address1'), array('placeholder' => 'Address','class' => 'form-control','required'=>false)) !!}

														@if ($errors->has('address1'))
															<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('address1') }}</strong>
                                                    </span>
														@endif
													</div>
												</div>



												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Contact no.</label>
													<div class="col-9">
														{!! Form::text('contact', $value=old('contact'), array('placeholder' => 'Contact number','class' => 'form-control','required'=>false)) !!}

														@if ($errors->has('contact'))
															<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('contact') }}</strong>
                                                    </span>
														@endif
													</div>
												</div>

												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Short Bio</label>
													<div class="col-9">

														{!! Form::textArea('bio', $value=old('bio'), ['rows'=>4,'placeholder' => 'Author Bio','class' => 'form-control textarea','required'=>false]) !!}
                                                   @if ($errors->has('bio'))
                                                    <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('bio') }}</strong>
                                                    </span>
                                                    @endif
													</div>
												</div>

												<div class="form-group row {{ $errors->has('establish') ? 'has-error' : '' }}">
													<label for="establish" class="col-3 col-form-label">Establish <sup class="text-danger">*</sup></label>
													<div class="col-md-9">
														{{Form::text('establish',$value=old('establish'),array('id'=>'EstablishDate','class'=>'form-control','placeholder'=>'Establish Date','required'=>true,'autofocus'))}}

														@if ($errors->has('establish'))
															<span class="help-block">
														<strong class="text-danger">{{ $errors->first('establish') }}</strong>
														</span>
														@endif
													</div>
												</div>



												<div class="form-group row">
													<label for="example-text-input" class="col-3 col-form-label">Logo</label>
													<div class="col-4">

														<label class="slide_upload" for="file">
															<!--  -->

															<img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 150px; height: 150px;cursor:pointer;">

														</label>
														<input id="file" style="display:none" name="photo" type="file" onchange="photoLoad(this,this.id)" accept="image/*">


														@if ($errors->has('photo'))
															<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                                                    </span>
														@endif
													</div>

													<div class="col-md-2">
                                                        <?php $max=$maxSerial+1; ?>
														{{Form::number('serial_num',"$max",['class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0','required'=>true])}}
														<small> Serial </small>
													</div>

													<div class="col-md-2">
														{{Form::select('status', $status	, '', ['class' => 'form-control'])}}
														<small> Status </small>
													</div>
												</div>

									
											</div>
											<div class="kt-portlet__foot form-footer">
												<div class="kt-form__actions">
													<div class="row">
														<div class="col-2">
														</div>
														<div class="col-10">
															<button type="submit" class="btn btn-success">Submit</button>

															@can('user-list')
																<a href="{{route('publishers.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
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
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
	<link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
	<script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
	<script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>
	<script>
        tinymce.init({
            selector: '.textarea',
            menubar: true,
            theme: 'modern',
            plugins: 'table image code link lists textcolor imagetools colorpicker ',
            browser_spellcheck: true,
            toolbar1: 'forecolor backcolor formatselect | bold italic strikethrough | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
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


	<script>
        $(function() {
            $('#EstablishDate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#EstablishDate').val('');
        });

	</script>

@endsection

<!-- Good -->





