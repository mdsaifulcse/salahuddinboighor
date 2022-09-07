@extends('layouts.vmsapp')

@section('title')
	Role Management
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Role Management
@endsection

@section('subheader')
	Role Management
@endsection

@section('subheader-action')
	@can('role-list')
		<a href="{{ route('roles.index') }}" class="btn btn-success pull-right">
			Role List
		</a>
	@endcan
@endsection

<!-- end:: Content Head -->


@section('content')

	<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">


		<!-- begin:: Content -->
		<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

			<div class="row justify-content-md-center justify-content-lg-center">
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">

					<div class="kt-portlet">

						{!! Form::open(array('route' => 'roles.store','method'=>'POST','class'=>'kt-form kt-form--label-right')) !!}
						<div class="kt-portlet__head form-header">
							<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title">
									Create New Role and assign permission to this role
								</h3>
							</div>
						</div>

						<!--begin::Form-->


						<div class="kt-portlet__body">

							<div class="form-group row">
								<label for="example-text-input" class="col-3 col-form-label">Name</label>
								<div class="col-9">
									{!! Form::text('name', $value=old('name'), array('placeholder' => 'Role Name','class' => 'form-control','required'=>true)) !!}

									@if ($errors->has('name'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('name') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row">
								@if ($errors->has('permission'))
									<span class="help-block">
											<strong class="text-danger">{{ $errors->first('permission') }}</strong>
										</span>
									<br>
								@endif

							@foreach($permissions->chunk(8) as $permissionValue)

								<div class="col-3">
									<h5 class="">Permission Name</h5>
									@foreach($permissionValue as $value)

										<label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}

											{{ $value->name }}</label>

										<br />
									@endforeach


								</div>
								@endforeach
							</div>





						</div>
						<div class="kt-portlet__foot form-footer">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-2">
									</div>
									<div class="col-10">
										<button type="submit" class="btn btn-success">Submit</button>

										@can('role-list')
										<a href="{{ route('roles.index') }}" class="btn btn-secondary pull-right">Cancel</a>
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

@endsection




