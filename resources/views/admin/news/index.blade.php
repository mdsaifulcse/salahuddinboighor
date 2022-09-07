@extends('layouts.vmsapp')

@section('title')
    classified List
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    classified List
@endsection

@section('subheader-action')
    @can('news-create')
        <a href="{{ route('news.create') }}" class="btn btn-success pull-right">
            <i class="la la-plus"></i> Create New classified
        </a>


    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table id="newsData" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                
                <tr class=" text-white">

                    <th>No</th>
                    <th>Title</th>
                    <th>Topic</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>classified On</th>
                    <th>Status</th>
                    <th>More photo</th>
                    <th >Action</th>

                </tr>

                </thead>

            </table>
        </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
    </div>

        <!-- end:: Content -->
@endsection


@section('script')

<script>
    $(function() {
        $('#newsData').DataTable( {
            processing: true,
            serverSide: true,

            ajax: '{{ URL::to("admin/get-news") }}',
            columns: [
                { data: 'DT_RowIndex',orderable:true},
                { data: 'title',name:'news.title'},
                { data: 'topic',name:'news.topic'},
                { data: 'category_name',name:'categories.category_name'},
                { data: 'name',name:'users.name'},
                { data: 'news on',name:'news.published_status'},
                { data: 'published_status',name:'news.published_status'},
                { data: 'More News'},
                { data: 'action'},
            ]
        });

    });
</script>

@endsection