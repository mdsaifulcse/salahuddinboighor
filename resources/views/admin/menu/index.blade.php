
@extends('layouts.vmsapp')

@section('title')
    Menu
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Menu
@endsection

@section('subheader-action')
    @can('menu')
        <a href="{{ route('menu.create') }}" class="btn btn-success pull-right">
           <i class="la la-plus"></i> Create menu
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <table class="table table-striped table-hover table-bordered center_table">
                        <thead>
                        <tr class="bg-dark text-white">
                            <th>SL</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Menu For</th>
                            <th>Sub Menu</th>
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
                                <td><a href="{{route('menu.edit',$data->id)}}"><i class="{{$data->icon_class}}"></i> {{$data->name}}</a></td>
                                <td><a href="{{URL::to($data->url)}}" target="_blank">{{URL::to($data->url)}}</a></td>

                                <td>
                                    @if($data->menu_for==\App\Models\Menu::ADMIN_MENU)
                                    <span class="btn btn-sm btn-warning">{{$data->menu_for}}</span>
                                        @else
                                        <span class="btn btn-sm btn-default">{{$data->menu_for}}</span>
                                    @endif
                                </td>

                                <td><a href="{{URL::to('admin/sub-menu',$data->id)}}" class="btn btn-primary btn-sm" style="color: #fff;">Sub Menu ({{$data->subMenu->count('id')}})</a></td>

                                <td><i class="{{($data->status==\App\Models\Menu::ACTIVE)? 'fa fa-check-circle text-success' : 'fa fa-times-circle'}}"></i></td>

                                <td>{{$data->created_at}}</td>
                                <td>
                                    {!! Form::open(array('route' => ['menu.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                    <a href="{{route('menu.edit',$data->id)}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>

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







