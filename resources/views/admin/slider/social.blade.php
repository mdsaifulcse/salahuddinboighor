@extends('layouts.vmsapp')

@section('title')
	Social Media | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Social Media |
@endsection

@section('subheader-action')
	@can('social-icon')
		<a href="#socialModal" data-target="#socialModal" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Social Media
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
			<div class="modal fade" id="socialModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						{!! Form::open(['route' => 'social-icon.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Create new social media</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
								{{Form::label('name', 'Social Media Name', array('class' => 'col-md-2 control-label'))}}
								<div class="col-md-8">
									{{Form::text('name',$value=old('name'),array('class'=>'form-control','placeholder'=>'Social Media Name','required','autofocus'))}}
									@if ($errors->has('name'))
										<span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
									@endif
								</div>
								<div class="col-md-2">
									{{Form::select('status', [\App\Models\SocialIcon::ACTIVE  => \App\Models\SocialIcon::ACTIVE , \App\Models\SocialIcon::INACTIVE  => \App\Models\SocialIcon::INACTIVE],[], ['class' => 'form-control'])}}
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-2 col-sm-3"> Url *:</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="link" value="{{old('link')}}" required placeholder="facebook.com">
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
									<span> Serial No. </span>
								</div>
							</div>


						</div>

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

					<table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
						<thead>
						<tr>
							<th>Sl</th>
							<th>Name</th>
							<th>Icon Class</th>
							<th>Url</th>

							<th>Action</th>
						</tr>
						</thead>
						<tbody>
                        <?php $i=0; ?>
						@foreach($icons as $icon)
                            <?php $i++; ?>
							<tr>
								<td>{{$i}}</td>
								<td>{{$icon->name}}</td>
								<td>{{$icon->icon_class}}</td>
								<td>{{$icon->link}}</td>


								<td>

									<!-- #roleModal -->
									<div class="modal fade" id="roleModal{{$icon->id}}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												{!! Form::open(['route' => ['social-icon.update',$icon->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
												<div class="modal-header">
													<h4 class="modal-title">Edit Social Media</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">

													<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
														{{Form::label('name', 'Social Media Name', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-8">
															{{Form::text('name',$value=$icon->name,array('class'=>'form-control','placeholder'=>'Social Media Name','required','autofocus'))}}
															@if ($errors->has('name'))
																<span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
															@endif
														</div>
														<div class="col-md-2">
															{{Form::select('status', [\App\Models\SocialIcon::ACTIVE  => \App\Models\SocialIcon::ACTIVE , \App\Models\SocialIcon::INACTIVE  => \App\Models\SocialIcon::INACTIVE],$icon->status, ['class' => 'form-control'])}}
														</div>
													</div>

													<div class="form-group row">
														<label class="control-label col-md-2 col-sm-3"> Url *:</label>
														<div class="col-md-8 col-sm-8">
															<input type="text" class="form-control" name="link" value="{{$icon->link}}" required placeholder="facebook.com">
														</div>
													</div>


													<div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
														{{Form::label('icon_photo', 'Icon', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-2">
															<label class="upload_photo upload icon_upload" for="file{{$icon->id}}">
																<!--  -->
																@if(!empty($icon->icon_photo) && file_exists($icon->icon_photo))
																	<img id="image_load{{$icon->id}}" src="{{asset($icon->icon_photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

																@else
																	<img id="image_load{{$icon->id}}" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

																@endif
																{{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
															</label>
															<input type="file" id="file{{$icon->id}}" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" />
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
															{{Form::text('icon_class',$icon->icon_class,array('class'=>'form-control','placeholder'=>'Ex: fa fa-facebook, ion-gear-a'))}}
															<span>Use : <a class="btn btn-link" href="http://fontawesome.io/icons/">Font Awesome</a>, <a class="btn btn-link" href="http://ionicons.com/">ion icons</a></span>
														</div>
                                                        <?php $max=$max_serial+1; ?>
														<div class="col-md-2">
															{{Form::number('serial_num',$icon->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
															<span> Serial No. </span>
														</div>
													</div>


												</div>

												<input type="hidden" value="{{$icon->id}}" name="id"/>
												<div class="modal-footer">
													<button type="submit" class="btn btn-sm btn-success">Update</button>
													<a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
												</div>
												{!! Form::close(); !!}
											</div>
										</div>
									</div>
									{{-- End of Modal --}}

									{!! Form::open(array('route' => ['social-icon.destroy',$icon->id],'method'=>'DELETE','id'=>"deleteForm$icon->id")) !!}
									<a href="#roleModal{{$icon->id}}" data-toggle="modal" data-target="#roleModal{{$icon->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
									<button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$icon->id}}")'><i class="la la-trash"></i></button>
									{!! Form::close() !!}

								</td>
							</tr>
						@endforeach
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





