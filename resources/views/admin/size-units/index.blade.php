@extends('layouts.vmsapp')

@section('title')
	Unit Size | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Unit Size | List
@endsection

@section('subheader-action')
	@can('size-units')
		<a href="#tagModal" data-target="#tagModal" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Unit Size
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
						{!! Form::open(['route' => 'size-units.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Create new Unit Size</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('unit-size') ? 'has-error' : '' }}">
								{{Form::label('Unit_Size', 'Unit Size', array('class' => 'col-md-2 control-label'))}}
								<div class="col-md-8">
									{{Form::text('size',$value=old('size'),array('class'=>'form-control','placeholder'=>'Unit Size Name','required','autofocus'))}}
									@if ($errors->has('size'))
										<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('size') }}</strong>
                    					</span>
									@endif
								</div>
								<div class="col-md-2">
									{{Form::select('status', [\App\Models\PackSizeUnit::ACTIVE  => \App\Models\PackSizeUnit::ACTIVE , \App\Models\PackSizeUnit::INACTIVE  => \App\Models\PackSizeUnit::INACTIVE],[], ['class' => 'form-control'])}}
								</div>
							</div>

							<div class="form-group row">
								<label class="control-label col-md-2 col-sm-3"> Url:</label>
								<div class="col-md-8 col-sm-8">
									<input type="text" class="form-control" name="link" value="{{old('link')}}" placeholder="optional">
								</div>

								<div class="col-md-2">
									{{Form::select('label', [\App\Models\PackSizeUnit::PACK_SIZE  => \App\Models\PackSizeUnit::PACK_SIZE , \App\Models\PackSizeUnit::UNIT  => \App\Models\PackSizeUnit::UNIT],[], ['class' => 'form-control'])}}
									<span>Label</span>
								</div>
							</div>


							<div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
								{{Form::label('', '', array('class' => 'col-md-2 control-label'))}}

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
							<th>Unit Size</th>
							<th>Link</th>
							<th>Label</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>

						@foreach($sizeUnits as $key=>$data)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$data->size}}</td>
								<td>{{$data->link}}</td>
								<td>{{$data->label}}</td>
								<td>
									@if($data->status==\App\Models\PackSizeUnit::ACTIVE)
										<i class="fa fa-check-circle text-success"></i> {{$data->status}}
									@elseif($data->status==\App\Models\PackSizeUnit::INACTIVE)
										<i class="fa fa-times-circle text-danger"></i> {{$data->status}}
									@elseif($data->status==\App\Models\PackSizeUnit::DRAFT)
										<i class="fa fa-bolt text-info"></i> {{$data->status}}
									@endif
								</td>

								<td>

									<!-- #roleModal -->
									<div class="modal fade" id="tagModal{{$data->id}}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												{!! Form::open(['route' => ['size-units.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
												<div class="modal-header">
													<h4 class="modal-title">Edit Size Unit</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">

													<div class="form-group row {{ $errors->has('size') ? 'has-error' : '' }}">
														{{Form::label('Size_Unit', 'Size Unit', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-8">
															{{Form::text('size',$value=old('size',$data->size),array('class'=>'form-control','placeholder'=>'Origin Name','required','autofocus'))}}
															@if ($errors->has('size'))
																<span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('size') }}</strong>
                    			</span>
															@endif
														</div>
														<div class="col-md-2">
															{{Form::select('status', [\App\Models\PackSizeUnit::ACTIVE  => \App\Models\PackSizeUnit::ACTIVE , \App\Models\PackSizeUnit::INACTIVE  => \App\Models\PackSizeUnit::INACTIVE],$data->status, ['class' => 'form-control'])}}
														</div>
													</div>

													<div class="form-group row">
														<label class="control-label col-md-2 col-sm-3"> Url:</label>
														<div class="col-md-8 col-sm-8">
															<input type="text" class="form-control" name="link" value="{{old('link',$data->link)}}" required placeholder="Optional">
														</div>

														<div class="col-md-2">
															{{Form::select('label', [\App\Models\PackSizeUnit::PACK_SIZE  => \App\Models\PackSizeUnit::PACK_SIZE , \App\Models\PackSizeUnit::UNIT  => \App\Models\PackSizeUnit::UNIT],$data->label, ['class' => 'form-control'])}}
															<span>Label</span>
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

									{!! Form::open(array('route' => ['size-units.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
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





