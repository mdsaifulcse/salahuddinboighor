@extends('layouts.vmsapp')

@section('title')
	Collection | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Collection | List
@endsection

@section('subheader-action')
	@can('collections')
		<a href="#CollectionhModal" data-target="#CollectionhModal" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Collection
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
			<div class="modal fade" id="CollectionhModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						{!! Form::open(['route' => 'collections.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Create new Collection</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('collection') ? 'has-error' : '' }}">
								{{Form::label('collection', 'Collection', array('class' => 'col-md-2 control-label'))}}
								<div class="col-md-5">
									{{Form::text('collection',$value=old('collection'),array('class'=>'form-control','placeholder'=>'Collection Name','required','autofocus'))}}
									@if ($errors->has('collection'))
										<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('collection') }}</strong>
                    					</span>
									@endif
								</div>

								<div class="col-md-2">
									{{Form::select('status', [\App\Models\Collection::ACTIVE  => \App\Models\Collection::ACTIVE , \App\Models\Collection::INACTIVE  => \App\Models\Collection::INACTIVE],[], ['class' => 'form-control'])}}
									<span> Status </span>
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

					<table id="data-table" class="table table-striped table-hover table-bordered center_table" width="100%">
						<thead>
						<tr class="bg-dark text-white">
							<th>Sl</th>
							<th>Collection</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>

						@foreach($collections as $key=>$data)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$data->collection}}</td>
								<td>
									@if($data->status==\App\Models\Collection::ACTIVE)
										<i class="fa fa-check-circle text-success"></i> {{$data->status}}
									@elseif($data->status==\App\Models\Collection::INACTIVE)
										<i class="fa fa-times-circle text-danger"></i> {{$data->status}}
									@elseif($data->status==\App\Models\Collection::DRAFT)
										<i class="fa fa-bolt text-info"></i> {{$data->status}}
									@endif
								</td>

								<td>

									<!-- #roleModal -->
									<div class="modal fade" id="CollectionhModal{{$data->id}}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												{!! Form::open(['route' => ['collections.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
												<div class="modal-header">
													<h4 class="modal-title">Edit Collection</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">

													<div class="form-group row {{ $errors->has('collection') ? 'has-error' : '' }}">
														{{Form::label('collection', 'Collection', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-5">
															{{Form::text('collection',$value=old('collection',$data->collection),array('class'=>'form-control','placeholder'=>'Collection Name','required','autofocus'))}}
															@if ($errors->has('collection'))
																<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('collection') }}</strong>
                    					</span>
															@endif
														</div>

														<div class="col-md-2">
															{{Form::select('status', [\App\Models\Collection::ACTIVE  => \App\Models\Collection::ACTIVE , \App\Models\Collection::INACTIVE  => \App\Models\Collection::INACTIVE],$data->status, ['class' => 'form-control'])}}
															<span> Status </span>
														</div>

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

									{!! Form::open(array('route' => ['collections.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
									<a href="#CollectionhModal{{$data->id}}" data-toggle="modal" data-target="#CollectionhModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
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





