<?php



namespace App\Http\Controllers\Spatie;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use DB;


class RoleController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */


    function __construct()

    {

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $roles = Role::orderBy('id', 'DESC')->paginate(10);

        return view('admin.spatie.roles.index', compact('roles'))

            ->with('i', ($request->input('page', 1) - 1) * 5);
    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $permissions = Permission::orderBy('id','DESC')->get();
        $permissions=collect($permissions);

        return view('admin.spatie.roles.create', compact('permissions'));
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required|unique:roles,name',

            'permission' => 'required',

        ]);

        DB::beginTransaction();
        try{


            $role = Role::create(['name' => $request->input('name')]);

            $role->syncPermissions($request->input('permission'));

            DB::commit();
            $bug = 0;
        }catch(Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug==0){
            return redirect()->back()->with('success','New Role successfully created');
        }elseif($bug==1062){
            return redirect()->back()->with('error',$bug);
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")

            ->where("role_has_permissions.role_id", $id)->get();



        return view('admin.spatie.roles.show', compact('role', 'rolePermissions'));
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $role = Role::find($id);

        $permissions = Permission::orderBy('id','DESC')->get();

        $permissions=collect($permissions);

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)

            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')

            ->all();



        return view('admin.spatie.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'permission' => 'required',

        ]);


        $role = Role::findOrFail($id);

        DB::beginTransaction();
        try{

            $role->name = $request->input('name');

            $role->save();

            $role->syncPermissions($request->input('permission'));

            DB::commit();
            $bug = 0;
        }catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug==0){
            return redirect()->back()->with('success','New Role successfully created');
        }elseif($bug==1062){
            return redirect()->back()->with('error',$bug);
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $result = Role::find($id);

            if($result == NULL) //check if no record found
            {
                return redirect()->back()->with('error','Something Error Found !, Please try again.');
            }

            if($result->id ==1 || $result->id ==2) //check if no record found
            {
                return redirect()->back()->with('error','This Role Can not be delete');
            }
           

        try{
            DB::table("roles")->where('id', $id)->delete();

            $bug = 0;
        }catch(\Exception $e){
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];

        }


        if($bug == 0){
            return redirect()->back()->with('success','User Deleted Successfully');
        }elseif ($bug==1451){

        return redirect()->back()->with('error', 'Sorry this Course can not be delete due to used another module');

        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }

    }
}
