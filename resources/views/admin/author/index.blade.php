

@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection

<!-- begin:: Content Head -->
@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    
        <a href="{{ route('authors.create') }}" class="btn btn-success pull-right" title="Click Here Create New Author">
           + Author
        </a>
    
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--Begin::Row-->

                    <div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>

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
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/get-authors") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'Photo'},
                    { data: 'name',name:'authors.name'},
                    { data: 'email',name:'authors.email'},
                    { data: 'mobile',name:'authors.mobile'},
                    { data: 'status',name:'authors.status'},
                    { data: 'action'},
                ]
            });
        });
    </script>
@endsection

<!-- good -->

