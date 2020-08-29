<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelSales;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

use App\Model\Sale;
use App\Model\Customer;

use App\Alert;
use Session;
use Route;
use PDF;

class SalesController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->sale_model = new Sale();
        $this->customer_model = new Customer();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $linkExportExcel['linkName']     = "Export Excel";
        $linkExportExcel['url']          = url('sales/export_excel');
        $linkExportExcel['buttonColor']  = 'success';
        $linkExportExcel = view('layouts.templates.tables.actions.link', $linkExportExcel );

        $linkExportPdf['linkName']     = "Export Pdf";
        $linkExportPdf['url']          = url('sales/export_pdf');
        $linkExportPdf['buttonColor']  = 'danger';
        $linkExportPdf = view('layouts.templates.tables.actions.link', $linkExportPdf );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Sales";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('sales.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'name' => [
                                                    'type' => 'text',
                                                    'label' => 'Nama Sales',
                                                    'placeholder' => 'Nama Sales',
                                                    'value' => '',
                                                ],
                                                'phone' => [
                                                    'type' => 'number',
                                                    'label' => 'Nomor Telepon',
                                                    'placeholder' => '0812xxx',
                                                    'value' => '',
                                                ],
                                                'street' => [
                                                    'type' => 'text',
                                                    'label' => 'Alamat',
                                                    'placeholder' => 'Jln Example',
                                                    'value' => '',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # data
        ################
        $this->data[ 'sales' ]    = $this->sale_model->getDetailSales();
        $this->data[ 'action' ]  = [
            "modal_edit" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "modalTitle"    => "Edit Role",
                "formUrl"       => url('sales'),
                "formMethod"    => "post",
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
                        'label' => 'Nama Sales',
                        'placeholder' => 'Nama Sales',
                    ],
                    'phone' => [
                        'type' => 'number',
                        'label' => 'Nomor Telepon',
                        'placeholder' => '0812xxx',
                    ],
                    'street' => [
                        'type' => 'text',
                        'label' => 'Alamat',
                        'placeholder' => 'Jln Example',
                    ],
                ],
            ],//modal_form
            "modal_delete" => [
                "modalId"       => "delete",
                "dataParam"     => "id",
                "modalTitle"    => "Hapus",
                "formUrl"       => url('sales'),
                "formMethod"    => "post",
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

        $this->data[ 'header_button' ]       = $modalCreate . ' ' . $linkExportExcel . ' ' . $linkExportPdf;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Sales';
        $this->data[ 'header' ]              = 'Daftar Sales';
        $this->data[ 'sub_header' ]          = '';
        return $this->render( 'uadmin.sales.index' );
        
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
            'phone' => 'required|string|max:15',
            'street' => 'required|string',
        ]);
        Sale::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'street' => $request->input('street'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('sales.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        Sale::find($id)->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'street' => $request->input('street'),

        ]);
        return redirect()->route('sales.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(count(Customer::where('sale_id', $id)->get()))
            return redirect()->route('sales.index')->with(['message' => Alert::setAlert( 0, "data gagal di hapus, sales ini telah menangani seorang atau beberapa pelanggan" ) ]);

        Sale::find($id)->delete();
        return redirect()->route('sales.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }

    public function export_excel() {
        return Excel::download(new exportExcelSales, 'fee-market.xlsx');
    }

    public function export_pdf() {
        $fees = $this->sale_model->getFeeMarketing();

        $pdf = PDF::loadview('uadmin/export/fee',['fees' => $fees]);
        return $pdf->download('fees-pdf');
    }
}
