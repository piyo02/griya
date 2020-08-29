<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Model\Type;
use App\Model\Transaction;
use App\Alert;
use Session;
use Route;

class TypeController extends UserController
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
        $modalCreate['modalTitle']    = "Tambah Tipe Pengeluaran";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('type.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'name' => [
                                                    'type' => 'text',
                                                    'label' => 'Tipe Pengeluaran',
                                                    'placeholder' => 'Tipe Pengeluaran',
                                                    'value' => '',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # data
        ################
        $table[ 'header' ]  = [ 
            'name' => 'Tipe Pengeluaran',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = Type::where('id', '>', 3)->get();
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit",
                "formUrl"       => url('type'),
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
                    'name' => [
                        'type' => 'text',
                        'label' => 'Tipe Pengeluaran',
                        'placeholder' => 'Tipe Pengeluaran',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('type'),
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

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'Tipe';
        $this->data[ 'header' ]              = 'Daftar Tipe Pengeluaran';
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
            'name' => 'required|string|max:255',
        ]);
        Type::create([
            'name' => $request->input('name'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('type.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        Type::find($id)->update([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('type.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(count(Transaction::where('type_id', $id)->get()))
            return redirect()->route('type.index')->with(['message' => Alert::setAlert( 0, "data gagal di hapus, telah dibuat transaksi dengan tipe ini" ) ]);

        Type::find($id)->delete();
        return redirect()->route('type.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }
}
