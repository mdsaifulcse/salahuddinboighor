@extends('layouts.vmsapp')

@section('title')
    All Product List
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
   All Book List
@endsection

@section('subheader-action')
    @can('product-create')
        <a href="{{ route('products.create') }}" class="btn btn-success pull-right" title="Click to create new product">
            <i class="la la-plus"></i> Create New Book
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
                    <th>Image</th>
                    <th>Sku</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Sale Price</th>
                    <th>Stock Qty</th>
                    <th>Feature</th>
                    <th>Status</th>
                    <th>Show Home</th>
                    <th width="15%">Action</th>
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

                ajax: '{{ URL::to("admin/get-products") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'Image'},
                    { data: 'sku',name:'products.sku'},
                    { data: 'name',name:'products.name'},
                    { data: 'category_name',name:'categories.category_name'},
                    { data: 'sale_price',name:'product_inventory_stocks.sale_price'},
                    { data: 'qty',name:'product_inventory_stocks.qty'},
                    { data: 'is_feature',name:'products.is_feature'},
                    { data: 'status',name:'products.status'},
                    { data: 'show_home',name:'products.show_home'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection