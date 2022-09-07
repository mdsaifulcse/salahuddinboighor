@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    {{--@can('vendor-list')--}}
        <a href="{{ route('vendors.index') }}" class="btn btn-success pull-right">
            {{$title}} List
        </a>
    {{--@endcan--}}
@endsection
<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                    <div class="kt-portlet">
                        {!! Form::open(array('route' => 'vendors.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new {{$title}}
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">

                                 {{Form::label('name', 'Supplier Name *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('name',$value=old('name'),array('class'=>'form-control','placeholder'=>'Supplier name here','required','autofocus'))}}
                                     @if ($errors->has('name'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('name') }}</strong>
                    			</span>
                                     @endif
                                 </div>

                             </div>


                             <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">

                                 {{Form::label('email', 'Supplier Email *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::email('email',$value=old('email'),array('class'=>'form-control','placeholder'=>'Supplier email here','required','autofocus'))}}
                                     @if ($errors->has('email'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('email') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('mobile') ? 'has-error' : '' }}">

                                 {{Form::label('mobile', 'Supplier Mobile *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('mobile',$value=old('mobile'),array('class'=>'form-control','placeholder'=>'Supplier Mobile here','required','autofocus'))}}
                                     @if ($errors->has('mobile'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('mobile') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('balance') ? 'has-error' : '' }}">

                                 {{Form::label('balance', 'Initial Balance', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('balance',$value=old('balance'),array('min'=>0,'class'=>'form-control','placeholder'=>'00.0','required'=>false,'autofocus'))}}
                                     @if ($errors->has('balance'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('balance') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                             </div>

                             <div class="form-group row {{ $errors->has('contact_person') ? 'has-error' : '' }}">

                                 {{Form::label('contact_person', 'Supplier Contact Person ', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('contact_person',$value=old('contact_person'),array('class'=>'form-control','placeholder'=>'','required'=>false,'autofocus'))}}
                                     @if ($errors->has('contact_person'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('contact_person') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('contact_person_mobile') ? 'has-error' : '' }}">

                                 {{Form::label('contact_person_mobile', 'Supplier Contact Person Mobile', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('contact_person_mobile',$value=old('contact_person_mobile'),array('class'=>'form-control','placeholder'=>'','required'=>false,'autofocus'))}}
                                     @if ($errors->has('contact_person_mobile'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('contact_person_mobile') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row">
                                 {{Form::label('office_address', 'Office Address', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::textArea('office_address',$value=old('office_address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Office Address '])}}
                                     @if ($errors->has('office_address'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('office_address') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                                 <div class="col-md-2">
                                     {{Form::select('status', $status,[], ['class' => 'form-control'])}}
                                 </div>
                             </div>

                             <div class="form-group row">
                                 {{Form::label('warehouse_address', 'Warehouse Address', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::textArea('warehouse_address',$value=old('warehouse_address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Office Address '])}}

                                     @if ($errors->has('warehouse_address'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('warehouse_address') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                                 <?php $max=$max_serial+1; ?>
                                 <div class="col-md-2">
                                     {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required','readonly'=>true])}}
                                     <span> Serial</span>
                                 </div>
                             </div>



                        </div> <!-- end kt-portlet__body -->


                        <div class="kt-portlet__foot form-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        @can('vendors-list')
                                        <a href="{{route('vendors.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
                                            @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
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
