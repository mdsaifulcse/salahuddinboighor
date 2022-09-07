@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    @can('categories')
        <a href="{{ route('income-expense-heads.index') }}" class="btn btn-success pull-right">
            <i class="la la-angle-double-left"></i> Income Expense Head List
        </a>
    @endcan
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
                        {!! Form::open(array('route' => 'income-expense-sub-heads.store','class'=>'kt-form kt-form--label-right','files'=>true)) !!}

                        <div class="kt-portlet__head form-header">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Create new {{$title}} for ( {{$incomeExpenseHead->head_title}} )
                                </h3>
                            </div>
                        </div>

                         <div class="kt-portlet__body">

                             <div class="form-group row {{ $errors->has('sub_head_title') ? 'has-error' : '' }}">
                                 {{Form::label('sub_head_title', 'Sub-head', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-8">
                                     {{Form::text('sub_head_title',$value=old('sub_head_title'),array('class'=>'form-control','placeholder'=>'Sub-head title','required','autofocus'))}}

                                     <input type="hidden" name="income_expense_head_id" value="{{$incomeExpenseHead->id}}">

                                     @if ($errors->has('sub_head_title'))
                                         <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('sub_head_title') }}</strong>
                                        </span>
                                     @endif
                                 </div>

                                 <div class="col-md-2">
                                     {{Form::select('status', $status,[], ['class' => 'form-control'])}}
                                 </div>

                             </div>


                             <div class="form-group row">
                                 {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                 <div class="col-md-8">
                                     {{Form::textArea('short_description',$value=old('short_description'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description'])}}
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
                                        @can('income-expense-heads')
                                        <a href="{{route('income-expense-heads.index')}}" class="btn btn-secondary pull-right "> Cancel </a>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>SL</th>
                            <th>Head Title</th>
                            <th>Sub Head</th>
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
                                <td><a href="{{route('income-expense-heads.index')}}"> {{$incomeExpenseHead->head_title}}</a></td>

                                <td> {{$data->sub_head_title}}</td>

                                <td><i class="{{($data->status==\App\Models\IncomeExpenseSubHead::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{date('M-d-Y h:i A',strtotime($data->created_at))}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['income-expense-sub-heads.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="#subHeadModal{{$data->id}}" data-toggle="modal" data-target="#subHeadModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>

                                <!-- begin::modal -->

                                <div class="modal fade show" id="subHeadModal{{$data->id}}" role="dialog" aria-labelledby="" style="display: none;" aria-modal="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            {!! Form::open(array('route' => ['income-expense-sub-heads.update', $data->id],'method'=>'PUT','class'=>'kt-form kt-form--label-right','files'=>true)) !!}
                                            <div class="modal-header modal-header-primary">
                                                <h5 class="modal-title" id="">Edit {{$title}} Info</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="la la-remove"></span>
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="form-group row {{ $errors->has('sub_head_title') ? 'has-error' : '' }}">
                                                    {{Form::label('sub_head_title', 'Sub-head', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::text('sub_head_title',$value=$data->sub_head_title,array('class'=>'form-control','placeholder'=>'Sub-head','required','autofocus'))}}

                                                        <input type="hidden" name="category_id" value="{{$incomeExpenseHead->id}}">

                                                        @if ($errors->has('sub_head_title'))
                                                            <span class="help-block">
                        				<strong class="text-danger">{{ $errors->first('sub_head_title') }}</strong>
                    			</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2">
                                                        {{Form::select('status', $status,$data->status, ['class' => 'form-control'])}}
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    {{Form::label('short_description', 'Short Description', array('class' => 'col-md-2 control-label'))}}
                                                    <div class="col-md-8">
                                                        {{Form::textArea('short_description',$value=$data->short_description, ['class' => 'form-control','rows'=>'2','placeholder'=>'Short Description'])}}
                                                    </div>

                                                    <?php $max=$max_serial+1; ?>
                                                    <div class="col-md-2">
                                                        {{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                                        <span>Serial</span>
                                                    </div>
                                                </div>

                                        </div><!-- end body -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-brand">Update</button>
                                            <button type="button" class="btn btn-secondary  pull-right" data-dismiss="modal">Close</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div><!-- end content -->

                                </div>

                                <!-- end::modal -->

                            </tr>
                        @empty

                            <tr>
                                <td colspan="8" class="text-center"> No Data Found ! </td>
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

<!-- Good -->
