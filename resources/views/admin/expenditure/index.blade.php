@extends('layouts.vmsapp')

@section('title')
    {{$title}}
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}} List
@endsection

@section('subheader-action')
    {{--@can('vendor-payment-list')--}}
        <a href="{{ route('expenditures.create') }}" class="btn btn-success pull-right" title="Create New {{$title}}">
           <i class="fa fa-plus"></i> New {{$title}}
        </a>
    {{--@endcan--}}
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--Begin::Row-->
            <div class="row justify-content-md-center justify-content-lg-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

                    <table class="table table-striped table-hover table-bordered center_table" id="expensesData">
                        <thead>
                        <tr class=" text-white">
                            <th>SL</th>
                            <th>Expense Heas</th>
                            <th>Sub Head</th>
                            <th>Expense Account</th>
                            <th>Note</th>
                            <th>Amount</th>
                            <th>Expense Date</th>
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
            $('#expensesData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/expenditures-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'head_title',name:'income_expense_heads.head_title'},
                    { data: 'sub_head_title',name:'income_expense_sub_heads.sub_head_title'},
                    { data: 'expense_method',name:'expenditures.expense_method'},
                    { data: 'note',name:'expenditures.note'},
                    { data: 'amount',name:'expenditures.amount'},
                    { data: 'Expense Date'},
                    { data: 'action'},
                ]
            });
        });
    </script>

@endsection

<!-- Good -->
