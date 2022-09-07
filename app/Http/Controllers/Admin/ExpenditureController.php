<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use App\Models\IncomeExpenseHead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;


class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Expenditure ';
        return view('admin.expenditure.index',compact('title'));
    }

    public function getExpenditureData()
    {
        $allData=Expenditure::leftJoin('income_expense_heads','expenditures.income_expense_head_id','income_expense_heads.id')
            ->leftJoin('income_expense_sub_heads','expenditures.income_expense_sub_head_id','income_expense_sub_heads.id')
            ->leftJoin('bank_accounts','expenditures.bank_account_id','bank_accounts.id')
            ->select('income_expense_heads.head_title','income_expense_sub_heads.sub_head_title','expenditures.id','expenditures.amount',
                'expenditures.note','expenditures.expense_date','expenditures.expense_method')
            ->orderBy('expenditures.id','desc');

        return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('Expense Date','
                    <?php echo date(\'M-d-Y\',strtotime($expense_date)) ;?>
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'expenditures.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                
                <a href="{{route(\'expenditures.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                <a href="{{route(\'expenditures.show\',$id)}}" class="btn btn-success btn-sm" title="Click here to Show"><i class="la la-eye"></i>  </a>
                
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                
            {!! Form::close() !!}
            ')
            ->rawColumns(['action','Expense Date'])
            ->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Expenditure ';
        $bankAccounts=DataLoad::bankAccountList();
        $expenseMethods=[
            Expenditure::CASH=>Expenditure::CASH,
            Expenditure::BANK=>Expenditure::BANK,
            Expenditure::BKASH=>Expenditure::BKASH,
            Expenditure::ROCKET=>Expenditure::ROCKET,
            Expenditure::NAGAD=>Expenditure::NAGAD,
        ];
        $incomeExpenseHeads=DataLoad::incomeExpenseList(IncomeExpenseHead::EXPENSE);

        return view('admin.expenditure.create',compact('title','expenseMethods','bankAccounts','incomeExpenseHeads'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'income_expense_head_id' => 'required|exists:income_expense_heads,id',
            'income_expense_sub_head_id' => 'nullable|exists:income_expense_sub_heads,id',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'amount' => 'required',
            'expense_method' => 'required',
            'expense_date' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{

            $input['created_by']=\Auth::user()->id;


            $input['voucher_no']=Expenditure::VOUCHERSTART+Expenditure::max('id')+1;

            if (!is_null($request->expense_date))
            {
                $input['expense_date']=date('Y-m-d',strtotime($request->expense_date));
            }


            Expenditure::create($input);

            return redirect()->back()->with('success','Data Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenditure=Expenditure::with('head','subHead','bankAccount','createdBy')->findOrFail($id);
        $title='Expenditure ';
        return view('admin.expenditure.show',compact('title','expenditure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenditure $expenditure)
    {
        $title='Expenditure';
        $bankAccounts=DataLoad::bankAccountList();
        $expenseMethods=[
            Expenditure::CASH=>Expenditure::CASH,
            Expenditure::BANK=>Expenditure::BANK,
            Expenditure::BKASH=>Expenditure::BKASH,
            Expenditure::ROCKET=>Expenditure::ROCKET,
            Expenditure::NAGAD=>Expenditure::NAGAD,
        ];
        $incomeExpenseHeads=DataLoad::incomeExpenseList(IncomeExpenseHead::EXPENSE);
        $subHeadsForHead=DataLoad::incomeExpenseSubHeads($expenditure->income_expense_head_id);

        return view('admin.expenditure.edit',compact('title','expenseMethods','bankAccounts','incomeExpenseHeads','subHeadsForHead','expenditure'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'income_expense_head_id' => 'required|exists:income_expense_heads,id',
            'income_expense_sub_head_id' => 'nullable|exists:income_expense_sub_heads,id',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'amount' => 'required',
            'expense_method' => 'required',
            'expense_date' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{

            $input['updated_at']=\Auth::user()->id;

            if (!is_null($request->expense_date))
            {
                $input['expense_date']=date('Y-m-d',strtotime($request->expense_date));
            }


            $expenditure->update($input);

            return redirect()->back()->with('success','Data Successfully Update');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenditure $expenditure)
    {
        try{
            $expenditure->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function createExpenditureReport(Request $request)
    {

        $title='Expenditure Report';
        $setting=DataLoad::setting();
        $incomeExpenseHeads=DataLoad::incomeExpenseList(IncomeExpenseHead::EXPENSE);


        $expenditures=[];

        if (count($request->all()) > 1) {
            $expenditures = Expenditure::with('head', 'subHead', 'bankAccount', 'createdBy');

            if ($request->has('vendor_id') && !is_null($request->vendor_id)) {
                $expenditures = $expenditures->where(['expenditures.vendor_id' => $request->vendor_id]);
            }


            if (!is_null($request->date_start) && !is_null($request->date_end)) {

                $date_start = date('Y-m-d', strtotime($request->date_start));
                $date_end = date('Y-m-d', strtotime($request->date_end));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s', "$date_start 00:00:00")->format('Y-m-d H:i:s');
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s', "$date_end 23:59:59")->format('Y-m-d H:i:s');

                $expenditures = $expenditures->whereBetween('expense_date', [$date_start, $date_end]);

            } elseif (!is_null($request->date_start)) {

                $date_start = date('Y-m-d', strtotime($request->date_start));

                $date_start = Carbon::createFromFormat('Y-m-d H:i:s', "$date_start 00:00:00")->format('Y-m-d H:i:s');

                $expenditures = $expenditures->whereDate('expense_date', '>=', $date_start);

            } elseif (!is_null($request->date_end)) {
                $date_end = date('Y-m-d', strtotime($request->date_end));
                $date_end = Carbon::createFromFormat('Y-m-d H:i:s', "$date_end 00:00:00")->format('Y-m-d H:i:s');

                $expenditures = $expenditures->whereDate('expense_date', '<=', $date_end);

            }

            $expenditures = $expenditures->orderBy('expenditures.id', 'DESC')->get();
        }


        return view('admin.expenditure.expenditure-report',compact('title','setting','expenditures','incomeExpenseHeads','request'));

        }

}
