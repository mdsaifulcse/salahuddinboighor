@extends('layouts.vmsapp')

@section('title')
    Role Management
@endsection

<!-- begin:: Content Head -->
@section('subheader')
    Role Management
@endsection

@section('subheader-action')
    @can('role-create')
        <a href="{{ route('roles.create') }}" class="btn btn-success pull-right">
            Create New Role
        </a>
    @endcan
@endsection
<!-- end:: Content Head -->

<!-- begin:: Content -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->

            <table class="table table-bordered table-striped table-hover">

                <thead>
                    <tr>

                        <th width="5%">No</th>

                        <th width="15%">Name</th>

                        <th width="20%">Action</th>

                    </tr>
                
                </thead>

                @foreach ($roles as $key => $role)

                    <tbody>
                    
                    <tr>

                        <td>{{ ++$i }}</td>

                        <td>{{ $role->name }}</td>

                        </td>

                        <td>

                        <!--begin::Modal-->
                        <div class="modal fade" id="roleViewModal{{$role->id}}" role="dialog" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-primary">
                                        <h5 class="modal-title" id="">Role Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="la la-remove"></span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th>
                                                    Role
                                                </th>
                                                <th>
                                                    Permissions
                                                </th>
                                            </tr>

                                            <tbody>
                                            <tr>
                                                <td>
                                                {{$role->name}}
                                                </td>

                                                <td>
                                                
                                                <?php 
                                                $rolePermissions = Spatie\Permission\Models\Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")

                                                ->where("role_has_permissions.role_id", $role->id)
                                    
                                                ->get();
                                                ?>
                                                @if(!empty($rolePermissions))

                                                    @foreach($rolePermissions as $v)

                                                    <label class="label label-success">{{ $v->name }},</label>

                                                    @endforeach

                                                    @endif
                                                </td>
                                                
                                            </tr>
                                            </tbody>

                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-brand pull-left" data-dismiss="modal">Close</button>
                                            <!-- <button type="button" class="btn btn-secondary">Submit</button> -->
                                        </div>
                                </div>
                            </div>
                        </div>

                        <!--end::Modal-->

                            
                            <!-- <a class="btn btn-default" disabled="disabled"  href="#">Delete</a> -->

                            {!! Form::open(array('route' => ['roles.destroy',$role->id],'method'=>'DELETE','id'=>"deleteForm$role->id")) !!}

                            <a class="btn btn-info btn-sm" href="roleViewModal{{$role->id}}" data-toggle="modal" data-target="#roleViewModal{{$role->id}}">Show</a>

                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                            @if($role->name!='developer')
                            <button style="display:inline-block" type="button" class="btn btn-xs btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$role->id}}")'><i class="fa fa-trash"></i></button>
                            @endif

                            {!! Form::close() !!}



                            

                        </td>

                    </tr>
                    </tbody>

                @endforeach

            </table>


            {!! $roles->render() !!}

        </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
    </div>

        <!-- end:: Content -->


@endsection

@section('script')

<script>

function showUserFunction(id){
    console.log(id);

    $('#userViewModal').modal('show')

}

</script>

@endsection

<!-- good -->

