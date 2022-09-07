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
    {{--@can('purchase-return-create')--}}
        <a href="{{ route('purchase-return.create') }}" class="btn btn-success pull-right" title="Click to Create New Product Purchase">
            <i class="la la-plus"></i> Create New {{$title}}
        </a>
    {{--@endcan--}}
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
                    <th>Purchase return no</th>
                    <th>Purchase no</th>
                    <th>Supplier Name</th>
                    <th>Total price</th>
                    <th>Return price</th>
                    <th>Return Date</th>
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
            $('#productData').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/purchase-return-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'name',name:'vendors.name'},
                    { data: 'purchase_return_no',name:'purchase_returns.purchase_return_no'},
                    { data: 'purchase_no',name:'product_purchases.purchase_no'},
                    { data: 'total_amount',name:'purchase_returns.total_amount'},
                    { data: 'return_amount',name:'purchase_returns.return_amount'},
                    { data: 'Return Date'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection