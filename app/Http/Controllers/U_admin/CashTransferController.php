<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Model\Account;
use App\Model\Transaction;
use App\Alert;
use Session;
use Route;

class CashTransferController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->account_model = new Account();
        $this->transaction_model = new Transaction();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = $this->account_model->getCurrSaldoAccount();
        $list_accounts[] = '-- Pilih Rekening --'; 
        foreach ($accounts as $key => $account) {
            $list_accounts[$account->id] = $account->name . ' ( Rp. ' . number_format($account->saldo) . ' )'; 
        }
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Buat Kas Transfer";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('cash_transfer.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                            'date' => [
                                                'type' => 'date',
                                                'label' => 'Tanggal',
                                            ],
                                            'time' => [
                                                'type' => 'time',
                                                'label' => 'Waktu',
                                            ],
                                            'source_acc_id' => [
                                                'type' => 'select',
                                                'label' => 'Rekening Sumber',
                                                'options' => $list_accounts,
                                            ],
                                            'destination_acc_id' => [
                                                'type' => 'select',
                                                'label' => 'Rekening Tujuan',
                                                'options' => $list_accounts,
                                            ],
                                            'total' => [
                                                'type' => 'number',
                                                'label' => 'Jumlah',
                                                'placeholder' => 'XXXX',
                                            ],
                                            'description' => [
                                                'type' => 'textarea',
                                                'label' => 'Keterangan',
                                                'value' => '-',
                                            ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # data
        ################
        $table[ 'header' ]  = [ 
            'datetime' => 'Tanggal',
            'source_acc_name' => 'Rekening Sumber',
            'destination_acc_name' => 'Rekening Tujuan',
            'total' => 'Jumlah',
            'description' => 'Deskripsi',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = $this->transaction_model->getCashTransfer();
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit",
                "formUrl"       => url('cash_transfer'),
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
                    'source_acc_id' => [
                        'type' => 'select',
                        'label' => 'Rekening Sumber',
                        'options' => $list_accounts,
                    ],
                    'destination_acc_id' => [
                        'type' => 'select',
                        'label' => 'Rekening Tujuan',
                        'options' => $list_accounts,
                    ],
                    'total' => [
                        'type' => 'number',
                        'label' => 'Jumlah',
                        'placeholder' => 'XXXX',
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'label' => 'Keterangan',
                        'value' => '-',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('cash_transfer'),
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
        $this->data[ 'page_title' ]          = 'Transaksi';
        $this->data[ 'header' ]              = 'Daftar Kas Transfer';
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
        $time = date('H:i:s', strtotime($request->input('time')));
        $this->validate($request, [
            'source_acc_id'         => 'required',
            'date'                  => 'required',
            'destination_acc_id'    => 'required',
            'total'                 => 'required',
            'description'           => 'required',
        ]);
        Transaction::create([
            'source_acc_id'         => $request->input('source_acc_id'),
            'destination_acc_id'    => $request->input('destination_acc_id'),
            'date'                  => $request->input('date') . ' ' . $time,
            'type_id'               => 3,
            'total'                 => $request->input('total'),
            'description'           => $request->input('description'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('cash_transfer.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
            'source_acc_id'         => 'required',
            'destination_acc_id'    => 'required',
            'total'                 => 'required',
            'description'           => 'required',
        ]);
        Transaction::find($id)->update([
            'source_acc_id'         => $request->input('source_acc_id'),
            'destination_acc_id'    => $request->input('destination_acc_id'),
            'type_id'               => 3,
            'total'                 => $request->input('total'),
            'description'           => $request->input('description'),

        ]);
        return redirect()->route('cash_transfer.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::find($id)->delete();
        return redirect()->route('cash_transfer.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }
}
