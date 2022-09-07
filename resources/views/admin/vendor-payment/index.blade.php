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
        <a href="{{ route('vendor-payments.create') }}" class="btn btn-success pull-right" title="Create New {{$title}}">
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

                    <table class="table table-striped table-hover table-bordered center_table" id="vendorPaymentData">
                        <thead>
                        <tr class=" text-white">
                            <th>SL</th>
                            <th>Name</th>
                            <th>Total Due</th>
                            <th>Total Payment</th>
                            <th>Status</th>
                            <th>Due Remaining</th>
                            <th>Payment Date</th>
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
            $('#vendorPaymentData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: '{{ URL::to("admin/vendor-payments-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'name',name:'vendors.name'},
                    { data: 'payable',name:'vendor_payments.payable'},
                    { data: 'payment',name:'vendor_payments.payment'},
                    { data: 'status',name:'vendor_payments.status'},
                    { data: 'due',name:'vendor_payments.due'},
                    { data: 'Payment Date'},
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
