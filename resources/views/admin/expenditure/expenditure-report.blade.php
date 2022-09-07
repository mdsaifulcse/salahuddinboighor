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

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            {!! Form::open(array('url' => 'admin/expenditures-report','method'=>'GET','class'=>'kt-form kt-form--label-right','files'=>false,'style'=>'border: 1px solid #a2a2a2;padding: 5px 10px;background-color: #dddddd;')) !!}

            <div class="row" ><!--start From -->

                <div class="form-group col-md-2">

                    <label for="example-text-input" class="control-label" title="Enter Discount Percent "> Expense Head <sup class="text-danger">*</sup></label>

                    {!! Form::select('income_expense_head_id', $incomeExpenseHeads,[$request->income_expense_head_id?$request->income_expense_head_id:''], ['id'=>'kt_select2_2_1','placeholder' =>'All Expenditure Head','class' => 'form-control','required'=>false]) !!}
                </div>

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
                    <label for="example-text-input" class="control-label"> &nbsp;</label>
                    <br>

                <button type="submit" class="btn btn-success" onclick="return ValidateCharacterLength()">Search</button>
                <a href="{{URL::to('/admin/expenditures-report')}}" class="btn btn-warning" >Refresh</a>
                </div>

            </div><!--End From -->



            {!! Form::close() !!}

            <!--Begin::Row-->
            <?php $currency=$setting->currency;?>

            <div class="export-pdf-btn" style="float: right;padding-bottom: 10px;">
                <a href="javascript:;" onclick='exportTableToExcel("orderList", "ExpenditureReport")' id="orderCsv" style="color: #13a055;font-size: 15px;font-weight:600;">Export as CSV</a>
                |
                <a href="javascript:;" onclick="generate('orderData','ExpenditureReport')"  id="orderPdf" style="color: red;font-size: 15px;font-weight:600;">Export as PDF</a>
            </div>

            <div id="orderList">
                <table id="orderData" class="table table-striped table-bordered table-hover" width="100%">

                    <thead>
                    <tr class="">
                        <th>SL</th>
                        <th>Expense Heas</th>
                        <th>Sub Head</th>
                        <th>Expense Account</th>
                        <th>Note</th>
                        <th>Amount</th>
                        <th>Expense Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($expenditures)>0)
                        <?php $totalAmount=0 ;?>
                        @foreach($expenditures  as $i=> $expenditure)
                            <tr>
                                <?php $totalAmount+=$expenditure->amount;?>

                                <td>{{$i+1}}</td>
                                <td>{{$expenditure->head->head_title}}</td>

                                <td>{{$expenditure->subHead?$expenditure->subHead->sub_head_title:''}}</td>

                                <td>{{$expenditure->expense_method}}</td>

                                <td>{{$expenditure->note}}</td>

                                <td>{{$expenditure->amount}}</td>

                                <td>{{date('M-d-Y',strtotime($expenditure->expense_date)) }}</td>

                            </tr>

                        @endforeach

                        <tr>
                            <td colspan="5" class="text-right">Total Amount</td>
                            <td colspan="3"> {{$totalAmount}}</td>
                        </tr>

                    @else

                        <tr>
                            <td colspan="7" class="text-center">No Expenditure Data Found</td>
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
            $('#dateFrom').val("{{$request->date_start}}");
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
            @if($request->has('date_end'))
            $('#dateTo').val("{{$request->date_end}}");
            @else
            $('#dateTo').val('');
            @endif
        });
    </script>

@endsection