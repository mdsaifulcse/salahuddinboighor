@extends('layouts.vmsapp')

@section('title')
	Origin | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Origin | List
@endsection

@section('subheader-action')
	@can('origins')
		<a href="#tagModal" data-target="#tagModal" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Origin
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
			<div class="modal fade" id="tagModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						{!! Form::open(['route' => 'origins.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Create new origin</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('origin') ? 'has-error' : '' }}">
								{{Form::label('Orgin_name', 'Origin Name', array('class' => 'col-md-2 control-label'))}}
								<div class="col-md-8">
									{{Form::text('origin',$value=old('origin'),array('class'=>'form-control','placeholder'=>'Origin Name','required','autofocus'))}}
									@if ($errors->has('origin'))
										<span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('origin') }}</strong>
                    			</span>
									@endif
								</div>
								<div class="col-md-2">
									{{Form::select('status', [\App\Models\Origin::ACTIVE  => \App\Models\Origin::ACTIVE , \App\Models\Origin::INACTIVE  => \App\Models\Origin::INACTIVE],[], ['class' => 'form-control'])}}
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-2 col-sm-3"> Url:</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="link" value="{{old('link')}}" placeholder="optional">
								</div>
							</div>


							<div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
								{{Form::label('', '', array('class' => 'col-md-2 control-label'))}}
								{{--<div class="col-md-2">
									<label class="upload_photo upload icon_upload" for="file">
										<!--  -->
										<img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
										--}}{{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}{{--
									</label>
									<input type="file" id="file" style="display: none;" name="icon_photo" onchange="photoLoad(this, this.id)" accept="image/*" />
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
								</div>--}}
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

					<table id="data-table" class="table table-striped table-hover table-bordered center_table" width="100%">
						<thead>
						<tr class="bg-dark text-white">
							<th>Sl</th>
							<th>Origin Name</th>
							<th>Link</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>

						@foreach($origins as $key=>$data)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$data->origin}}</td>
								<td>{{$data->link}}</td>
								<td>
									@if($data->status==\App\Models\Origin::ACTIVE)
										<i class="fa fa-check-circle text-success"></i> {{$data->status}}
									@elseif($data->status==\App\Models\Origin::INACTIVE)
										<i class="fa fa-times-circle text-danger"></i> {{$data->status}}
									@elseif($data->status==\App\Models\Origin::DRAFT)
										<i class="fa fa-bolt text-info"></i> {{$data->status}}
									@endif
								</td>

								<td>

									<!-- #roleModal -->
									<div class="modal fade" id="tagModal{{$data->id}}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												{!! Form::open(['route' => ['origins.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
												<div class="modal-header">
													<h4 class="modal-title">Edit Origin</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">

													<div class="form-group row {{ $errors->has('origin') ? 'has-error' : '' }}">
														{{Form::label('Origin', 'Origin Name', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-8">
															{{Form::text('origin',$value=old('origin',$data->origin),array('class'=>'form-control','placeholder'=>'Origin Name','required','autofocus'))}}
															@if ($errors->has('origin'))
																<span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('origin') }}</strong>
                    			</span>
															@endif
														</div>
														<div class="col-md-2">
															{{Form::select('status', [\App\Models\Origin::ACTIVE  => \App\Models\Origin::ACTIVE , \App\Models\Origin::INACTIVE  => \App\Models\Origin::INACTIVE],$data->status, ['class' => 'form-control'])}}
														</div>
													</div>

													<div class="form-group row">
														<label class="control-label col-md-2 col-sm-3"> Url:</label>
														<div class="col-md-8 col-sm-8">
															<input type="text" class="form-control" name="link" value="{{old('link',$data->link)}}" required placeholder="Optional">
														</div>
													</div>


													<div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
														{{Form::label('', '', array('class' => 'col-md-2 control-label'))}}

                                                        <?php $max=$max_serial+1; ?>
														<div class="col-md-2">
															{{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
															<span> Serial No. </span>
														</div>
													</div>


												</div>

												<input type="hidden" value="{{$data->id}}" name="id"/>
												<div class="modal-footer">
													<button type="submit" class="btn btn-sm btn-success">Update</button>
													<a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
												</div>
												{!! Form::close(); !!}
											</div>
										</div>
									</div>
									{{-- End of Modal --}}

									{!! Form::open(array('route' => ['origins.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
									<a href="#tagModal{{$data->id}}" data-toggle="modal" data-target="#tagModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
									<button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
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





