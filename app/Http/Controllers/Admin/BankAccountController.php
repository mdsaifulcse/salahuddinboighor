<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=BankAccount::orderBy('serial_num','DESC')->paginate(150);
        $max_serial=BankAccount::max('serial_num');

        $title='Bank Account';
        $status=[
            \App\Models\BankAccount::ACTIVE  => \App\Models\BankAccount::ACTIVE ,
            \App\Models\BankAccount::INACTIVE  => \App\Models\BankAccount::INACTIVE,
        ];

        return view('admin.bank-account.index',compact('allData','max_serial','title','status'));

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

        $validator = Validator::make($input, [
            'bank_name' => 'required|max:200',
            'bank_branch' => 'required|max:200',
            'account_title' => 'required|max:200',
            'account_number' => 'required|max:150|unique:bank_accounts,account_number,NULL,id,deleted_at,NULL',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{

            $input['created_by']=\Auth::user()->id;
            if (is_null($request->balance))
            {
                $input['balance']=0.0;
            }
            BankAccount::create($input);

            return redirect()->back()->with('success','Data Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $input = $request->all();

        $id=$bankAccount->id;

        $validator = Validator::make($input, [
            'bank_name' => 'required|max:200',
            'bank_branch' => 'required|max:200',
            'account_title' => 'required|max:200',
            'account_number' => "required|max:150|unique:bank_accounts,account_number,$id,id,deleted_at,NULL",
            'serial_num' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->getmessagebag());
        }


        $input['updated_by']=\Auth::user()->id;


        try{
            if (is_null($request->balance))
            {
                $input['balance']=0.0;
            }

            $bankAccount->update($input);

            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        try{
            $bankAccount->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
