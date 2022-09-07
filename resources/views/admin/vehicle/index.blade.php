@extends('layouts.vmsapp')

@section('title')
    Vehicle list
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Vehicle Information
@endsection

@section('subheader-action')
    @can('user-create')
        <a href="{{ route('vehicle.create') }}" class="btn btn-success pull-right">
            Create New Vehicle
        </a>
    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table id="vehicle-data" class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                
                <tr>

                    <th>Sl</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Horse Power</th>
                    <th>Year</th>
                    <th>Miles</th>
                    <th>Status</th>
                    <th width="280px">Action</th>

                </tr>

                </thead>

                <tbody>

                </tbody>

            </table>

        </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
    </div>

        <!-- end:: Content -->


    <!--begin::Modal-->
    <div class="modal fade" id="vehicleEditModal" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Select2 Examples</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="form-group row kt-margin-b-20">
                            <label class="col-form-label col-lg-3 col-sm-12">Placeholder</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-brand pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary">Submit</button>
                    </div>
            </div>
        </div>
    </div>

    <!--end::Modal-->


@endsection



@section('script')

    <script>
        $(function() {
            $('#vehicle-data').DataTable( {
                processing: true,
                serverSide: true,

                ajax: '{{ URL::to("vehicle-data-table") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'name',name:'vehicles.name'},
                    { data: 'model',name:'vehicles.model'},
                    { data: 'horse_power',name:'vehicles.horse_power'},
                    { data: 'year',name:'vehicles.year'},
                    { data: 'average_miles',name:'vehicles.average_miles'},
                    { data: 'Status'},
                    { data: 'action'},
                ]
            });

        });
    </script>

    <script>

function showUserFunction(id){
    console.log(id);

    $('#vehicleEditModal').modal('show')

}

</script>

@endsection