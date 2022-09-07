@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    {{--@can('bank-accounts')--}}
        {{--<a href="{{ route('bank-accounts.index') }}" class="btn btn-success pull-right">--}}
            {{--{{$title}} List--}}
        {{--</a>--}}
    {{--@endcan--}}
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
                        {!! Form::open(array('route' => 'bank-accounts.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new {{$title}}
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('bank_name') ? 'has-error' : '' }}">

                                 {{Form::label('bank_name', 'Bank Name *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('bank_name',$value=old('bank_name'),array('class'=>'form-control','placeholder'=>'Bank name here','required','autofocus'))}}
                                     @if ($errors->has('bank_name'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                    			</span>
                                     @endif
                                 </div>

                             </div>


                             <div class="form-group row {{ $errors->has('bank_branch') ? 'has-error' : '' }}">

                                 {{Form::label('bank_branch', 'Branch Name *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('bank_branch',$value=old('bank_branch'),array('class'=>'form-control','placeholder'=>'Branch name here','required','autofocus'))}}
                                     @if ($errors->has('bank_branch'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('bank_branch') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>


                             <div class="form-group row {{ $errors->has('account_title') ? 'has-error' : '' }}">

                                 {{Form::label('account_title', 'Account Title *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::text('account_title',$value=old('account_title'),array('class'=>'form-control','placeholder'=>'Account title here','required','autofocus'))}}
                                     @if ($errors->has('account_title'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('account_title') }}</strong>
                    			</span>
                                     @endif
                                 </div>
                             </div>

                             <div class="form-group row {{ $errors->has('account_number') ? 'has-error' : '' }}">

                                 {{Form::label('account_number', 'Account number *', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::number('account_number',$value=old('account_number'),array('min'=>0,'class'=>'form-control','placeholder'=>'Account number here','required','autofocus'))}}
                                     @if ($errors->has('account_number'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('account_number') }}</strong>
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

                                 <div class="col-md-2">
                                     {{Form::select('status', $status,[], ['class' => 'form-control'])}}
                                 </div>
                             </div>


                             <div class="form-group row">
                                 {{Form::label('address', 'Address', array('class' => 'col-md-3 control-label'))}}
                                 <div class="col-md-6">
                                     {{Form::textArea('address',$value=old('address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Address '])}}
                                 </div>

                                 <?php $max=$max_serial+1; ?>
                                 <div class="col-md-2">
                                     {{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
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
                                        @can('menu-list')
                                        <a href="{{route('categories.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
                                            @endcan
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>SL</th>
                            <th>Bank Name</th>
                            <th>Branch Name</th>
                            <th>Account Title</th>
                            <th>Account No.</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @forelse($allData as $data)
                            <tr>
                                <td>{{$data->serial_num}}</td>
                                <td>{{$data->bank_name}}</td>
                                <td>{{$data->bank_branch}}</td>
                                <td>{{$data->account_title}}</td>
                                <td>{{$data->account_number}}</td>

                                <td>
                                    @if($data->status==\App\Models\BankAccount::ACTIVE)
                                        <i class="fa fa-check-circle text-success"></i> {{$data->status}}
                                        @elseif($data->status==\App\Models\BankAccount::INACTIVE)
                                        <i class="fa fa-times-circle text-danger"></i> {{$data->status}}
                                        @endif
                                </td>

                                <td>{{date('M-d-Y h:i A',strtotime($data->created_at))}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['bank-accounts.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#bankAccountModal{{$data->id}}" data-toggle="modal" data-target="#bankAccountModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>


                                <!-- begin::modal -->

                                <div class="modal fade show" id="bankAccountModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">

                                            {!! Form::open(array('route' => ['bank-accounts.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit  {{$title}} Info </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="form-group row {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                                                {{Form::label('bank_name', 'Bank Name *', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::text('bank_name',$value=old('bank_name',$data->bank_name),array('class'=>'form-control','placeholder'=>'Bank name here','required','autofocus'))}}
                                                    @if ($errors->has('bank_name'))
                                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                    			</span>
                                                    @endif
                                                </div>
                                                </div>



                                            <div class="form-group row {{ $errors->has('bank_branch') ? 'has-error' : '' }}">

                                                {{Form::label('bank_branch', 'Branch Name *', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::text('bank_branch',$value=old('bank_branch',$data->bank_branch),array('class'=>'form-control','placeholder'=>'Branch name here','required','autofocus'))}}
                                                    @if ($errors->has('bank_branch'))
                                                        <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('bank_branch') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group row {{ $errors->has('account_title') ? 'has-error' : '' }}">

                                                {{Form::label('account_title', 'Account Title *', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::text('account_title',$value=old('account_title',$data->account_title),array('class'=>'form-control','placeholder'=>'Account title here','required','autofocus'))}}
                                                    @if ($errors->has('account_title'))
                                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('account_title') }}</strong>
                    			</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row {{ $errors->has('account_number') ? 'has-error' : '' }}">

                                                {{Form::label('account_number', 'Account number *', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::number('account_number',$value=old('account_number',$data->account_number),array('min'=>0,'class'=>'form-control','placeholder'=>'Account number here','required','autofocus'))}}
                                                    @if ($errors->has('account_number'))
                                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('account_number') }}</strong>
                    			</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row {{ $errors->has('balance') ? 'has-error' : '' }}">

                                                {{Form::label('balance', 'Initial Balance', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::number('balance',$value=old('balance',$data->balance),array('min'=>0,'class'=>'form-control','placeholder'=>'00.0','required'=>false,'autofocus'))}}
                                                    @if ($errors->has('balance'))
                                                        <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('balance') }}</strong>
                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-2">
                                                    {{Form::select('status', $status,$data->status, ['class' => 'form-control'])}}
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                {{Form::label('address', 'Address', array('class' => 'col-md-3 control-label'))}}
                                                <div class="col-md-6">
                                                    {{Form::textArea('address',$value=old('address',$data->address), ['class' => 'form-control','rows'=>'2','placeholder'=>'Address '])}}
                                                </div>

                                                <?php $max=$max_serial+1; ?>
                                                <div class="col-md-2">
                                                    {{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                    <span> Serial</span>
                                                </div>
                                            </div>


                                            </div><!--end body-->

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-brand">Update</button>
                                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                            </div>
                                            {!! Form::close() !!}
                                        </div><!--end content-->

                                    </div>
                                </div>


                                <!-- end::modal -->



                            </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Menu Data ! </td>
                            </tr>
                        @endforelse

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
