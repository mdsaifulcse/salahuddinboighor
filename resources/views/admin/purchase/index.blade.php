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
    @can('product-purchase-create')
        <a href="{{ route('product-purchases.create') }}" class="btn btn-success pull-right" title="Click to Create New Product Purchase">
            <i class="la la-plus"></i> Create New Product Purchase
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
                    <th>Purchase No</th>
                    <th>Supplier Name</th>
                    <th>Sub Total</th>
                    <th>Discount</th>
                    <th>Net Total</th>
                    <th>Due Date</th>
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

                ajax: '{{ URL::to("admin/product-purchases-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'purchase_no',name:'product_purchases.purchase_no'},
                    { data: 'name',name:'vendors.name'},
                    { data: 'sub_total',name:'product_purchases.sub_total'},
                    { data: 'discount',name:'product_purchases.discount'},
                    { data: 'net_total',name:'product_purchases.net_total'},
                    { data: 'Due Date'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection