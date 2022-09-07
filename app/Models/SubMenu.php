<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenu extends Model
{
    use HasFactory,SoftDeletes;


    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const OPEN_NEW_TAB='Open New Tab';
    const NO_OPEN_NEW_TAB='No Open New Tab';

    const ADMIN_MENU='Sub menu for admin';
    const USER_MENU='Sub menu for user';
    const CLIENT_MENU='Sub Menu for Client';

    protected $table='sub_menus';
    protected $fillable=['menu_id','name','name_bn','url','icon_class','icon','big_icon', 'status','slug','serial_num','menu_for','open_new_tab'];


    public function activeSubSubMenu(){
        return $this->hasMany(SubSubMenu::class,'sub_menu_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>SubSubMenu::ACTIVE,'menu_for'=>SubSubMenu::ADMIN_MENU]);
    }

    public function activeClientSubSubMenu(){
        return $this->hasMany(SubSubMenu::class,'sub_menu_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>SubSubMenu::ACTIVE,'menu_for'=>SubSubMenu::CLIENT_MENU]);
    }


    public function subSubMenu(){
        return $this->hasMany(SubSubMenu::class,'sub_menu_id','id')->orderBy('serial_num','ASC');
    }


}
