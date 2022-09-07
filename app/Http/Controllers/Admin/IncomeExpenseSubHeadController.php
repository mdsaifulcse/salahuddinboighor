<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeExpenseHead;
use App\Models\IncomeExpenseSubHead;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class IncomeExpenseSubHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $input = $request->all();
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->sub_head_title);
        }


        try{
            $validator = Validator::make($input, [
                'sub_head_title' => 'required|max:200|unique:income_expense_sub_heads,sub_head_title,NULL,id,deleted_at,NULL',
                'link' => 'required|unique:income_expense_sub_heads,link,NULL,id,deleted_at,NULL',
                'income_expense_head_id' => 'required|exists:income_expense_heads,id',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $input['created_by']=\Auth::user()->id;

            IncomeExpenseSubHead::create($input);
            return redirect()->back()->with('success','Data Successfully Inserted');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomeExpenseSubHead  $incomeExpenseSubHead
     * @return \Illuminate\Http\Response
     */
    public function show($incomeExpenseHeadId)
    {
        $allData=IncomeExpenseSubHead::with('incomeExpenseHead')->where('income_expense_head_id',$incomeExpenseHeadId)->orderBy('id','DESC')
            ->paginate(100);

        $incomeExpenseHead=IncomeExpenseHead::findOrFail($incomeExpenseHeadId);

        $max_serial=IncomeExpenseSubHead::where('income_expense_head_id',$incomeExpenseHeadId)->max('serial_num');

        $title='Sub Head';
        $status=[
            \App\Models\IncomeExpenseSubHead::ACTIVE  => \App\Models\IncomeExpenseSubHead::ACTIVE ,
            \App\Models\IncomeExpenseSubHead::INACTIVE  => \App\Models\IncomeExpenseSubHead::INACTIVE,
        ];

        return view('admin.expense.sub-head',compact('allData','incomeExpenseHead','max_serial','title','status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomeExpenseSubHead  $incomeExpenseSubHead
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeExpenseSubHead $incomeExpenseSubHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeExpenseSubHead  $incomeExpenseSubHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomeExpenseSubHead $incomeExpenseSubHead)
    {
        $input = $request->all();
        $id=$incomeExpenseSubHead->id;

        $validator = Validator::make($input, [
            'sub_head_title' => "required|max:150|unique:income_expense_sub_heads,sub_head_title,$id,id,deleted_at,NULL",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->getmessagebag());
        }

        $input['updated_by']=\Auth::user()->id;
        try{


            $incomeExpenseSubHead->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomeExpenseSubHead  $incomeExpenseSubHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeExpenseSubHead $incomeExpenseSubHead)
    {
        try{
            $incomeExpenseSubHead->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
