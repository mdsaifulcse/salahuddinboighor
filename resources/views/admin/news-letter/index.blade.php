@extends('layouts.vmsapp')

@section('title')
	News Letter
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	News Letter
@endsection

@section('subheader-action')
	@can('news-letters')
		<a href="#newEmail" data-target="#newEmail" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Add New Email
		</a>
	@endcan
@endsection

<!-- end:: Content Head -->

@section('content')

	<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

		<!-- begin:: Content Head -->


		<!-- end:: Content Head -->

		<!-- begin:: Content -->
		<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

			<!--Begin::Row-->

			<!-- Modal Start -->
			<div class="modal fade" id="newEmail">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						{!! Form::open(['route' => 'news-letters.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Add New Email</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">

								<div class="col-md-12">
									{{Form::text('email',$value=old('email'),array('class'=>'form-control','placeholder'=>'New Email','required','autofocus'))}}
									@if ($errors->has('email'))

										<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('email') }}</strong>
                    					</span>
									@endif
								</div>

							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success ">Submit</button>
							<a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
						</div>
						{!! Form::close(); !!}
					</div>
				</div>
			</div>
			<!-- Modal End -->


			<div class="row justify-content-md-center justify-content-lg-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
						<thead>
						<tr>
							<th>Sl</th>
							<th>Email</th>
							<th>Created By</th>
							<th>Created At</th>
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
            $('#data-table').DataTable( {
                processing: true,
                serverSide: true,

                ajax: '{{ URL::to("admin/news-letters/create") }}',
                columns: [
                    { data: 'DT_RowIndex',orderable:true},
                    { data: 'email',name:'news_letters.email'},
                    { data: 'name','name':'users.name'},
                    { data: 'Created At'},
                    { data: 'action'},
                ]
            });
        });
	</script>

@endsection

<!-- Good -->





