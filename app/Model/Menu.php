<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{
    public $timestamps = false;
    protected $menu_list = array();

    protected $fillable = [
        'id', 
        'menu_id', 
        'name', 
        'link',
        'list_id',
        'icon',
        'status',
        'position',
        'description',
    ];
    public function deleteMenu( $menuId )
    {
        $menus = $this->where( "menu_id", $menuId)->get();
        // dd( $menu[0]->menu_id );
        foreach( $menus as $menu )
        {
            $this->deleteMenu( $menu->id );
        }
        $this->where( "menu_id", $menuId)->delete();
    }
    public function getTree( $menuId )
    {
        $tree = DB::table('menus')
            ->where('menu_id', $menuId )
            ->orderBy('position', 'asc' )
            ->get();
        if( empty( $tree ) )
        {
            return array();
        }

        foreach( $tree as $branch )
        {
            $this->menu_list[] = $branch;	
            $branch->branch = $this->getTree( $branch->id );
        }
        return $tree;
    }
    public function getMenuList( )
    {	
        return $this->menu_list;
    }
    public static function getFormData( $roleId )
    {
        return  [
            'role_id' => [
                'type' => 'hidden',
				'value' => $roleId,
            ],
            'id' => [
                'type' => 'hidden',
            ],
            'menu_id' => [
                'type' => 'hidden',
				'value' => $roleId,
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Nama Menu',
            ],
            'link' => [
                'type' => 'text',
                'label' => 'Link',
                'value' => "-",
            ],
            'list_id' => [
                'type' => 'text',
                'label' => 'List ID',
                'value' => 'home',
            ],
            'icon' => [
                'type' => 'text',
                'label' => 'Icon',
				'value' => 'home',
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status',
                'options' => [
                    1 => 'Aktif',
					0 => 'Non Aktif',
                ],
                'value' => 1
            ],
            'position' => [
                'type' => 'text',
                'label' => 'Urutan Ke',
                'value' => 1
            ],
            'description' => [
                'type' => 'textarea',
                'label' => 'Deskripsi',
                'placeholder' => 'Ex. admin/member',
            ],
        ];
    }
}
