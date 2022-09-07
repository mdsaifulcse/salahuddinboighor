@extends('layouts.vmsapp')

@section('title')
   Client List
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Client List
@endsection

@section('subheader-action')
    @can('customers-create')
        <a href="{{ route('customers.create') }}" class="btn btn-success pull-right">
            Create New Client
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table id="customerUserData" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                
                <tr class="">

                   <th>Sl.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Company</th>
                    <th>Address</th>
                    <th>Register At</th>
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
            $('#customerUserData').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],
                ajax: '{{ URL::to("admin/customers-data") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'name',name:'users.name'},
                    { data: 'email',name:'users.email'},
                    { data: 'mobile',name:'users.mobile'},
                    { data: 'Company',name:'profile.company_name'},
                    { data: 'Address',name:'profile.address'},
                    { data: 'Register_At'},
                    { data: 'Action'},
                ]
            });

        });
    </script>


<script>
function showUserFunction(id){
    console.log(id);

    $('#userViewModal').modal('show')
}
</script>

@endsection