<?php

namespace App\Http\Controllers\U_admin;

use Illuminate\Http\Request;
use App\Exports\exportExcelCustomer;
use App\Http\Controllers\UserController;
use Maatwebsite\Excel\Facades\Excel;

use App\Model\Customer;
use App\Model\Cluster;
use App\Model\Order;
use App\Model\Sale;
use App\Model\State;

use App\Alert;
use Session;
use Route;
use PDF;

class CustomerController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->data[ 'menu_id' ] = "customer";
        $this->cluster_model = new Cluster();
        $this->customer_model = new Customer();
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

        $list_sales[] = '-- Pilih Sales --';
        $sales = Sale::get();
        foreach ($sales as $key => $sale) {
            $list_sales[$sale->id] = $sale->name;
        }

        $list_states[] = '-- Pilih Status Berkas --';
        $states = State::get();
        foreach ($states as $key => $state) {
            $list_states[$state->id] = $state->name;
        }

        $list_method = [
            '' => '-- Pilih Tipe Pembayaran',
            'Kredit' => 'Kredit',
            'Tunai' => 'Tunai',
        ];

        $list_types = [
            '' => '-- Pilih Tipe Kredit --',
            'Subsidi' => 'Subsidi',
            'Komersil' => 'Komersil',
        ];

        $list_fees = [
            '' => '-- Pilih Fee --',
            'half' => 'half',
            'full' => 'full',
        ];

        $linkCreate['linkName']    = "Tambah Pelanggan";
        $linkCreate['url']       = url('customer/create');
        $linkCreate = view('layouts.templates.tables.actions.link', $linkCreate );

        ##############
        # Export
        ##############
        $modalExportExcel['modalTitle']    = "Export Excel";
        $modalExportExcel['modalId']       = "export_excel";
        $modalExportExcel['formMethod']    = "post";
        $modalExportExcel['formUrl']       = url('customer/export_excel') ;
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
                                                'sale_id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Sales',
                                                    'options' => $list_sales
                                                ],
                                                'state_id' => [
                                                    'type' => 'select',
                                                    'label' => 'Status Berkas',
                                                    'options' => $list_states
                                                ],
                                                'method_payment' => [
                                                    'type' => 'select',
                                                    'label' => 'Metode Pembayaran',
                                                    'options' => $list_method
                                                ],
                                                'fee' => [
                                                    'type' => 'select',
                                                    'label' => 'Kode Fee',
                                                    'options' => $list_fees
                                                ],
                                                'type' => [
                                                    'type' => 'select',
                                                    'label' => 'Tipe Kredit',
                                                    'options' => $list_types
                                                ],
                                            ]] );
        $modalExportExcel = view('layouts.templates.modals.modal', $modalExportExcel );

        $modalExportPdf['modalTitle']    = "Export Pdf";
        $modalExportPdf['modalId']       = "export_pdf";
        $modalExportPdf['formMethod']    = "post";
        $modalExportPdf['formUrl']       = url('customer/export_pdf') ;
        $modalExportPdf['buttonColor']   = 'danger';
        $modalExportPdf['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => [
                                                'date' => [
                                                    'type' => 'date',
                                                    'label' => 'Tanggal Pemesanan',
                                                ],
                                                'sale_id' => [
                                                    'type' => 'select',
                                                    'label' => 'Nama Sales',
                                                    'options' => $list_sales
                                                ],
                                                'state_id' => [
                                                    'type' => 'select',
                                                    'label' => 'Status Berkas',
                                                    'options' => $list_states
                                                ],
                                                'method_payment' => [
                                                    'type' => 'select',
                                                    'label' => 'Metode Pembayaran',
                                                    'options' => $list_method
                                                ],
                                                'fee' => [
                                                    'type' => 'select',
                                                    'label' => 'Kode Fee',
                                                    'options' => $list_fees
                                                ],
                                                'type' => [
                                                    'type' => 'select',
                                                    'label' => 'Tipe Kredit',
                                                    'options' => $list_types
                                                ],
                                            ]] );
        $modalExportPdf = view('layouts.templates.modals.modal', $modalExportPdf );
        
        ################
        # data
        ################
        $table[ 'header' ]  = [ 
            'date' => 'Tanggal Pemesanan',
            'name' => 'Nama Pelanggan',
            'block_cluster' => 'Blok Kluster',
            'state_name' => 'Status Berkas',
        ];
        $table[ 'number' ]  = 1;
        $table[ 'rows' ]    = $this->customer_model->getCustomers();
        $table[ 'action' ]  = [
            "link" => [
                "modalId"       => "edit",
                "dataParam"     => "id",
                "linkName"      => "Detail",
                "url"           => url('customer'),
                "buttonColor"   => "primary",
            ],
        ];
        $table = view('layouts.templates.tables.plain_table', $table);

        $this->data[ 'header_button' ]       = $linkCreate . ' ' . $modalExportExcel . ' ' . $modalExportPdf;
        $this->data[ 'contents' ]            = $table;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Pelanggan';
        $this->data[ 'header' ]              = 'Daftar Pelanggan';
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
        $list_clusters = [];
        $clusters = $this->cluster_model->getBlockClusterNotSoldYet();
        foreach ($clusters as $key => $cluster) {
            $list_clusters[$cluster->id] = $cluster->block . $cluster->number;
        }

        $sales = Sale::get();
        $list_sales = [];
        foreach ($sales as $key => $sale) {
            $list_sales[$sale->id] = $sale->name;
        }

        $this->data['clusters']             = $list_clusters;
        $this->data['sales']                = $list_sales;
        $this->data[ 'message_alert' ]      = Session::get('message');
        $this->data[ 'url' ]                = route('customer.store');
        $this->data[ 'method' ]             = "POST";
        $this->data[ 'edit' ]               = false;
        $this->data[ 'page_title' ]         = 'Pelanggan';
        $this->data[ 'header' ]             = 'Tambah Pelanggan';
        $this->data[ 'sub_header' ]         = '';
        return $this->render( 'uadmin.customer.form' );
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
        $datetime = $request->input('date') . ' ' . $time;

        $valid = $this->validate($request, [
            'name'              => 'required|string|max:255',
            'phone'             => 'required',
            'cluster_id'        => 'required',
            'type'              => 'required',
            'job'               => 'required|string|max:255',
            'description'       => 'required|string',
        ]);
        $customer = Customer::create([
            'name'              => $request->input('name'),
            'date'              => $datetime,
            'phone'             => $request->input('phone'),
            'job'               => $request->input('job'),
            'type'              => $request->input('type'),
            'method_payment'    => $request->input('method_payment'),
            'sale_id'           => $request->input('sale_id'),
            'fee'               => $request->input('fee'),
            'cluster_id'        => $request->input('cluster_id'),
            'state_id'          => $request->input('state_id'),
            'description'       => $request->input('description'),
        ]);

        Order::create([
            'customer_id'   => $customer->id,
            'state_id'      => $customer->state_id,
            'date'          => $datetime,
            'description'   => $request->input('description'),
        ]);

        return redirect()->route('customer.index')->with(['message' => Alert::setAlert( 1, "Pemesanan berhasil di buat" ) ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modalApprove = [
            "modalId"       => "approve",
            "modalTitle"    => "Approve Pesanan",
            "formUrl"       => url('customer/'. $id .'/edit_order'),
            "formMethod"    => "post",
            "formFields"    => [
                '_method' => [
                    'type' => 'hidden',
                    'value'=> 'PUT'
                ],
                'state_id' => [
                    'type' => 'hidden',
                    'value' => 2
                ],
                'messages' => [
                    'label' => 'Pesan',
                    'type' => 'text',
                    'value' => 'Approve Pesanan Ini?',
                    'readonly' => ''
                ],
                'description' => [
                    'label' => 'Keterangan',
                    'type' => 'textarea',
                ]
            ],
        ];

        $modalCancel = [
            "modalId"       => "cancel",
            "modalTitle"    => "Cancel Pesanan",
            "formUrl"       => url('customer/'. $id .'/edit_order'),
            "formMethod"    => "post",
            "formFields"    => [
                '_method' => [
                    'type' => 'hidden',
                    'value'=> 'PUT'
                ],
                'state_id' => [
                    'type' => 'hidden',
                    'value' => 3
                ],
                'messages' => [
                    'label' => 'Pesan',
                    'type' => 'text',
                    'value' => 'Cancel Pesanan Ini?',
                    'readonly' => ''
                ],
                'description' => [
                    'label' => 'Keterangan',
                    'type' => 'textarea',
                ]
            ],
        ];

        $customer = $this->customer_model->getDetailCustomer($id);
        $detail_order = Order::where('customer_id', $id)->get();
        // dd($detail_order);

        $this->data['modalApprove'] = $modalApprove;
        $this->data['modalCancel'] = $modalCancel;
        $this->data['customer'] = $customer[0];
        $this->data['detail_order'] = $detail_order;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Pelanggan';
        return $this->render( 'uadmin.customer.index' );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $this->data['customer'] = $customer;

        $list_clusters = [];
        $clusters = $this->cluster_model->getBlockClusterNotSoldYet();
        foreach ($clusters as $key => $cluster) {
            $list_clusters[$cluster->id] = $cluster->block . $cluster->number;
        }
        $curr_cluster = Cluster::find($customer->cluster_id);
        $list_clusters[$curr_cluster->id] = $curr_cluster->block . $curr_cluster->number;

        $sales = Sale::get();
        $list_sales = [];
        foreach ($sales as $key => $sale) {
            $list_sales[$sale->id] = $sale->name;
        }

        $this->data['clusters'] = $list_clusters;
        $this->data['sales'] = $list_sales;

        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'url' ] = url('customer/' . $id);
        $this->data[ 'method' ] = "POST";
        $this->data[ 'edit' ] = true;
        $this->data[ 'message_alert' ] = Session::get('message');
        $this->data[ 'page_title' ]          = 'Pelanggan';
        $this->data[ 'header' ]              = 'Edit Pelanggan';
        $this->data[ 'sub_header' ]          = '';
        return $this->render( 'uadmin.customer.form' );
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
            'name'              => 'required|string|max:255',
            'phone'             => 'required',
            'cluster_id'        => 'required',
            'job'               => 'required|string|max:255',
            'description'       => 'required|string',
        ]);
        Customer::find($id)->update([
            'name'              => $request->input('name'),
            'phone'             => $request->input('phone'),
            'job'               => $request->input('job'),
            'type'              => $request->input('type'),
            'method_payment'    => $request->input('method_payment'),
            'sale_id'           => $request->input('sale_id'),
            'fee'               => $request->input('fee'),
            'cluster_id'        => $request->input('cluster_id'),
            'description'       => $request->input('description'),

        ]);
        return redirect()->route('customer.show', $id)->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    public function edit_order(Request $request, $id){
        Customer::find($id)->update([
            'state_id'          => $request->input('state_id'),
        ]);
        Order::create([
            'customer_id'   => $id,
            'state_id'      => $request->input('state_id'),
            'date'          => date("Y-m-d H:i:s"),
            'description'   => $request->input('description'),
        ]);
        return redirect()->route('customer.show', $id)->with(['message' => Alert::setAlert( 1, "data berhasil di update" ) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customer.index')->with(['message' => Alert::setAlert( 1, "data berhasil di hapus" ) ]);
    }

    public function export_excel(Request $request) {
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to') . ' 23:59:59';
        $sale_id = $request->input('sale_id');
        $state_id = $request->input('state_id');
        $method_payment = $request->input('method_payment');
        $fee = $request->input('fee');
        $type = $request->input('type');

        $datas = $this->customer_model->getCustomers($date_from, $date_to, $sale_id, $state_id, $method_payment, $fee, $type);
        
        $customers = [];
        foreach ($datas as $key => $data) {
            $customers[] = [
                date('d F Y', strtotime($data->date)),
                $data->name,
                $data->phone,
                $data->job,
                $data->method_payment,
                $data->type,
                $data->block_cluster,
                $data->state_name,
                $data->sales_name,
            ];
        }

        $export = new exportExcelCustomer($customers);
        return Excel::download($export, 'Customer.xlsx');
    }

    public function export_pdf(Request $request) {
        $date = $request->input('date');
        $sale_id = $request->input('sale_id');
        $state_id = $request->input('state_id');
        $method_payment = $request->input('method_payment');
        $fee = $request->input('fee');
        $type = $request->input('type');

        $customers = $this->customer_model->getCustomers($date, $sale_id, $state_id, $method_payment, $fee, $type);

        $pdf = PDF::loadview('uadmin/export/customer',['customers'=>$customers]);
        return $pdf->download('customers-pdf');
    }
}
