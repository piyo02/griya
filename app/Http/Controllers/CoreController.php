<?php

namespace App\Http\Controllers;
use Auth;
use Route;
use App\Model\Menu;


class CoreController extends Controller
{
    protected $data = array();
    protected $menu;
    public function __construct()
    {
        $this->menu = new Menu();

    }
    protected function render( $view = NULL )
    {
        return view( $view, $this->data );
    }
    protected function setMenu( $roleId )
	{
        $menus                      = $this->menu->getTree( $roleId );
        if( !isset( $this->data[ 'menu_id' ] ) )
        {
            $data[ 'menu_id' ] = Route::getCurrentRoute()->uri;
        }else
            $data[ 'menu_id' ] = $this->data[ 'menu_id' ];

        $data[ 'menus' ] = $menus;
        $this->data[ 'sidebar' ]    = view( 'layouts.admin.sidebar', $data );
    }
}