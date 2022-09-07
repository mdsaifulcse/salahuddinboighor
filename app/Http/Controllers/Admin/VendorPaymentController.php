<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class VendorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Supplier Payment ';
        return view('admin.vendor-payment.index',compact('title'));
    }


    public function getVendorPaymentData()
    {
        $allData=VendorPayment::leftJoin('vendors','vendor_payments.vendor_id','vendors.id')
            ->select('vendors.name','vendor_payments.id','vendor_payments.payable','vendor_payments.payment','vendor_payments.due','vendor_payments.status','vendor_payments.payment_date')
            ->orderBy('vendor_payments.id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('status','
                     @if($status==\App\Models\VendorPayment::PAID)
                        <button class="btn btn-success btn-sm">{{$status}}</button>
                         @elseif($status==\App\Models\VendorPayment::DUE)
                            <button class="btn btn-warning btn-sm">{{$status}}</button>
                            @else
                            <button class="btn btn-default btn-sm">{{$status}}</button>
                        @endif
                ')
            ->addColumn('Payment Date','
                    <?php echo date(\'M-d-Y\',strtotime($payment_date)) ;?>
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'vendor-payments.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                
                <a href="{{route(\'vendor-payments.show\',$id)}}" class="btn btn-success btn-sm" title="Click here to update"><i class="la la-eye"></i> Details </a>
                
                
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                
            {!! Form::close() !!}
            ')
            ->rawColumns(['action','Payment Date','status'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       $title='Supplier Payment';
       $paymentMethods=[
           VendorPayment::CASH=>VendorPayment::CASH,
           VendorPayment::BANK=>VendorPayment::BANK,
           VendorPayment::BKASH=>VendorPayment::BKASH,
           VendorPayment::ROCKET=>VendorPayment::ROCKET,
           VendorPayment::NAGAD=>VendorPayment::NAGAD,
       ];

       $bankAccounts=DataLoad::bankAccountList();
       $vendors=DataLoad::vendorList();

        return view('admin.vendor-payment.create',compact('title','paymentMethods','bankAccounts','vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function vendorRemainingDueCalculation($vendorId)
    {
        $vendor=Vendor::findOrFail($vendorId);

       return $totalDueRemaining=$vendor->total_due-$vendor->balance;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vendor_id' => 'required|exists:vendors,id',
            'payable' => 'required',
            'payment' => 'required',
            'payment_method' => 'required',
            'payment_date' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try{

            $input['created_by']=\Auth::user()->id;

            if (!is_null($request->payment_date))
            {
                $input['payment_date']=date('Y-m-d',strtotime($request->payment_date));
            }

            if ($request->payable==$request->payment)
            {
                $input['status']=VendorPayment::PAID;
            }else{
                $input['status']=VendorPayment::DUE;
            }


            $vendorPayment=VendorPayment::create($input);

            $updateVendorTotalDue=Vendor::where(['id'=>$request->vendor_id])->first();

            $updateVendorTotalDue->update(['balance'=>$updateVendorTotalDue->balance+$vendorPayment->payment]);

            DB::commit();
            return redirect()->back()->with('success','Data Successfully Save');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $title='Supplier Payment';
         $vendorPayment=VendorPayment::with('vendor','bankAccount')->findOrFail($id);
        return view('admin.vendor-payment.show',compact('title','vendorPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorPayment $vendorPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorPayment $vendorPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorPayment  $vendorPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorPayment $vendorPayment)
    {

        DB::beginTransaction();
        try{

            $minusPreviousVendorTotalDue=Vendor::where(['id'=>$vendorPayment->vendor_id])->first();
            $minusPreviousVendorTotalDue->update(['balance'=>$minusPreviousVendorTotalDue->balance-$vendorPayment->payment]);

            $vendorPayment->delete();
            DB::commit();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function paymentReport(Request $request)
    {

        $title='Supplier Payment Report';
        $vendors=DataLoad::vendorList();
        $setting=DataLoad::setting();
        $paymentStatuses=[
            VendorPayment::DUE=>VendorPayment::DUE,
            VendorPayment::PAID=>VendorPayment::PAID,
        ];

        //return $request;

        $payments=[];

        if (count($request->all()) > 1)
        {
            $payments=VendorPayment::with('vendor','bankAccount');

            if ($request->has('vendor_id') && !is_null($request->vendor_id))
            {
                $payments=$payments->where(['vendor_payments.vendor_id'=>$request->vendor_id]);
            }


            if ( !is_null($request->date_start) && !is_null($request->date_end))
            {

                $date_start=date('Y-m-d',strtotime($request->date_start));
                $date_end=date('Y-m-d',strtotime($request->date_end));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s',"$date_start 00:00:00")->format('Y-m-d H:i:s');
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s',"$date_end 23:59:59")->format('Y-m-d H:i:s');

                $payments=$payments->whereBetween('payment_date',[$date_start,$date_end]);

            }elseif(!is_null($request->date_start))
            {
                $date_start=date('Y-m-d',strtotime($request->date_start));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s',"$date_start 00:00:00")->format('Y-m-d H:i:s');

                $payments=$payments->whereDate('payment_date','>=',$date_start);

            }elseif(!is_null($request->date_end))
            {
                $date_end=date('Y-m-d',strtotime($request->date_end));
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s',"$date_end 00:00:00")->format('Y-m-d H:i:s');

                $payments=$payments->whereDate('payment_date','<=',$date_end);

            }


            if ($request->has('status') && !is_null($request->status))
            {
                $payments=$payments->where(['status'=>$request->status]);
            }

            $payments=$payments->orderBy('vendor_payments.payment_date', 'DESC')->get();
        }


        return view('admin.vendor-payment-report.payment-report',compact('title','vendors','setting','payments','paymentStatuses','request'));

    }



}
