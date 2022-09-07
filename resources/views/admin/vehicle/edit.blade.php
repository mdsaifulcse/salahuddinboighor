@extends('layouts.vmsapp')

@section('title')
Edit Vehicle Information
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Edit Vehicle Information
@endsection

@section('subheader-action')
    @can('user-index')
        <a href="{{ route('vehicle.index') }}" class="btn btn-success pull-right">
            Vehicles list
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
					<div class="kt-portlet__head bg-success">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title text-white">
								Fill the form and create new vehicle
							</h3>
						</div>
					</div>

										<!--begin::Form-->
									{!! Form::open(array('route' => ['vehicle.update',$vehicle->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right')) !!}
                                        
									<div class="kt-portlet__body">

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Name</label>
											<div class="col-9">
											{!! Form::text('name', $value=$vehicle->name, array('placeholder' => 'Name','class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

											@if ($errors->has('name'))
											<span class="help-block">
													<strong class="text-danger">{{ $errors->first('name') }}</strong>
											</span>
											@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Engine Type</label>
											<div class="col-9">
											{!! Form::text('engine_type', $value=$vehicle->engine_type, array('placeholder' => '','class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

											@if ($errors->has('engine_type'))
											<span class="help-block">
													<strong class="text-danger">{{ $errors->first('engine_type') }}</strong>
											</span>
											@endif
											</div>
										</div>



										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Model</label>
											<div class="col-9">
												{!! Form::text('model', $value=$vehicle->model, array('placeholder' => 'Vehicle model','class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

												@if ($errors->has('model'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('model') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Horse Power</label>
											<div class="col-9">
												{!! Form::text('horse_power', $value=$vehicle->horse_power, array('placeholder' => 'Horse Power','class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

												@if ($errors->has('horse_power'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('horse_power') }}</strong>
											</span>
												@endif
											</div>
										</div>


										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">Type</label>
											<div class="col-9">

												{!! Form::select('type', ['1'=>'Motor','2'=>'Zip','3'=>'Car'],$vehicle->type, array('placeholder' => 'Select type','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('type'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('type') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Vehicle Color</label>
											<div class="col-9">
												{!! Form::text('color', $value=$vehicle->color, array('placeholder' => 'Color','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('color'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('color') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Vehicle Year</label>
											<div class="col-9">
												{!! Form::text('year', $value=$vehicle->year, array('placeholder' => 'Year','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('year'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('year') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  VIN</label>
											<div class="col-9">
												{!! Form::text('vin', $value=$vehicle->vin, array('placeholder' => '','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('vin'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('vin') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">  Average Miles</label>
											<div class="col-9">
												{!! Form::text('average_miles', $value=$vehicle->average_miles, array('placeholder' => 'Ex: 90km','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('average_miles'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('average_miles') }}</strong>
											</span>
												@endif
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">Group</label>
											<div class="col-9">

												{!! Form::select('group', ['1'=>'Xyz1','2'=>'Xyz2','3'=>'Xyz3'],$vehicle->group, array('placeholder' => 'Select group','class' => 'form-control','required'=>false,'autocomplete'=>'off')) !!}

												@if ($errors->has('group'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('group') }}</strong>
											</span>
												@endif
											</div>
										</div>


										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label"> Serial </label>
											<div class="col-9">
												{!! Form::number('serial_num', $value=$vehicle->serial_num, array('placeholder' => 'Serial number','class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

												@if ($errors->has('serial_num'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('serial_num') }}</strong>
											</span>
												@endif
											</div>
										</div>


										<div class="form-group row">
											<label for="example-text-input" class="col-3 col-form-label">Vehicle Status</label>
											<div class="col-9">

												{!! Form::select('status', ['1'=>'Active','2'=>'Inactive'],$vehicle->status, array('class' => 'form-control','required'=>true,'autocomplete'=>'off')) !!}

												@if ($errors->has('status'))
													<span class="help-block">
													<strong class="text-danger">{{ $errors->first('status') }}</strong>
											</span>
												@endif
											</div>
										</div>




									</div><!-- end body -->
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<div class="row">
														<div class="col-2">
														</div>
														<div class="col-10">
															<button type="submit" class="btn btn-warning">Submit</button>
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

<!-- Good -->





