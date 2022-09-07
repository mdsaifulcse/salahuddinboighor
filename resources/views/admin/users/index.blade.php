@extends('layouts.vmsapp')

@section('title')
   Admin Users Management
@endsection


<!-- begin:: Content Head -->

@section('subheader')
   Admin Users Management
@endsection

@section('subheader-action')
    @can('user-create')
        <a href="{{ route('users.create').'?actor=admin' }}" class="btn btn-success pull-right">
            Create New Admin User
        </a>

    @endcan
@endsection

<!-- end:: Content Head -->

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--Begin::Row-->
        


            @if ($message = Session::get('success'))

                <div class="alert alert-success">

                    <p>{{ $message }}</p>

                </div>

            @endif


            <table class="table table-striped table-bordered table-hover" width="100%">

                <thead>
                
                <tr class="bg-dark text-white">

                   <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Roles</th>
                    <th width="280px">Action</th>

                </tr>

                </thead>

                <tbody>
                @forelse($data as $key => $user)

                    <tr>
                        <td>{{ $key+1 }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>

                        <td>

                            @if(!empty($user->getRoleNames()))

                                @foreach($user->getRoleNames() as $v)

                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif

                        </td>

                        <td>

                        <!--begin::Modal-->
                        <div class="modal fade" id="userViewModal{{$user->id}}" role="dialog" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-primary">
                                        <h5 class="modal-title" id="">User Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="la la-remove"></span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Roles
                                                </th>
                                            </tr>

                                            <tbody>
                                            <tr>
                                                <td>
                                                    {{$user->name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                @if(!empty($user->getRoleNames()))

                                                    @foreach($user->getRoleNames() as $v)

                                                        <label class="badge badge-success">{{ $v }}</label>

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

                            {!! Form::open(array('route' => ['users.destroy',$user->id],'method'=>'DELETE','id'=>"deleteForm$user->id")) !!}

                            <a class="btn btn-info btn-sm" href="userViewModal{{$user->id}}" data-toggle="modal" data-target="#userViewModal{{$user->id}}">Show</a>

                            <a class="btn btn-success btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="la la-pencil-square"></i></a>

                            <a href="{{URL::to('/admin/user-password/'.$user->id)}}" class="btn btn-primary btn-sm" title="Click to change password">
                                <i class="fa fa-key"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$user->id}}")'><i class="la la-trash"></i></button>
                            {!! Form::close() !!}



                        </td>

                    </tr>


                @empty
                    <tr>
                        <td colspan="5"><h1 class="text-center">No user data found !</h1></td>
                    </tr>

                @endforelse
                </tbody>
            </table>



            {!! $data->render() !!}

        </div>

            <!--End::Row-->

            <!--End::Dashboard 1-->
    </div>

        <!-- end:: Content -->


    <!--begin::Modal-->
    <!-- <div class="modal fade" id="userViewModal" role="dialog" aria-labelledby="" aria-hidden="true">
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
    </div> -->

    <!--end::Modal-->


@endsection

@section('script')

<script>

function showUserFunction(id){
    console.log(id);

    $('#userViewModal').modal('show')

}

</script>

@endsection