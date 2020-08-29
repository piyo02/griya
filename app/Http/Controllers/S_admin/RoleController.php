<?php

namespace App\Http\Controllers\S_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Model\Role;
use App\Alert;
use Session;
use Route;

class RoleController extends UserController
{
    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Role";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('roles.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'role_name' => [
                                                    'type' => 'text',
                                                    'label' => 'Role Name',
                                                    'placeholder' => 'Ex. admin/member',
                                                    'value' => '',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # table
        ################
        $table[ 'header' ]  = [ 
            'role_name' => 'Role Name',
         ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = Role::get();
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit Role",
                "formUrl"       => url('roles'),
                "formMethod"    => "post",
                "buttonColor"   => "primary",
                "formFields"    => [
                    '_method' => [
                        'type' => 'hidden',
                        'value'=> 'PUT'
                    ],
                    'id' => [
                        'type' => 'hidden',
                    ],
                    'role_name' => [
                        'type' => 'text',
                        'label' => 'Role Name',
                        'placeholder' => 'Ex. admin/member',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('roles'),
                "formMethod"    => "post",
                "buttonColor"   => "danger",
                "formFields"    => [
                    '_method' => [
                        'type' => 'hidden',
                        'value'=> 'DELETE'
                    ],
                    'id' => [
                        'type' => 'hidden',
                    ],
                ],
            ],//modal_delete
        ];
        $table = view('layouts.templates.tables.plain_table', $table);

        $this->data[ 'header_button' ]       = $modalCreate;
        $this->data[ 'contents' ]            = $table;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'role';
        $this->data[ 'header' ]              = 'role';
        $this->data[ 'sub_header' ]          = '';
        return $this->render(  );
        
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
        $this->validate($request, [
            'role_name' => 'required|string|max:255',
        ]);
        Role::create([
            'role_name' => $request->input('role_name'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('roles.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        //
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
        Role::find($id)->update([
            'role_name' => $request->input('role_name'),

        ]);
        return redirect()->route('roles.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('roles.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }
}
