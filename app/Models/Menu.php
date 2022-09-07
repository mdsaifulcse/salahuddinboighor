<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const OPEN_NEW_TAB='Open New Tab';
    const NO_OPEN_NEW_TAB='No Open New Tab';

    const ADMIN_MENU='Menu for admin';
    const USER_MENU='Menu for user';
    const CLIENT_MENU='Menu for Client';

    protected $table='menus';
    protected $fillable=['name','name_bn','url','icon_class','icon','big_icon', 'status','slug','serial_num','menu_for','open_new_tab'];

    public function activeSubMenu(){
        return $this->hasMany(SubMenu::class,'menu_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>SubMenu::ACTIVE,'menu_for'=>SubMenu::ADMIN_MENU]);
    }
    public function activeClientSubMenu(){
        return $this->hasMany(SubMenu::class,'menu_id','id')->orderBy('serial_num','ASC')
            ->where(['status'=>SubMenu::ACTIVE,'menu_for'=>SubMenu::CLIENT_MENU]);
    }

    public function subMenu(){
        return $this->hasMany(SubMenu::class,'menu_id','id')->orderBy('serial_num','ASC');
    }

}
