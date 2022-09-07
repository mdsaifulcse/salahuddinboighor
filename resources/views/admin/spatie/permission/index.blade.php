

@extends('layouts.vmsapp')

@section('title')
    Permission Management
@endsection

<!-- begin:: Content Head -->
@section('subheader')
    Permission Management
@endsection

@section('subheader-action')
    @can('role-create')
        <a href="{{ route('roles.index') }}" class="btn btn-success pull-right">
            Role
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="table-responsive ">

                    <h4 class="text-danger text-center"> This section is only for Developer. </h4>
                        {!! Form::open(array('route' => 'permission.store','class'=>'form-horizontal','method'=>'POST','role'=>'form')) !!}
                        <div class="form-group row">
                            <label class="control-label col-md-2">Permission Name :</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="name" value="" placeholder="Permission Name">
                            </div>
                            <!-- <div class="col-md-2">
                                {{Form::select('type',['1'=>'Resource','2'=>'Normal'],2,['class'=>'form-control','required'])}}
                            </div> -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>

                        {!! Form::close(); !!}

                            <table id="data-table" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="20%">Permission Name</th>
                                    <th width="20%">Guard name</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>

                        </div>
                </div>
            </div>
            <!--End::Row-->
        </div>

        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->

@endsection

@section('script')

<script>
    $(function() {
        $('#data-table').DataTable( {
            processing: true,
            serverSide: true,

            ajax: '{{ URL::to("admin/permission/create") }}',
            columns: [
                { data: 'DT_RowIndex',orderable:true},
                { data: 'name',name:'permissions.name'},
                { data: 'guard_name',name:'permissions.guard_name'},
                { data: 'action'},
            ]
        });

    });
</script>

@endsection

<!-- good -->

