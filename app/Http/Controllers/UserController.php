<?php

namespace App\Http\Controllers;
use Auth;

class UserController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function render( $view = 'layouts.templates.contents.content' )
    {
        $this->setMenu( Auth::user()->roles()->first()->id );
        return parent::render( $view );
    }
    
}