@extends('layouts.vmsapp')

@section('title')
	Vat | Tax | Create
@endsection


<!-- begin:: Content Head -->

@section('subheader')
	Vat | Tax | List
@endsection

@section('subheader-action')
	@can('vat-taxes')
		<a href="#vatTaxModal" data-target="#vatTaxModal" data-toggle="modal" class="btn btn-success pull-right">
			<i class="la la-plus"></i> Vat | Tax
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
			<div class="modal fade" id="vatTaxModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						{!! Form::open(['route' => 'vat-taxes.store','class'=>'form-horizontal','method'=>'POST','files'=>true]) !!}
						<div class="modal-header">
							<h4 class="modal-title">Create new Vat Or Tax</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						</div>
						<div class="modal-body">

							<div class="form-group row {{ $errors->has('vat_tax_name') ? 'has-error' : '' }}">
								{{Form::label('vat_tax_name', 'Vat Tax Name', array('class' => 'col-md-2 control-label'))}}
								<div class="col-md-8">
									{{Form::text('vat_tax_name',$value=old('vat_tax_name'),array('class'=>'form-control','placeholder'=>'Vat Or Tax Name','required','autofocus'))}}
									@if ($errors->has('vat_tax_name'))
										<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('vat_tax_name') }}</strong>
                    					</span>
									@endif
								</div>
								<div class="col-md-2">
									{{Form::select('status', [\App\Models\VatTax::ACTIVE  => \App\Models\VatTax::ACTIVE , \App\Models\VatTax::INACTIVE  => \App\Models\VatTax::INACTIVE],[], ['class' => 'form-control'])}}
								</div>
							</div>

							<div class="form-group row">

								<label class="control-label col-md-2 col-sm-3 text-right"> </label>

								<div class="col-md-3">

									{{Form::number('vat_tax_percent',$value=old('vat_tax_percent'),array('step'=>'any','class'=>'form-control','placeholder'=>'%','required','autofocus'))}}

									<span> Vat Tax Percentage </span>
									@if ($errors->has('vat_tax_percent'))
										<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('vat_tax_percent') }}</strong>
                    					</span>
									@endif
								</div>

								<div class="col-md-2 col-sm-2">
									{{Form::select('type', [\App\Models\VatTax::VAT  => \App\Models\VatTax::VAT , \App\Models\VatTax::TAX  => \App\Models\VatTax::TAX],[], ['class' => 'form-control'])}}
									<span> Type </span>
								</div>

                                <?php $max=$max_serial+1; ?>
								<div class="col-md-2">
									{{Form::number('serial_num',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
									<span> Serial No. </span>
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">

					<table id="data-table" class="table table-striped table-hover table-bordered center_table" width="100%">
						<thead>
						<tr class="bg-dark text-white">
							<th>Sl</th>
							<th>Vat Tax</th>
							<th>Percentage</th>
							<th>Type</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>

						@foreach($vatTaxes as $key=>$data)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$data->vat_tax_name}}</td>
								<td>{{$data->vat_tax_percent}}</td>
								<td>{{$data->type}}</td>
								<td>
									@if($data->status==\App\Models\VatTax::ACTIVE)
										<i class="fa fa-check-circle text-success"></i> {{$data->status}}
									@elseif($data->status==\App\Models\VatTax::INACTIVE)
										<i class="fa fa-times-circle text-danger"></i> {{$data->status}}
									@elseif($data->status==\App\Models\VatTax::DRAFT)
										<i class="fa fa-bolt text-info"></i> {{$data->status}}
									@endif
								</td>

								<td>

									<!-- #roleModal -->
									<div class="modal fade" id="tagModal{{$data->id}}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												{!! Form::open(['route' => ['vat-taxes.update',$data->id],'class'=>'form-horizontal','method'=>'PUT','files'=>true]) !!}
												<div class="modal-header">
													<h4 class="modal-title">Edit Vat Tax</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">

													<div class="form-group row {{ $errors->has('vat_tax_name') ? 'has-error' : '' }}">
														{{Form::label('vat_tax_name', 'Vat Tax Name', array('class' => 'col-md-2 control-label'))}}
														<div class="col-md-8">
															{{Form::text('vat_tax_name',$value=old('vat_tax_name',$data->vat_tax_name),array('class'=>'form-control','placeholder'=>'Vat Or Tax Name','required','autofocus'))}}
															@if ($errors->has('vat_tax_name'))
																<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('vat_tax_name') }}</strong>
                    					</span>
															@endif
														</div>
														<div class="col-md-2">
															{{Form::select('status', [\App\Models\VatTax::ACTIVE  => \App\Models\VatTax::ACTIVE , \App\Models\VatTax::INACTIVE  => \App\Models\VatTax::INACTIVE],$data->status, ['class' => 'form-control'])}}
														</div>
													</div>

													<div class="form-group row">

														<label class="control-label col-md-2 col-sm-3 text-right"> </label>

														<div class="col-md-3">

															{{Form::number('vat_tax_percent',$value=old('vat_tax_percent',$data->vat_tax_percent),array('step'=>'any','class'=>'form-control','placeholder'=>'%','required','autofocus'))}}

															<span> Vat Tax Percentage </span>
															@if ($errors->has('vat_tax_percent'))
																<span class="help-block">
                        					<strong class="text-danger">{{ $errors->first('vat_tax_percent') }}</strong>
                    					</span>
															@endif
														</div>

														<div class="col-md-2 col-sm-2">
															{{Form::select('type', [\App\Models\VatTax::VAT  => \App\Models\VatTax::VAT , \App\Models\VatTax::TAX  => \App\Models\VatTax::TAX],$data->type, ['class' => 'form-control'])}}
															<span> Type </span>
														</div>

                                                        <?php $max=$max_serial+1; ?>
														<div class="col-md-2">
															{{Form::number('serial_num',$data->serial_num, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
															<span> Serial No. </span>
														</div>
													</div>


												</div>

												<input type="hidden" value="{{$data->id}}" name="id"/>
												<div class="modal-footer">
													<button type="submit" class="btn btn-sm btn-success">Update</button>
													<a href="javascript:;" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</a>
												</div>
												{!! Form::close(); !!}
											</div>
										</div>
									</div>
									{{-- End of Modal --}}

									{!! Form::open(array('route' => ['vat-taxes.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
									<a href="#tagModal{{$data->id}}" data-toggle="modal" data-target="#tagModal{{$data->id}}" class="btn btn-success btn-sm"><i class="la la-pencil-square"></i> </a>
									<button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="la la-trash"></i></button>
									{!! Form::close() !!}

								</td>
							</tr>
						@endforeach
						</tbody>
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





