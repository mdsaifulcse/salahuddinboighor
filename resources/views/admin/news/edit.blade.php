@extends('layouts.vmsapp')

@section('title')
Edit classified Info
@endsection

@section('style')
	<!-- for taging -->
	<link rel="stylesheet" href="{{asset('/tagging/css/jqueryui1.12.1-ui.css')}}">
	<link rel="stylesheet" href="{{asset('/tagging/css/jquery.tagit.css')}}">
	<link rel="stylesheet" href="{{asset('/tagging/css/tagit.ui-zendesk.css')}}">
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Edit classified Info
@endsection

@section('subheader-action')
    @can('news-list')
        <a href="{{ route('news.index') }}" class="btn btn-success pull-right">
           Go classified list
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="kt-portlet">
				{!! Form::open(array('route' => ['news.update',$news->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
										<div class="kt-portlet__head form-header">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title">
													Update Classified Information
												</h3>
											</div>
										</div>
										<!--begin::Form-->

											<div class="kt-portlet__body">
												 
												<div class="row">
													<div class="form-group col-md-7">
														<label for="example-text-input" class="col-form-label">Title<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::text('title', $value=old('title',$news->title), array('placeholder' => 'Classified Title Here *','class' => 'form-control','required'=>true)) !!}

															@if ($errors->has('title'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

													<div class="form-group col-md-3">
														<label for="example-text-input" class="col-form-label">Topic<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::text('topic[]', $value=old('topic',$news->topic), ['id'=>'topicField','placeholder' => 'Classified Topic Here *','class' => 'form-control','required'=>false,'style'=>'display:none',]) !!}

															<ul id="topicFieldUl"></ul>

															@if ($errors->has('topic'))
																<span class="help-block">
																	<strong class="text-danger">{{ $errors->first('topic') }}</strong>
																</span>
															@endif

															<span class="text-danger text-center" id="topicError"></span>
														</div>
													</div>
													<div class="form-group col-md-2">
														<label for="example-text-input" class="col-form-label">Published Status<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('published_status', [\App\Models\News::PUBLISHED=>\App\Models\News::PUBLISHED,\App\Models\News::UNPUBLISHED=>\App\Models\News::UNPUBLISHED],$news->published_status, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('published_status'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('published_status') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

												</div><!-- end row -->

												<div class="row">
													<div class="form-group col-md-10">
														<label for="example-text-input" class="col-form-label">Classified Meta Details<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::textArea('meta_description', $value=old('meta_description',$news->meta_description), ['rows'=>3,'placeholder' => 'Classified Meta Details Here ','class' => 'form-control ','required'=>true]) !!}


															@if ($errors->has('meta_description'))
																<span class="help-block">
														<strong class="text-danger">{{ $errors->first('meta_description') }}</strong>
												</span>
															@endif
														</div>
														<span id="descriptionError" class="text-danger"></span>
													</div>


												</div><!-- end row -->
												<div class="row">
													<div class="form-group col-md-10">
														<label for="example-text-input" class="col-form-label">Classified Details<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::textArea('description', $value=old('description',$news->description), ['rows'=>8,'placeholder' => 'Classified Details Here ','class' => 'form-control textarea','required'=>false]) !!}


															<strong class="text-default pull-right description-error"><span id="character_count">0</span> /5000 </strong>

															@if ($errors->has('description'))
																<span class="help-block">
														<strong class="text-danger">{{ $errors->first('description') }}</strong>
												</span>
															@endif
														</div>
														<span id="descriptionError" class="text-danger"></span>
													</div>

													<div class="form-group col-md-2">
														<label for="example-text-input" class=" col-form-label">Feature Image(750x390) <sup class="text-danger">*</sup></label>
														<div class="">

															<label class="slide_upload" for="featurePhoto">
																@if(!empty($news->feature_photo) && file_exists($news->feature_photo))

																	<img id="image_load" src="{{asset($news->feature_photo)}}" style="width: 150px; height: 150px;cursor:pointer;border:2px dashed #260d53;">
																@else
																	<img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 150px; height: 150px;cursor:pointer;border:2px dashed #260d53;">
																@endif

															</label>
															<input id="featurePhoto" style="display:none" name="feature_photo" type="file" onchange="photoLoad(this,this.id)" accept="image/*">


															@if ($errors->has('feature_photo'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('feature_photo') }}</strong>
                                                    </span>
															@endif
														</div>
														<span class="text-danger text-center" style="display:none" id="fimageError">Feature Image is Required  </span>
													</div>

												</div><!-- end row -->

												<div class="row">
													<div class="form-group col-md-5">
														<label for="example-text-input" class="col-form-label">Feature Image Caption</label>
														<div class="">
															{!! Form::text('photo_caption', $value=old('photo_caption',$news->photo_caption), array('placeholder' => 'Image Caption Here','class' => 'form-control','required'=>false)) !!}

															@if ($errors->has('photo_caption'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('photo_caption') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

													<div class="form-group col-md-3">
														<label for="example-text-input" class="col-form-label">Video Link</label>
														<div class="">
															{!! Form::text('video_url', $value=old('video_url',$news->video_url), ['id'=>'video_link','placeholder' => 'Past Video Link','class' => 'form-control','required'=>false,]) !!}

															@if ($errors->has('video_url'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('video_url') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

													<div class="form-group col-md-2">
														<label for="example-text-input" class="col-form-label">Show at Homepage?<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('show_at_homepage', [\App\Models\News::YES=>\App\Models\News::YES,\App\Models\News::NO=>\App\Models\News::NO],$news->show_at_homepage, ['placeholder' => 'Select One *','class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('show_at_homepage'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('show_at_homepage') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

													<div class="form-group col-md-2" style="display: none;">
														<label for="example-text-input" class="col-form-label">Is Cover Classified?<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('is_cover_news', [\App\Models\News::YES=>\App\Models\News::YES,\App\Models\News::NO=>\App\Models\News::NO],$news->is_cover_news, ['class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('is_cover_news'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('is_cover_news') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

												</div><!-- end row -->


												<div class="row">

													<div class="form-group col-md-3">
														<label for="example-text-input" class="col-form-label">Classified Author<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('news_author_id',$newsAuthors,$news->news_author_id, ['placeholder' => 'Select Author *','class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('news_author_id'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('news_author_id') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

													<div class="form-group col-md-2">
														<label for="example-text-input" class="col-form-label">Category<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('category_id',$categories,$news->category_id, ['id'=>'loadSubCategory','placeholder' => 'Select Category *','class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('category_id'))
																<span class="help-block">
																	<strong class="text-danger">{{ $errors->first('category_id') }}</strong>
																</span>
															@endif
														</div>
													</div>


													<div class="form-group col-md-2">
														<label for="example-text-input" class="col-form-label">Sub Category</label>
														<div class="" id="subCategory">
															{!! Form::select('sub_cat_id',$subCats,$news->sub_cat_id, ['placeholder' => 'First Select Category','class' => 'form-control','required'=>false]) !!}

															@if ($errors->has('sub_cat_id'))
																<span class="help-block">
																	<strong class="text-danger">{{ $errors->first('sub_cat_id') }}</strong>
																</span>
															@endif
														</div>
													</div>


													<div class="form-group col-md-2">
														<label for="example-text-input" class="col-form-label">States<sup class="text-danger">*</sup></label>
														<div class="">
															{!! Form::select('division_id',$states,$news->division_id, ['placeholder' => 'Select States *','class' => 'form-control','required'=>true]) !!}

															@if ($errors->has('division_id'))
																<span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('division_id') }}</strong>
                                                    </span>
															@endif
														</div>
													</div>

												</div><!-- end row -->

											</div> <!--End kt-portlet__body -->


											<div class="kt-portlet__foot form-footer">
												<div class="kt-form__actions">
													<div class="row">

														<div class="col-10">
															<button type="submit" class="btn btn-success" onclick="return ValidateCharacterLength()">Submit</button>
															<button type="reset" class="btn btn-secondary pull-right">Cancel</button>
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


                if($('#topicFieldUl li').length<2){
                    $('#errorPhoto').html('');

                    $('#topicError').html('Topic is required.');

                    return false
                }else {
                    $('#topicError').html('');
				}



                return;
            }
        }



	</script>

	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="{{asset('/tagging/js/jquery-1.12.1-ui.min.js')}}"></script>
	<script src="{{asset('/tagging/js/tag-it.min.js')}}"></script>

	<script>

        $(function(){
            var country_list = ["Bangladesh","Barma","Bronai","Afghanistan"];
            //-------------------------------
            // Input field
            //-------------------------------
            $('#topicFieldUl').tagit({
                //availableTags: ["Afghanistan","Bantladesh"],
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
                singleFieldNode: $('#topicField'),
                allowSpaces: true,
                tagLimit:5,
                placeholderText:'Enter Classified Topics (Max 3)',
            });
        });
	</script>


	<script>
		$('#loadSubCategory').on('change',function () {

			var id=$(this).val()


			if(id.length===0)
			{
			    id=0
                $('#subCategory').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-cat-by-cat")}}/'+id);

			}else {

            $('#subCategory').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("load-sub-cat-by-cat")}}/'+id);
            }

        })

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





