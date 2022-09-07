@extends('backend.app')


@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{url('all-users')}}">Menu Setting</a></li>

    </ol>
@endsection
@section('content')

    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-info">
                        Menu Setting
                        <div class="card-btn pull-right">

                        </div>
                    </div>
                    <div class="card-block">
                        <div class="j-wrapper j-wrapper-640">

                            {!! Form::open(array('route' =>['menu-setting.update',$data->id],'method'=>'PUT','class'=>'form-horizontals,j-pro','id'=>'j-pro','files'=>true)) !!}

                            <div class="j-content">

                                <!-- end name -->
                                <!-- start email phone -->
                                <div class="j-row">

                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3"> With Slider:*:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="checkbox"  id="with" name="status" value="1" @if($data->status==1) checked @endif>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3">With Slider Menu Background*:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="slider_bg_color" value="{{$data->slider_bg_color}}" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3">With Slider Menu text color*:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="slider_text_color" value="{{$data->slider_text_color}}" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3">Without Slider Menu Background*:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="bg_color" value="{{$data->bg_color}}" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3">Without Slider Menu text color*:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <input type="text" class="form-control" name="text_color" value="{{$data->text_color}}" >
                                        </div>
                                    </div>



                                </div>
                            </div>
                        {{Form::hidden('id',$data->id)}}
                        <!-- end /.content -->
                            <div class="j-footer" style="margin-top: 20px;">

                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                            <!-- end /.footer -->
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

