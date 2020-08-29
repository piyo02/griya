<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Auth;
use App\Model\Role;
use App\Model\PriceList;

use App\Alert;
use App\User;
use Session;

class PriceListController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->data[ 'page_title' ]          = 'PRICE LIST';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd( PriceList::all() );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Price List";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('pricelists.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'name' => [
                                                    'type' => 'text',
                                                    'label' => 'Produk',
                                                    'placeholder' => 'Ex. Plastik',
                                                ],
                                                'price' => [
                                                    'type' => 'number',
                                                    'label' => 'Harga',
                                                ],
                                                'unit' => [
                                                    'type' => 'text',
                                                    'label' => 'Satuan',
                                                    'placeholder' => 'Ex. Kg',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # table
        ################
        $table[ 'header' ]  = [ 
            'name'  => 'Produk',
            'price' => 'Harga',
            'unit'  => 'Satuan',
         ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = PriceList::all() ;
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit Price List",
                "formUrl"       => url('pricelists'),
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
                        'label' => 'Produk',
                        'placeholder' => 'Ex. Plastik',
                    ],
                    'price' => [
                        'type' => 'number',
                        'label' => 'Harga',
                    ],
                    'unit' => [
                        'type' => 'text',
                        'label' => 'Satuan',
                        'placeholder' => 'Ex. Kg',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('pricelists'),
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
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit'  => 'required|string|max:255',

        ]);
        PriceList::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('pricelists.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        $this->validate($request, [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'unit'  => 'required|string|max:255',

        ]);
        PriceList::find($id)->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
        ]);
        return redirect()->route('pricelists.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PriceList::find($id)->delete();
        return redirect()->route('pricelists.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }
}
