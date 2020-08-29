<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelCashOut;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

use App\Model\Account;
use App\Model\Transaction;
use App\Model\Type;

use App\Alert;
use Session;
use Route;
use PDF;

class CashOutController extends UserController
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

        $types = Type::where('id', '>', 3)->get();
        $list_types[] = '-- Pilih Tipe Pengeluaran --'; 
        foreach ($types as $key => $type) {
            $list_types[$type->id] = $type->name; 
        }
        ##############
        # Export
        ##############
        $modalExportExcel['modalTitle']    = "Export Excel";
        $modalExportExcel['modalId']       = "export_excel";
        $modalExportExcel['formMethod']    = "post";
        $modalExportExcel['formUrl']       = url('cash_out/export_excel') ;
        $modalExportExcel['buttonColor']   = 'success';
        $modalExportExcel['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'date_from' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal Awal',
                                                ],
                                                'date_to' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal Akhir',
                                                ],
                                                'id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Rekening',
                                                    'options' => $list_accounts
                                                ],
                                                'type' => [
                                                    'type' => 'select',
                                                    'label' => 'Tipe Pengeluaran',
                                                    'options' => $list_types
                                                ],
                                            ]] );
        $modalExportExcel = view('layouts.templates.modals.modal', $modalExportExcel );

        $modalExportPdf['modalTitle']    = "Export Pdf";
        $modalExportPdf['modalId']       = "export_pdf";
        $modalExportPdf['formMethod']    = "post";
        $modalExportPdf['formUrl']       = url('cash_out/export_pdf') ;
        $modalExportPdf['buttonColor']   = 'danger';
        $modalExportPdf['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'date_from' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal Awal',
                                                ],
                                                'date_to' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal Akhir',
                                                ],
                                                'id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Rekening',
                                                    'options' => $list_accounts
                                                ],
                                                'type' => [
                                                    'type' => 'select',
                                                    'label' => 'Tipe Pengeluaran',
                                                    'options' => $list_types
                                                ],
                                            ]] );
        $modalExportPdf = view('layouts.templates.modals.modal', $modalExportPdf );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Kas Keluar";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('cash_out.store') ;
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
                                            'type_id' => [
                                                'type' => 'select',
                                                'label' => 'Tipe Pengeluaran',
                                                'options' => $list_types,
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
            'type_name' => 'Tipe Pengeluaran',
            'source_acc_name' => 'Rekening Pengeluaran',
            'total' => 'Jumlah',
            'description' => 'Deskripsi',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = $this->transaction_model->getCashOut();
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit",
                "formUrl"       => url('cash_out'),
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
                    'type_id' => [
                        'type' => 'select',
                        'label' => 'Tipe Pengeluaran',
                        'options' => $list_types,
                    ],
                    'total' => [
                        'type' => 'number',
                        'label' => 'Jumlah',
                        'placeholder' => 'XXXX',
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'label' => 'Keterangan',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('cash_out'),
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

        $this->data[ 'header_button' ]       = $modalCreate . ' ' . $modalExportExcel . ' ' . $modalExportPdf;
        $this->data[ 'contents' ]            = $table;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Transaksi';
        $this->data[ 'header' ]              = 'Daftar Kas Keluar';
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
            'type_id'               => 'required|min:1',
            'date'                  => 'required',
            'source_acc_id'         => 'required',
            'total'                 => 'required',
            'description'           => 'required',
        ]);
        Transaction::create([
            'type_id'               => $request->input('type_id'),
            'date'                  => $request->input('date') . ' ' . $time,
            'source_acc_id'         => $request->input('source_acc_id'),
            'total'                 => $request->input('total'),
            'description'           => $request->input('description'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('cash_out.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
            'type_id'               => 'required',
            'total'                 => 'required',
            'description'           => 'required',
        ]);
        Transaction::find($id)->update([
            'type_id'                  => $request->input('type_id'),
            'source_acc_id'         => $request->input('source_acc_id'),
            'total'                 => $request->input('total'),
            'description'           => $request->input('description'),

        ]);
        return redirect()->route('cash_out.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
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
        return redirect()->route('cash_out.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }

    public function export_excel(Request $request) {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to'   => 'required',
        ]);
        $id = $request->input('id');
        $type = $request->input('type');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to') . ' 23:59:59';
        
        $condition = [
            ['transactions.type_id', '>', 3],
            ['transactions.date', '>=', $date_from],
            ['transactions.date', '<=', $date_to]
        ];
        if($id)
            $condition[] = ['transactions.source_acc_id', '=', $id];
        if($type)
            $condition[0] = ['transactions.type_id', '=', $type];
        
        $datas = $this->transaction_model->getCashOut($condition);
        
        $cashOut = [];
        foreach ($datas as $key => $data) {
            $cashOut[] = [
                date('d F Y H:i:s', strtotime($data->datetime)),
                $data->type_name,
                $data->source_acc_name,
                number_format($data->total),
                $data->description,
            ];
        }

        $export = new exportExcelCashOut($cashOut);
        return Excel::download($export, 'Cash-Out.xlsx');
    }

    public function export_pdf(Request $request) {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to'   => 'required',
        ]);
        $id = $request->input('id');
        $type = $request->input('type');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to') . ' 23:59:59';
        
        $condition = [
            ['transactions.type_id', '>', 3],
            ['transactions.date', '>=', $date_from],
            ['transactions.date', '<=', $date_to]
        ];
        if($id)
            $condition[] = ['transactions.source_acc_id', '=', $id];
        if($type)
            $condition[0] = ['transactions.type_id', '=', $type];
        
        $cashOuts = $this->transaction_model->getCashOut($condition);
        
        $pdf = PDF::loadview('uadmin/export/cash_out',['cashOuts' => $cashOuts]);
        return $pdf->download('cashOut-pdf');
    }
}
