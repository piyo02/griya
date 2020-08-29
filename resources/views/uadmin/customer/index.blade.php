@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<section class="content-header">
    <h1 class="m-0 text-dark"><?= $page_title = ( isset( $page_title ) ) ? strtoupper( $page_title ) : ''  ?></h1>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                        <br>
                                    @endforeach
                            </div>
                        @else
                                <?= $message_alert = ( isset( $message_alert ) ) ? $message_alert : ''  ?>
                        @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-4 col-sm-4 col-xs-2">
                                <a href="<?= url('customer/'. $customer->id .'/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                            </div>
                            <div class="col-lg-6 col-md-8 col-sm-8 col-xs-10">
                                <div class="pull-right">
                                    <span class="label label-primary">&nbsp&nbsp On Process &nbsp&nbsp</span>
                                    >
                                    @if($customer->state_id >= 2)
                                        <span class="label label-success">&nbsp&nbsp Approve &nbsp&nbsp</span>
                                        >
                                        <span class="label label-danger">&nbsp&nbsp Reject &nbsp&nbsp</span>
                                    @else
                                        <a type="button" data-toggle="modal" href="#" class="label label-success" data-target="#approve">Approve</a>
                                        >
                                        <a type="button" data-toggle="modal" href="#" class="label label-danger" data-target="#cancel">Reject</a>
                                    @endif
                                    <?php
                                        $additional_dialog = ( isset( $modalApprove["additional_dialog"] ) ) ? $modalApprove["additional_dialog"] : ""  ;
                                        $value["modalId"] = 'approve';
                                        $value["modalTitle"] = $modalApprove["modalTitle"];
                                        $value["formMethod"] = $modalApprove["formMethod"];
                                        $value["formUrl"] = $modalApprove["formUrl"];
                                        $value["modalBody"] = $additional_dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $modalApprove["formFields"] ] );
                                    
                                        echo view('layouts.templates.modals.modal_no_button', $value);
                                    ?>
                                    <?php
                                        $additional_dialog = ( isset( $modalCancel["additional_dialog"] ) ) ? $modalCancel["additional_dialog"] : ""  ;
                                        $value["modalId"] = 'cancel';
                                        $value["modalTitle"] = $modalCancel["modalTitle"];
                                        $value["formMethod"] = $modalCancel["formMethod"];
                                        $value["formUrl"] = $modalCancel["formUrl"];
                                        $value["modalBody"] = $additional_dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $modalCancel["formFields"] ] );
                                    
                                        echo view('layouts.templates.modals.modal_no_button', $value);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-lg-6">
                            <h2>{{ $customer->name }}</h2>
                            <h4 style="margin-top: -5px">{{ $customer->job }}</h4>
                            <p style="margin-top: -10px; font-size: 12px; color: #797979; font-weight: bold;">{{ $customer->phone }}</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <i class="fa fa-home" style="font-size: 60px"></i> <span style="font-size: 30px">{{ $customer->block_cluster }}</span>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3"></div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                    <h4>{{ $customer->type }}</h4>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                    <h4>{{ $customer->method_payment }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p style="margin-top: 10px">Keterangan</p>
                            {{ $customer->description }}
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="container-fluid">
                            <h4 style="display: inline-block;">Sales: <b>{{ $customer->sales_name }}</b></h4> <span>( {{ $customer->fee }} )</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <ul class="timeline">
                    <li class="time-label">
                        <span class="bg-blue">
                            On Process
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-pencil bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{ date('d F Y H:i:s', strtotime($detail_order[0]->date)) }}</span>
                            <h3 class="timeline-header">Pemesanan Dibuat</h3>
                            <div class="timeline-body">
                                Pemesanan untuk unit {{$customer->block_cluster}} oleh {{$customer->name}} berhasil dilakukan pada tanggal {{date("d F Y", strtotime($customer->date))}}, sales yang menangani pemesanan ini adalah {{$customer->sales_name}} dengan code fee {{$customer->fee}}
                            </div>
                        </div>
                    </li>
                    @if( $customer->state_id == 2 )
                    <li class="time-label">
                        <span class="bg-green">
                            Approve
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-check-square-o bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{ date('d F Y H:i:s', strtotime($detail_order[1]->date)) }}</span>
                            <h3 class="timeline-header">Pemesanan di Approve</h3>
                            <div class="timeline-body">
                                {{ $detail_order[1]->description }}
                            </div>
                        </div>
                    </li>
                    @endif
                    @if( $customer->state_id == 3 )
                    <li class="time-label">
                        <span class="bg-red">
                            Reject
                        </span>
                    </li>
                    <li>
                        <i class="fa fa-remove bg-red"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{ date('d F Y H:i:s', strtotime($detail_order[1]->date)) }}</span>
                            <h3 class="timeline-header">Pemesanan di Reject</h3>
                            <div class="timeline-body">
                                {{ $detail_order[1]->description }}
                            </div>
                        </div>
                    </li>
                    @endif
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection
