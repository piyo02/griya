<?php

namespace App\Http\Controllers\S_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

use Session;

use App\Model\Role;
use App\Model\Menu;
use App\Alert;


class MenuController extends UserController
{
    protected $menuModel;
    public function __construct()
    {
        parent::__construct();

        $this->menuModel = new Menu();
        $this->data[ 'menu_id' ] = "menus";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ################
        # table
        ################
        $table[ 'header' ]  = [ 
            'role_name' => 'Role Name',
         ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = Role::get();
        $table[ 'action' ]  = [
            "link" => [
                "dataParam"     => "id",
                "linkName"      => "Detail",
                "url"           => url('/menus_role'),
                "buttonColor"   => "primary",
            ],//link
        ];
        $table = view('layouts.templates.tables.plain_table', $table);

        $this->data[ 'contents' ]            = $table;

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'menu management';
        $this->data[ 'header' ]              = 'role';
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
    }

    /**
     * Show the form for creating a new resource.
     *
     * 
     */
    public function role( $roleId )
    {
        
        // dd( $request  );die;
        $role = Role::findOrFail($roleId);
        $this->data[ 'menus_tree' ]          = $this->menuModel->getTree( $roleId ) ;
        $this->data[ 'menu_list' ]           = $this->menuModel->getMenuList();
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Menu";
        $modalCreate['modalId']       = "createMenu";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = url('/menus') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => Menu::getFormData( $role->id ) ] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        $this->data[ 'header_button' ]       = $modalCreate;
        

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'menu management';
        $this->data[ 'header' ]              = $role->role_name;
        $this->data[ 'role' ]                 = $role;
        $this->data[ 'sub_header' ]          = '';

        return $this->render('admin.menu.index');
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
            'menu_id' => 'required',
            'name' => 'required',
            'link' => 'required',
            'list_id' => 'required',
            'icon' => 'required',
            'status' => 'required',
            'position' => 'required',
            'description' => 'required',
        ]);

        Menu::create([
            'menu_id' => $request->input('menu_id'),
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'list_id' => $request->input('list_id'),
            'icon' => $request->input('icon'),
            'status' => $request->input('status'),
            'position' => $request->input('position'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('menu_role', $request->input('role_id') )->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            'link' => 'required',
            'list_id' => 'required',
            'icon' => 'required',
            'status' => 'required',
            'position' => 'required',
            'description' => 'required',

        ]);

        Menu::find($id)->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'list_id' => $request->input('list_id'),
            'icon' => $request->input('icon'),
            'status' => $request->input('status'),
            'position' => $request->input('position'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('menu_role', $request->input('role_id') )->with(['message' => Alert::setAlert( 1, "data berhasil di edit" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id, Request $request)
    {
        $this->menuModel->deleteMenu( $id ) ; //delete its branch
        Menu::find($id)->delete();
        return redirect()->route('menu_role', $request->input('role_id') )->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }
}
