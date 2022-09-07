

@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection

<!-- begin:: Content Head -->
@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    {{--@can('role-create')--}}
        {{--<a href="{{ route('roles.index') }}" class="btn btn-success pull-right">--}}
            {{--Role--}}
        {{--</a>--}}
    {{--@endcan--}}
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

                        {!! Form::open(array('route' => 'languages.store','class'=>'form-horizontal','method'=>'POST','role'=>'form')) !!}
                        <div class="well">
                            <div class="form-group row">

                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Type Language Name Here">
                                    <small>Language Name</small>
                                </div>
                                <div class="col-md-2">
                                    {{Form::select('status', $status, '', ['class' => 'form-control'])}}
                                    <small> Status </small>
                                </div>
                                <div class="col-md-1">
                                    <?php $max=$max_serial+1; ?>
                                    {{Form::number('serial_num',"$max",['class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0','required'=>true])}}
                                    <small> Serial </small>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {!! Form::close(); !!}

                            <table id="data-table" class="table table-striped table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th width="10%">Sl</th>
                                    <th width="20%">Language</th>
                                    <th width="20%">Status</th>
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

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" id="editForm">

        </div>
    </div>

@endsection

@section('script')

<script>
    function showEditModal(id) {

        $('#myModal').modal('show')
        $('#editForm').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("/admin/languages")}}/'+id);

    }
</script>

<script>
    $(function() {
        $('#data-table').DataTable( {
            processing: true,
            serverSide: true,

            ajax: '{{ URL::to("admin/languages/create") }}',
            columns: [
                { data: 'DT_RowIndex',orderable:true},
                { data: 'name',name:'languages.name'},
                { data: 'status',name:'languages.status'},
                { data: 'action'},
            ]
        });

    });
</script>

@endsection

<!-- good -->

