@extends('layouts.vmsapp')

@section('title')
    {{$title}} | {{auth()->user()->name}}
@endsection

@section('style')
@endsection


<!-- begin:: Content Head -->

@section('subheader')
    {{$title}}
@endsection

@section('subheader-action')
    @can('vendor-payment-list')
    <a href="{{ url('admin/vendor-payments') }}" class="btn btn-success pull-right" title="Click to Supplier Payment List">
    <i class="la la-list"></i> Supplier Payment List
    </a>
    @endcan
@endsection



@section('content')

    <!-- for taging -->
    <link rel="stylesheet" href="{{asset('/tagging/css/jqueryui1.12.1-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/jquery.tagit.css')}}">
    <link rel="stylesheet" href="{{asset('/tagging/css/tagit.ui-zendesk.css')}}">


    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            {!! Form::open(array('url' => 'admin/inventory-stock-report','method'=>'GET','class'=>'kt-form kt-form--label-right','files'=>false,'style'=>'border: 1px solid #a2a2a2;padding: 5px 10px;background-color: #dddddd;')) !!}

            <div class="row" ><!--start From -->

                <div class="form-group col-md-2">

                    <label for="example-text-input" class="control-label" title="Enter Discount Percent "> Category <sup class="text-danger">*</sup></label>

                    {!! Form::select('category_id', $categories,[$request->category_id?$request->category_id:''], ['placeholder' =>'All Category','class' => 'form-control','required'=>false]) !!}
                </div>

                <div class="form-group col-md-3">
                    <label for="example-text-input" class="control-label">Product Search <sup class="text-danger">*</sup></label>

                    {{Form::text('product_name',$value=old('product_name'), ['id'=>'productField','class' => 'form-control','required'=>false,'style'=>'display:none',])}}

                    <ul id="productFieldUl"></ul>
                    <span class="productError text-danger"> </span>
                    @if ($errors->has('product_name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('product_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-2">
                    <label for="example-text-input" class="control-label">Date </label>

                    <input type="text" name="date_start" class="form-control" id="dateFrom" value="{{old('date_start')}}" />

                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="form-group col-md-2">
                    <label for="example-text-input" class="control-label"> &nbsp;</label>
                    <br>

                <button type="submit" class="btn btn-success" onclick="return ValidateCharacterLength()">Search</button>
                <a href="{{URL::to('/admin/inventory-stock-report')}}" class="btn btn-warning" >Refresh</a>
                </div>

            </div><!--End From -->



            {!! Form::close() !!}

            <!--Begin::Row-->
            <?php $currency=$setting->currency;?>

            <div class="export-pdf-btn" style="float: right;padding-bottom: 10px;">
                <a href="javascript:;" onclick='exportTableToExcel("orderList", "payment-Report")' id="orderCsv" style="color: #13a055;font-size: 15px;font-weight:600;">Export as CSV</a>
                |
                <a href="javascript:;" onclick="generate('orderData','payment-Report')"  id="orderPdf" style="color: red;font-size: 15px;font-weight:600;">Export as PDF</a>
            </div>

            <div id="orderList">
                <table id="orderData" class="table table-striped table-bordered table-hover" width="100%">

                    <thead>
                    <tr >
                        <td class="text-left">Sl</td>
                        <td class="text-left">Item Code</td>
                        <td class="text-left">Product Name</td>
                        <td class="text-left">Category</td>
                        <td class="text-left">Purchase Qty</td>
                        <td class="text-left">Sale Qty</td>
                        <td class="text-left">Sale Return</td>
                        <td class="text-left">Purchase Return</td>
                        <td class="text-left">Stock</td>
                        <td class="text-left">Price</td>
                        <td class="text-left">Total Price</td>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($productInventoryStocks)>0)
                        <?php $totalStock=0 ;?>
                        @foreach($productInventoryStocks  as $i=> $product)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->categoryProducts->category_name}}</td>
                                <td>{{$product->productStock->qty}}</td>
                                <td>{{$product->productStock->sold_qty}}</td>
                                <td>{{$product->productStock->sold_return_qty}}</td>
                                <td>{{$product->productStock->purchase_return_qty}}</td>
                                <td>
                                    <?php $balanceQty=($product->productStock->qty+$product->productStock->sold_return_qty)-($product->productStock->sold_qty+$product->productStock->purchase_return_qty)?>
                                    {{$balanceQty}}
                                </td>
                                <?php $totalStock+=$balanceQty;?>
                                <td>{{$product->productStock->cost_price}}</td>
                                <td>{{$product->productStock->cost_price*$balanceQty}}</td>

                            </tr>

                        @endforeach

                        <tr>
                            <td colspan="8" class="text-right">Total Stock</td>
                            <td colspan="3"> {{$totalStock}}</td>
                        </tr>

                    @else

                        <tr>
                            <td colspan="11" class="text-center">No Product Inventory Stock Data Found</td>
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

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{asset('/tagging/js/jquery-1.12.1-ui.min.js')}}"></script>
    <script src="{{asset('/tagging/js/tag-it.min.js')}}"></script>

    <script>
        $(function(){
            $('#productFieldUl').tagit({
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: false,
                singleFieldNode: $('#productField'),
                allowSpaces: true,
                fieldName:"product_name",
                tagLimit:1,
                placeholderText:'Search Product',
                //autocomplete: {source:country_list},
                autocomplete: {
                    source: function( request, response ) {
                        $.ajax({
                            url: "{{URL::to('/admin/search-products-for-inventory-report')}}",
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },

                },

            });
        });
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

            @if($request->has('date_start') && !is_null($request->date_start))
            $('#dateFrom').val("{{date('m/d/Y',strtotime($request->date_start))}}");
            @else
            $('#dateFrom').val('');
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
            @if($request->has('date_end') && !is_null($request->date_end))
            $('#dateTo').val("{{date('m-d-Y',strtotime($request->date_end))}}");
            @else
            $('#dateTo').val('');
            @endif
        });
    </script>

@endsection