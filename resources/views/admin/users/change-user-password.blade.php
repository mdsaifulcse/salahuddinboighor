@extends('layouts.vmsapp')

@section('title')
Reset your password
@endsection

@section('subheader')
    Password Reset
@endsection
@section('subheader-content')

@endsection

@section('subheader-action')
    @can('user-list')
        <a href="{{ url('admin/profile') }}" class="btn btn-success pull-left">
            Profile
        </a>
    @endcan
@endsection

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->



    <!-- end:: Content Head -->

        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <div class="row justify-content-md-center justify-content-lg-center">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">

            <div class="kt-portlet">
										<div class="kt-portlet__head form-header">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title">
                                                    Reset password for <u>{{$user->name}}</u> <i class="la la-key"></i>
												</h3>
											</div>
										</div>

										<!--begin::Form-->

                                        {!! Form::model($user, ['method' => 'POST','route' => ['user-password.change',$user->id],'class'=>'kt-form kt-form--label-right']) !!}

                                            <input type="hidden" name="_method" value="PUT">
											<div class="kt-portlet__body">

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-4 col-form-label">New Password <sup class="text-danger">*</sup></label>
                                                    <div class="col-8">
                                                        {!! Form::password('new_password', ['placeholder' => '','class' => 'form-control','required'=>true]) !!}

                                                        @if ($errors->has('new_password'))
                                                            <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-4 col-form-label">Confirm Password <sup class="text-danger">*</sup></label>
                                                    <div class="col-8">
                                                        {!! Form::password('new_confirm_password', ['placeholder' => '','class' => 'form-control','required'=>true]) !!}

                                                        @if ($errors->has('new_confirm_password'))
                                                            <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('new_confirm_password') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>


									
											</div>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<div class="row">
														<div class="col-4">
														</div>
														<div class="col-8">
															<button type="submit" class="btn btn-warning form-footer">Change Password</button>
                                                            <a href="{{ url()->previous() }}" class="btn btn-secondary pull-right">Cancel</a>
                                                            <input type="hidden" name="id" value="{{$user->id}}">
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





