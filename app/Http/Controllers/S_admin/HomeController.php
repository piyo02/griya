<?php

namespace App\Http\Controllers\S_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Auth;


class HomeController extends UserController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return $this->render( 'layouts.templates.contents.content' );
    }
}