<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeExpenseHead;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class IncomeExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=IncomeExpenseHead::with('incomeExpenseSubHead')->orderBy('serial_num','DESC')->paginate(150);
        $max_serial=IncomeExpenseHead::max('serial_num');

        $title='Income | Expense Head';
        $status=[
            \App\Models\IncomeExpenseHead::ACTIVE  => \App\Models\IncomeExpenseHead::ACTIVE ,
            \App\Models\IncomeExpenseHead::INACTIVE  => \App\Models\IncomeExpenseHead::INACTIVE,
            \App\Models\IncomeExpenseHead::OTHER  => \App\Models\IncomeExpenseHead::OTHER
        ];
        $headType=[
            \App\Models\IncomeExpenseHead::INCOME  => \App\Models\IncomeExpenseHead::INCOME ,
            \App\Models\IncomeExpenseHead::EXPENSE  => \App\Models\IncomeExpenseHead::EXPENSE
        ];
        return view('admin.expense.index',compact('allData','max_serial','title','status','headType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $input = $request->all();
        if (is_null($request->link)) {
            $input['link']= MyHelper::slugify($request->head_title);
        }

        $validator = Validator::make($input, [
            'head_title' => 'required|max:150|unique:income_expense_heads,head_title,NULL,id,deleted_at,NULL',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{

            $input['created_by']=\Auth::user()->id;
            IncomeExpenseHead::create($input);

            return redirect()->back()->with('success','Data Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomeExpenseHead  $incomeExpenseHead
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeExpenseHead $incomeExpenseHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomeExpenseHead  $incomeExpenseHead
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeExpenseHead $incomeExpenseHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeExpenseHead  $incomeExpenseHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomeExpenseHead $incomeExpenseHead)
    {
        $input = $request->all();

        $id=$incomeExpenseHead->id;

        $validator = Validator::make($input, [
            'head_title' => "required|max:150|unique:income_expense_heads,head_title,$id,id,deleted_at,NULL",
            'serial_num' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->getmessagebag());
        }


        $input['updated_by']=\Auth::user()->id;


        try{

            $incomeExpenseHead->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomeExpenseHead  $incomeExpenseHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeExpenseHead $incomeExpenseHead)
    {
        try{
            $incomeExpenseHead->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
