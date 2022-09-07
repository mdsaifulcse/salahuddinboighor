@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    @can('user-create')
        <a href="{{ route('product-adjustment.create') }}" class="btn btn-success pull-right" title="Click to Create New Product Purchase">
            <i class="la la-plus"></i> Create Product Adjustment
        </a>
    @endcan
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table id="productData" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                <tr class=" text-white">
                    <th>No.</th>
                    <th>RefNo</th>
                    <th>Sub Total</th>
                    <th>Net Total</th>
                    <th>Adjustment Type</th>
                    <th>Adjustment Date</th>
                    <th>Action</th>
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
            $('#productData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/product-adjustment-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'ref_no',name:'adjust_ments.ref_no'},
                    { data: 'sub_total',name:'product_purchases.sub_total'},
                    { data: 'net_total',name:'product_purchases.net_total'},
                    { data: 'Adjustment Type'},
                    { data: 'Adjustment Date'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection