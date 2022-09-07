<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\SubSubMenu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Page;
use Validator,MyHelper,DataLoad;
use Spatie\Permission\Models\Permission;

class SubMenuController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
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

        if(isset($input['page'])){
            $page=Page::select('name','name_bn')->where('link',$input['page'])->first();
            $input['name']=$page['name'];
            $input['name_bn']=$page['name_bn'];
            $input['url']="page/".$input['page'];
        }

        if (isset($request->menu_as) && $request->menu_as=='Category'){

            $category=Category::findOrFail($request->category_id);
            $input['url']="/book/category/$category->id".'?ref='.$category->category_name;

        }elseif (isset($request->menu_as) && $request->menu_as=='Author'){

            $author=Author::select('id','name','link')->findOrFail($request->author_id);
            $input['url']="/book/author/$author->id".'?ref='.$author->name;
        }

        $validator = Validator::make($input, [   
                    'name'          => 'required',
                    'url'    => 'required',
                    'icon' => 'mimes:jpeg,jpg,bmp,png'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

        try{
            $input['slug']=json_encode($request->slug);

            if ($request->hasFile('icon')){
                $input['icon']=MyHelper::photoUpload($request->file('icon'),'images/menu/sub-menu/icon/',32);
                $input['big_icon']=MyHelper::photoUpload($request->file('icon'),'images/menu/sub-menu/big-icon/',128);

            }

            SubMenu::create($input);
                $bug=0;
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
            }
             if($bug==0){
            return redirect()->back()->with('success','Successfully Inserted');
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
        //$page=Page::where('status',1)->pluck('name','link');
        $allData=SubMenu::leftJoin('menus','sub_menus.menu_id','=','menus.id')->select('sub_menus.*','menus.name as menu_name')
            ->where('menu_id',$id)->orderBy('serial_num','DESC')->paginate(100);

        $menu=Menu::findOrFail($id);
        $max_serial=SubMenu::where('menu_id',$id)->max('serial_num');
        $permissions = Permission::orderBy('id','DESC')->pluck('name', 'name');
        $categories=DataLoad::categoryList();
        $authors=DataLoad::authorList();
        $menuFor=[
            SubMenu::ADMIN_MENU => SubMenu::ADMIN_MENU,
            SubMenu::CLIENT_MENU => SubMenu::CLIENT_MENU,
            SubMenu::USER_MENU => SubMenu::USER_MENU
        ];

        return view('admin.menu.subMenu',compact('allData','max_serial','menu','permissions','categories','menuFor','authors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data=SubMenu::leftJoin('menus','sub_menus.menu_id','=','menus.id')->select('sub_menus.*','menus.name as menu_name')
            ->where('sub_menus.id',$id)->orderBy('serial_num','DESC')->first(20);

        $menu=Menu::findOrFail($data->menu_id);
        $max_serial=SubMenu::where('menu_id',$data->menu_id)->max('serial_num');
        $permissions = Permission::orderBy('id','DESC')->pluck('name', 'name');
        $menuFor=[
            SubMenu::ADMIN_MENU => SubMenu::ADMIN_MENU,
            SubMenu::CLIENT_MENU => SubMenu::CLIENT_MENU,
            SubMenu::USER_MENU => SubMenu::USER_MENU
        ];
        $categories=DataLoad::categoryList();
        $authors=DataLoad::authorList();

        return view('admin.menu.subMenuEdit',compact('data','max_serial','menu','permissions','categories','menuFor','authors'));
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
       $input = $request->all();
        $data=SubMenu::findOrFail($id);

        if (isset($request->menu_as) && $request->menu_as=='Category'){

            $category=Category::findOrFail($request->category_id);
            $input['url']="/book/category/$category->id".'?ref='.$category->category_name;

        }elseif (isset($request->menu_as) && $request->menu_as=='Author'){

            $author=Author::select('id','name','link')->findOrFail($request->author_id);
            $input['url']="/book/author/$author->id".'?ref='.$author->name;
        }
        
        $validator = Validator::make($input, [
                    'name'    => 'required',
                    'url'          => 'required',
                    'icon' => 'mimes:jpeg,jpg,bmp,png'
                   // 'icon' => 'mimes:jpeg,jpg,bmp,png|dimensions:min_width=128,max_width=256'
                ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            //$input['slug']=json_encode($request->slug);
            if ($request->hasFile('icon')){
                $input['icon']=MyHelper::photoUpload($request->file('icon'),'images/menu/sub-menu/icon/',32);
                $input['big_icon']=MyHelper::photoUpload($request->file('icon'),'images/menu/big-icon/',128);
                if (file_exists($data->icon)){ unlink($data->icon);  }
                if (file_exists($data->big_icon)){ unlink($data->big_icon);  }
            }
            $data->update($input);
                
            $bug=0;
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
            }
             if($bug==0){
            return redirect()->back()->with('success','Sub menu Successfully update');
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
        
        $data=SubMenu::findOrFail($id);
       try{

           $subSubMenus=SubSubMenu::whereIn('sub_menu_id',[$id])->delete();

            $data->delete();
            $bug=0;
//           if (file_exists($data->icon)){ unlink($data->icon);  }
//           if (file_exists($data->big_icon)){ unlink($data->big_icon);  }
            $error=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
       return redirect()->back()->with('success','Successfully Deleted!');
        }elseif($bug==1451){
       return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
       return redirect()->back()->with('error','Some thing error found !');

        }
    }
}
