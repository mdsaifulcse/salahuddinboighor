@extends('layouts.vmsapp')

@section('title')
    Create New User
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Create New User
@endsection

@section('subheader-content')
    Sub Header Content
@endsection

@section('subheader-action')
    @can('user-list')
        <a href="{{ route('users.index') }}" class="btn btn-success pull-right">
            Go user list
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
                        {!! Form::open(array('route' => 'users.store','method'=>'POST','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new user by fill up required data
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">


                        </div> <!-- end kt-portlet__body -->

                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-secondary pull-right">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div> <!-- end kt-portlet -->
                </div>
            </div>
        </div>

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





