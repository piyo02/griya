<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelCashFlow;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

use App\Model\Account;
use App\Model\Transaction;

use App\Alert;
use Session;
use Route;
use PDF;

class AccountController extends UserController
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
        $accounts = Account::get();
        $list_account[] = '-- Pilih Rekening --';
        foreach ($accounts as $key => $account) {
            $list_account[$account->id] = $account->name;
        }
        ##############
        # Export
        ##############
        $modalExportExcel['modalTitle']    = "Export Excel";
        $modalExportExcel['modalId']       = "export_excel";
        $modalExportExcel['formMethod']    = "post";
        $modalExportExcel['formUrl']       = url('account/export_excel') ;
        $modalExportExcel['buttonColor']   = 'success';
        $modalExportExcel['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Rekening',
                                                    'options' => $list_account
                                                ],
                                            ]] );
        $modalExportExcel = view('layouts.templates.modals.modal', $modalExportExcel );

        $modalExportPdf['modalTitle']    = "Export Pdf";
        $modalExportPdf['modalId']       = "export_pdf";
        $modalExportPdf['formMethod']    = "post";
        $modalExportPdf['formUrl']       = url('account/export_pdf') ;
        $modalExportPdf['buttonColor']   = 'danger';
        $modalExportPdf['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Rekening',
                                                    'options' => $list_account
                                                ],
                                            ]] );
        $modalExportPdf = view('layouts.templates.modals.modal', $modalExportPdf );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Rekening";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('account.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'name' => [
                                                    'type' => 'text',
                                                    'label' => 'Nama Bank',
                                                    'placeholder' => 'Nama Bank',
                                                    'value' => '',
                                                ],
                                                'number' => [
                                                    'type' => 'text',
                                                    'label' => 'Nomor Rekening',
                                                    'placeholder' => 'XXXX',
                                                    'value' => '',
                                                ],
                                                'saldo' => [
                                                    'type' => 'number',
                                                    'label' => 'Saldo Awal',
                                                    'placeholder' => 'XX.XXX.XXX.XXX,00',
                                                    'value' => '',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # data
        ################
        $table[ 'header' ]  = [ 
            'name' => 'Nama Bank',
            'number' => 'Nomor Rekening',
            'saldo' => 'Saldo Awal',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = $accounts;
        $table[ 'action' ]  = [
            "modal_form" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit",
                "formUrl"       => url('account'),
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
                        'label' => 'Nama Bank',
                        'placeholder' => 'Nama Bank',
                    ],
                    'number' => [
                        'type' => 'text',
                        'label' => 'Nomor Rekening',
                        'placeholder' => 'XXXX',
                    ],
                    'saldo' => [
                        'type' => 'number',
                        'label' => 'Saldo Awal',
                        'placeholder' => 'XX.XXX.XXX.XXX,00',
                        'readonly' => ''
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('account'),
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

        $this->data[ 'message_alert' ]       = Session::get('message');
        $this->data[ 'page_title' ]          = 'Bank';
        $this->data[ 'header' ]              = 'Daftar Rekening Bank';
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
        date_default_timezone_set('Asia/Singapore');
        $this->validate($request, [
            'name'      => 'required|string|max:255',
            'number'    => 'required|string|max:50',
            'saldo'     => 'required|integer',
        ]);
        $account = Account::create([
            'name'      => $request->input('name'),
            'number'    => $request->input('number'),
            'saldo'     => $request->input('saldo')
        ]);

        Transaction::create([
            'date'                  => date('Y-m-d H:i:s'),
            'destination_acc_id'    => $account->id,
            'customer_id'           => 1,
            'type_id'               => 1,
            'total'                 => $request->input('saldo'),
            'description'           => 'Saldo Awal'
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('account.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        Account::find($id)->update([
            'name' => $request->input('name'),
            'number' => $request->input('number'),
        ]);
        return redirect()->route('account.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
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
        $message = 'Data gagal dihapus karena telah memiliki riwayat transaksi. Silahkan hapus terlebih dahulu transaksi untuk rekening ini!';
        if(count($this->transaction_model->checkTransaction($id)) == 0){
            Transaction::where('destination_acc_id', '=', $id)->delete();
            Account::find($id)->delete();
            $type = 1;
            $message = 'data berhasil di hapus';
        }
        return redirect()->route('account.index')->with(['message' => Alert::setAlert( $type, $message ) ]);
    }
    
    public function export_excel(Request $request) {
        $id = $request->input('id');
        $where = [];
        if($id)
            $where = ['accounts.id', '=', $id];

        $accounts = $this->account_model->getCurrSaldoAccount( $where );
        $transactions = $this->transaction_model->getCashFlow($id);

        $i = 1;
        foreach ($transactions as $key => $transaction) {
            $cashFlow[] = [
                $i++,
                date('d F Y H:i:s', strtotime($transaction->datetime)),
                $transaction->account_expense ? $transaction->account_expense : $transaction->customer_name,
                $transaction->account_income ? $transaction->account_income : 'Rekening Pengeluaran',
                $transaction->type_name,
                number_format($transaction->total),
                $transaction->description,
            ];
        }

        $export = new exportExcelCashFlow($accounts, $cashFlow);
        return Excel::download($export, 'Cash-Flow.xlsx');
    }

    public function export_pdf(Request $request) {
        $id = $request->input('id');
        $where = [];
        if($id)
            $where = ['accounts.id', '=', $id];

        $accounts = $this->account_model->getCurrSaldoAccount( $where );
        $transactions = $this->transaction_model->getCashFlow( $id );

        $i = 1;
        foreach ($transactions as $key => $transaction) {
            $cashFlow[] = [
                $i++,
                date('d F Y H:i:s', strtotime($transaction->datetime)),
                $transaction->account_expense ? $transaction->account_expense : $transaction->customer_name,
                $transaction->account_income ? $transaction->account_income : 'Rekening Pengeluaran',
                $transaction->type_name,
                number_format($transaction->total),
                $transaction->description,
            ];
        }
        // dd($cashFlow);

        $pdf = PDF::loadview('uadmin/export/cash_flow', ['accounts' => $accounts, 'cashFlows' => $cashFlow]);
        return $pdf->download('cash-flow-pdf');
    }
}
