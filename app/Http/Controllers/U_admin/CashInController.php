<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelCashIn;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

use App\Model\Account;
use App\Model\Customer;

use App\Model\Transaction;
use App\Alert;
use Session;
use Route;
use PDF;

class CashInController extends UserController
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
        
        $customers = Customer::where('state_id', '<', 3)->get();
        $list_customers[] = '-- Pilih Pelanggan --';
        $list_customers[1] = 'Bukan Pelanggan';
        foreach ($customers as $key => $customer) {
            $list_customers[$customer->id] = $customer->name; 
        }

        $accounts = $this->account_model->getCurrSaldoAccount();
        $list_accounts[] = '-- Pilih Rekening --'; 
        foreach ($accounts as $key => $account) {
            $list_accounts[$account->id] = $account->name . ' ( Rp. ' . number_format($account->saldo) . ' )'; 
        }
        ##############
        # Export
        ##############
        $modalExportExcel['modalTitle']    = "Export Excel";
        $modalExportExcel['modalId']       = "export_excel";
        $modalExportExcel['formMethod']    = "post";
        $modalExportExcel['formUrl']       = url('cash_in/export_excel') ;
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
                                            ]] );
        $modalExportExcel = view('layouts.templates.modals.modal', $modalExportExcel );

        $modalExportPdf['modalTitle']    = "Export Pdf";
        $modalExportPdf['modalId']       = "export_pdf";
        $modalExportPdf['formMethod']    = "post";
        $modalExportPdf['formUrl']       = url('cash_in/export_pdf') ;
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
                                            ]] );
        $modalExportPdf = view('layouts.templates.modals.modal', $modalExportPdf );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Kas Masuk";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('cash_in.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'date' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal',
                                                ],
                                                'time' => [
                                                    'type' => 'time',
                                                    'label' => 'Waktu',
                                                ],
                                                'customer_id' => [
                                                    'type' => 'select',
                                                    'label' => 'Pelanggan',
                                                    'options' => $list_customers,
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
            'customer_name' => 'Pelanggan',
            'destination_acc_name' => 'Rekening Tujuan',
            'total' => 'Jumlah',
            'description' => 'Deskripsi',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = $this->transaction_model->getCashIn();
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit",
                "formUrl"       => url('cash_in'),
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
                    'customer_id' => [
                        'type' => 'select',
                        'label' => 'Pelanggan',
                        'options' => $list_customers,
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
                "formUrl"       => url('cash_in'),
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
        $this->data[ 'header' ]              = 'Daftar Kas Masuk';
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
            'customer_id'           => 'required',
            'destination_acc_id'    => 'required',
            'date'                  => 'required',
            'description'           => 'required',
            'total'                 => 'required',
        ]);
        Transaction::create([
            'customer_id'           => $request->input('customer_id'),
            'date'                  => $request->input('date') . ' ' . $time,
            'description'           => $request->input('description'),
            'destination_acc_id'    => $request->input('destination_acc_id'),
            'total'                 => $request->input('total'),
            'type_id'               => 2,
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('cash_in.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
            'customer_id'           => 'required',
            'destination_acc_id'    => 'required',
            'description'           => 'required',
            'total'                 => 'required',
        ]);
        Transaction::find($id)->update([
            'customer_id'           => $request->input('customer_id'),
            'destination_acc_id'    => $request->input('destination_acc_id'),
            'total'                 => $request->input('total'),
            'description'           => $request->input('description'),

        ]);
        return redirect()->route('cash_in.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = 0;
        $message = "data gagal di hapus, transaksi ini adalah pemasukan saldo awal. Silahkan hapus rekening untuk menghapus transaksi ini";
        if(Transaction::find($id)->type_id != 1){
            Transaction::find($id)->delete();
            $message = "data berhasil di hapus";
            $type = 1;
        }
        return redirect()->route('cash_in.index')->with(['message' => Alert::setAlert( $type, $message ) ]);
    }

    public function export_excel(Request $request) {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to'   => 'required',
        ]);
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to') . ' 23:59:59';
        $id = $request->input('id');
        
        $condition = [
            ['transactions.type_id', '<=', 2],
            ['transactions.date', '>=', $date_from],
            ['transactions.date', '<=', $date_to]
        ];
        if($id)
            $condition[] = ['transactions.destionation_acc_id', '=', $id];
        
        $datas = $this->transaction_model->getCashIn($condition);

        $cashIn = [];
        foreach ($datas as $key => $data) {
            $cashIn[] = [
                date('d F Y H:i:s', strtotime($data->datetime)),
                $data->customer_name,
                $data->destination_acc_name,
                number_format($data->total),
                $data->description,
            ];
        }

        $export = new exportExcelCashIn($cashIn);
        return Excel::download($export, 'Cash-In.xlsx');
    }

    public function export_pdf(Request $request) {
        $this->validate($request, [
            'date_from' => 'required',
            'date_to'   => 'required',
        ]);
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to') . ' 23:59:59';
        $id = $request->input('id');
        
        $condition = [
            ['transactions.type_id', '<=', 2],
            ['transactions.date', '>=', $date_from],
            ['transactions.date', '<=', $date_to]
        ];
        if($id)
            $condition[] = ['transactions.destionation_acc_id', '=', $id];
        
        $cashIns = $this->transaction_model->getCashIn($condition);

        $pdf = PDF::loadview('uadmin/export/cash_in',['cashIns' => $cashIns]);
        return $pdf->download('cashIn-pdf');
    }
}
