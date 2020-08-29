<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelCluster;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

use App\Model\Cluster;
use App\Model\Customer;

use App\Alert;
use Session;
use Route;
use PDF;

class ClusterController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->clusterModel = new Cluster();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = [0 => '-- Pilih Status --', 1 => 'Terisi', 2 => 'Belum Terisi'];
        ##############
        # Export
        ##############
        $modalExportExcel['modalTitle']    = "Export Excel";
        $modalExportExcel['modalId']       = "export_excel";
        $modalExportExcel['formMethod']    = "post";
        $modalExportExcel['formUrl']       = url('cluster/export_excel') ;
        $modalExportExcel['buttonColor']   = 'success';
        $modalExportExcel['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'state' => [
                                                    'type' => 'select',
                                                    'label' => 'Status',
                                                    'options' => $options
                                                ],
                                            ]] );
        $modalExportExcel = view('layouts.templates.modals.modal', $modalExportExcel );

        $modalExportPdf['modalTitle']    = "Export Pdf";
        $modalExportPdf['modalId']       = "export_pdf";
        $modalExportPdf['formMethod']    = "post";
        $modalExportPdf['formUrl']       = url('cluster/export_pdf') ;
        $modalExportPdf['buttonColor']   = 'danger';
        $modalExportPdf['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'state' => [
                                                    'type' => 'select',
                                                    'label' => 'Status',
                                                    'options' => $options
                                                ],
                                            ]] );
        $modalExportPdf = view('layouts.templates.modals.modal', $modalExportPdf );
        ################
        # modal
        ################
        $modalCreate['modalTitle']    = "Tambah Cluster";
        $modalCreate['modalId']       = "create";
        $modalCreate['formMethod']    = "post";
        $modalCreate['formUrl']       = route('cluster.store') ;
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'block' => [
                                                    'type' => 'text',
                                                    'label' => 'Blok',
                                                    'placeholder' => 'Blok',
                                                    'value' => '',
                                                ],
                                                'number' => [
                                                    'type' => 'number',
                                                    'label' => 'Nomor Kluster',
                                                    'placeholder' => 'XX',
                                                    'value' => '',
                                                ],
                                        ]] );
        $modalCreate = view('layouts.templates.modals.modal', $modalCreate );
        
        ################
        # data
        ################
        $clusters = $this->clusterModel->getBlockCluster();
        foreach ($clusters as $key => $cluster) {
            $table = [];
            $table[ 'header' ]  = [ 
                'cluster' => 'Unit',
                'state' => 'Status',
            ];
            $table[ 'number' ]  = 1;
            $table[ 'rows' ]    = $cluster;

            $table[ 'action' ]  = [
                "modal_form" => [
                    "modalId"       => "edit",
                    "dataParam"     => "id",
                    "modalTitle"    => "Edit",
                    "formUrl"       => url('cluster'),
                    "formMethod"    => "post",
                    "buttonColor"   => "primary",
                    "formFields"    => [
                        '_method' => [
                            'type' => 'hidden',
                            'value'=> 'PUT'
                        ],
                        'block' => [
                            'type' => 'text',
                            'label' => 'Blok',
                            'placeholder' => 'Blok',
                        ],
                        'number' => [
                            'type' => 'number',
                            'label' => 'Nomor Kluster',
                            'placeholder' => 'XX',
                        ],
                    ],
                ],//modal_form
                "modal_delete" => [
                    "modalId"       => "delete",
                    "dataParam"     => "id",
                    "modalTitle"    => "Hapus",
                    "formUrl"       => url('cluster'),
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
            $this->data[ 'contents' ][] = [
                'key' => $key,
                'content' => $table
            ];
        }


        $this->data[ 'header_button' ]       = $modalCreate . ' ' . $modalExportExcel . ' ' . $modalExportPdf;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Daftar Blok';
        $this->data[ 'header' ]              = 'Blok';
        $this->data[ 'sub_header' ]          = '';
        return $this->render( 'uadmin.cluster.index' );
        
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
            'block' => 'required|string',
            'number' => 'required|integer',
        ]);
        Cluster::create([
            'block' => $request->input('block'),
            'number' => $request->input('number'),
        ]);

        // session()->flash('message', Alert::setAlert( 1, "data berhasil di buat" ) );

        return redirect()->route('cluster.index')->with(['message' => Alert::setAlert( 1, "data berhasil di buat" ) ]);
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
        Cluster::find($id)->update([
            'block' => $request->input('block'),
            'number' => $request->input('number'),

        ]);
        return redirect()->route('cluster.index')->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(count(Customer::where('cluster_id', $id)->get()))
            return redirect()->route('cluster.index')->with(['message' => Alert::setAlert( 0, "data gagal di hapus, unit ini sudah dipesan" ) ]);
        
        Cluster::find($id)->delete();
        return redirect()->route('cluster.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }

    public function export_excel(Request $request) {
        switch ($request->input('state')) {
            case 0:
                $datas = $this->clusterModel->getCluster();
                break;
            case 1:
                $datas = $this->clusterModel->getBlockClusterSoldOut();
                break;
            case 2:
                $datas = $this->clusterModel->getBlockClusterNotSoldYet();
                break;
        }
        $clusters = [];
        foreach ($datas as $key => $data) {
            $clusters[] = [
                $data->cluster,
                $data->state,
                $data->state == 'TERISI' ? $data->customer_name : '-'
            ];
        }
        
        $export = new exportExcelCluster($clusters);
        return Excel::download($export, 'cluster.xlsx');
    }

    public function export_pdf(Request $request) {
        switch ($request->input('state')) {
            case 0:
                $clusters = $this->clusterModel->getCluster();
                break;
            case 1:
                $clusters = $this->clusterModel->getBlockClusterSoldOut();
                break;
            case 2:
                $clusters = $this->clusterModel->getBlockClusterNotSoldYet();
                break;
        }
        $pdf = PDF::loadview('uadmin/export/cluster',['clusters' => $clusters]);
        return $pdf->download('cluster-pdf');
    }
}
