@extends('layouts.vmsapp')

@section('title')
    Order Search | {{auth()->user()->name}}
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    Order Search
@endsection

@section('subheader-action')
    {{--@can('product-create')--}}
    {{--<a href="{{ url('admin/orders/recent') }}" class="btn btn-success pull-right" title="Click to create new product">--}}
    {{--<i class="la la-list"></i> Recent Orders--}}
    {{--</a>--}}
    {{--@endcan--}}
@endsection



@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            {!! Form::open(array('url' => 'admin/orders-search','method'=>'GET','class'=>'kt-form kt-form--label-right','files'=>false)) !!}

            <div class="row" id="discountArea"><!--start promotion -->

                <div class="form-group col-md-2">
                    <label for="example-text-input" class="control-label">Date From </label>

                    <input type="text" name="date_start" class="form-control" id="dateFrom" value="{{old('date_start')}}" />


                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-2">
                    <label for="example-text-input" class="control-label">Date To </label>

                    <input type="text" name="date_end" class="form-control" id="dateTo" value="{{old('date_end')}}" />

                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="form-group col-md-2">

                    <label for="example-text-input" class="control-label" title="Enter Discount Percent "> Order Status <sup class="text-danger">*</sup></label>

                    {!! Form::select('order_status', $orderStatuses,[$request->order_status?$request->order_status:''], ['placeholder' =>'All Status','class' => 'form-control','required'=>false]) !!}
                </div>

                <div class="form-group col-md-2">

                    <label for="example-text-input" class="control-label" title="Enter Discount Percent "> Payment Status <sup class="text-danger">*</sup></label>

                    {!! Form::select('payment_status', $paymentStatuses,[$request->payment_status?$request->payment_status:''], ['placeholder' =>'All Payment Status','class' => 'form-control','required'=>false]) !!}
                </div>


                <div class="form-group col-md-2">
                    <label for="example-text-input" class="control-label"> &nbsp;</label>
                    <br>

                <button type="submit" class="btn btn-success" onclick="return ValidateCharacterLength()">Search</button>
                <a href="{{URL::to('/admin/orders-search')}}" class="btn btn-warning" >Refresh</a>
                </div>

            </div>



            {!! Form::close() !!}

            <!--Begin::Row-->
            <?php $currency=$setting->currency;?>

            <div class="export-pdf-btn" style="float: right;padding-bottom: 10px;">
                <a href="javascript:;" onclick='exportTableToExcel("orderList", "orderLists")' id="orderCsv" style="color: #13a055;font-size: 15px;font-weight:600;">Export as CSV</a>
                |
                <a href="javascript:;" onclick="generate('orderData','orderData')"  id="orderPdf" style="color: red;font-size: 15px;font-weight:600;">Export as PDF</a>
            </div>

            <div id="orderList">
                <table id="orderData" class="table table-striped table-bordered table-hover" width="100%">

                    <thead>
                    <tr class="">
                        <td class="text-center">Sl</td>
                        <td class="text-center">Order ID</td>
                        <td class="text-center">Order By</td>
                        <td class="text-center">Mobile</td>
                        <td class="text-center">Products</td>
                        <td class="text-center">Total</td>
                        <td class="text-center">Order Status</td>
                        <td class="text-center">Payment Status</td>
                        <td class="text-center">Order Date</td>
                        <td>Action</td>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($orders)>0)
                        <?php $totalAmount=0 ;?>
                        @foreach($orders  as $i=> $order)
                            <tr>
                                <?php $totalAmount+=$order->total;?>

                                <td>{{$i+1}}</td>
                                <td>{{$order->id}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->user->mobile}}</td>
                                <td><?php echo count(unserialize($order->cart_items))?></td>
                                <td>{{$order->total}}</td>
                                <td>

                                    @if($order->order_status==\App\Models\Order::COMPLETE)
                                        <button class="btn btn-success btn-sm">{{$order->order_status}}</button>

                                    @else
                                        <button class="btn btn-warning btn-sm">{{$order->order_status}}</button>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status==\App\Models\Order::PAID)
                                        <button class="btn btn-success btn-sm">{{$order->payment_status}}</button>

                                    @else
                                        <button class="btn btn-warning btn-sm">{{$order->payment_status}}</button>
                                    @endif


                                </td>
                                <td>{{date('M-d-Y',strtotime($order->created_at)) }}</td>
                                <td>

                                    {!! Form::open(array('route' => ['admin.orders.remove',$order->id],'method'=>'DELETE','id'=>"deleteForm$order->id")) !!}

                                    <a href="{{URL::to('/admin/orders/'.$order->id)}}" class="btn btn-primary btn-sm" title="View Order Details">
                                        <i class="fa fa-eye"></i></a>

                                    <a href="{{URL::to('/admin/orders/edit/'.$order->id)}}" class="btn btn-warning btn-sm" title="Click here to Change Order Status">
                                        <i class="la la-pencil"></i></a>

                                    @if($order->order_status!=\App\Models\Order::COMPLETE && $order->payment_status==\App\Models\Order::UNPAID)
                                        <button type="button" onclick='return deleteConfirm("deleteForm{{$order->id}}")' title="Click here to remove order" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i></button>
                                    @endif
                                    {!! Form::close() !!}

                                </td>

                            </tr>

                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right">Total Amount</td>
                            <td colspan="5"> {{$totalAmount}}</td>
                        </tr>

                    @else

                        <tr>
                            <td colspan="10" class="text-center">No Order Data Found</td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>

        </div>
        <!--End::Row-->
        <!--End::Dashboard 1-->
    </div>
    <!-- end:: Content -->
@endsection

@section('script')



    {{--Download excel and pdf--}}

    <script src="{{asset('/pdf')}}/jspdf.umd.min.js"></script>
    <script src="{{asset('/pdf')}}/spdf.plugin.autotable.js"></script>

    <script src="{{asset('/excel')}}/xlsx.core.min.js"></script>

    <script>

        function generate(tableId,filename) {
            var doc = new jspdf.jsPDF()


            //doc.autoTable({ head: head, body: body })

            // Simple html example
            doc.autoTable({ html: '#'+tableId })

            doc.save(filename+'.pdf')
        }

    </script>

    <script>

        function download_csv(csv, filename) {
            var csvFile;
            var downloadLink;
            // CSV FILE
            csvFile = new Blob([csv], {type: "text/csv"});
            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // We have to create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Make sure that the link is not displayed
            downloadLink.style.display = "none";

            // Add the link to your DOM
            document.body.appendChild(downloadLink);

            // Lanzamos
            downloadLink.click();
        }

        function exportTableToExcel(tableID, filename) {

            var csv = [];
            var rows = document.querySelectorAll("#"+tableID+" table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("#"+tableID+" td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV
            download_csv(csv.join("\n"), filename+'.csv');
        }
    </script>


    <link rel="stylesheet" href="{{asset('/client/assets')}}/daterangepicker/css/daterangepicker.css">
    <script src="{{asset('/client/assets')}}/daterangepicker/js/moment.min.js"></script>
    <script src="{{asset('/client/assets')}}/daterangepicker/js/daterangepicker.js"></script>

    <script>
        $(function() {
            $('#dateFrom').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            //$('#dateFrom').val(');

            @if($request->has('date_start'))
            $('#dateFrom').val("{{date('m-d-Y',strtotime($request->date_start))}}");
            @else
            $('#dateFrom').val("");
            @endif
        });

        $(function() {
            $('#dateTo').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: new Date(),
                //minDate: new Date(),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            //$('#dateTo').val('');
            @if($request->has('date_end'))
            $('#dateTo').val("{{date('m-d-Y',strtotime($request->date_end))}}");
            @else
            $('#dateTo').val('');
            @endif
        });
    </script>

@endsection