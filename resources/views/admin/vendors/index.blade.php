@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    @can('vendor-list')
        <a href="{{ route('vendors.create') }}" class="btn btn-success pull-right" title="Create New {{$title}}">
           <i class="fa fa-plus"></i> New {{$title}}
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

                    <table class="table table-striped table-hover table-bordered center_table" id="vendorData">
                        <thead>
                        <tr class=" text-white">
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Office Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
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

    <script>
        $(function() {
            $('#vendorData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/vendors-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'name',name:'vendors.name'},
                    { data: 'email',name:'vendors.email'},
                    { data: 'mobile',name:'vendors.mobile'},
                    { data: 'office_address',name:'vendors.office_address'},
                    { data: 'status',name:'vendors.status'},
                    { data: 'action'},
                ]
            });
        });
    </script>


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
