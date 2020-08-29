@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<div class="content-header">
    <h1 class="m-0 text-dark"><?= $page_title = ( isset( $page_title ) ) ? strtoupper( $page_title ) : ''  ?></h1>
</div>
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
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <h5 class="box-title">
                                    <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?>
                                    <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                                </h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <div class="pull-right" style="margin-right: 2rem;">
                                            <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach( $sales as $sale )
            <div class="col-md-4">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header bg-black" style="background: url({{url('adminlte2/dist/img/photo1.png')}}) center center;">
                        <h3 class="widget-user-username" style="color: #cf2a0e; font-weight: bold;">{{ $sale->name }}</h3>
                        <h5 class="widget-user-desc" style="font-weight: bold; margin-top: -5px">{{ $sale->street }}</h5>
                        <h5 class="widget-user-desc">{{ $sale->phone }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{url('adminlte2/dist/img/user2-160x160.jpg')}}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $sale->total_customer }}</h5>
                                    <span class="description-text">Penjualan</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $sale->half_fee }}</h5>
                                    <span class="description-text">Half Fee</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $sale->full_fee }}</h5>
                                    <span class="description-text">Full Fee</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1"></div>
                            <div class="col-sm-5 col-md-5 col-lg-5 col-xs-5">
                                <?php
                                    $modalEdit = $action['modal_edit'];
                                    $additional_dialog = ( isset( $value["additional_dialog"] ) ) ? $value["additional_dialog"] : ""  ;
                                    $value["modalId"] = $modalEdit["modalId"].$sale->{ $modalEdit["dataParam"] };
                                    $value["modalTitle"] = $modalEdit["modalTitle"];
                                    $value["formMethod"] = $modalEdit["formMethod"];
                                    $value["formUrl"] = $modalEdit["formUrl"]."/".$sale->{ $modalEdit["dataParam"] };
                                    $value["modalBody"] = $additional_dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $modalEdit["formFields"], "data" => $sale ] );
                                
                                    echo view('layouts.templates.modals.modal_no_button', $value);
                                ?>
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" style="margin-left: 5px;" data-target="#<?= $modalEdit["modalId"].$sale->{ $modalEdit["dataParam"] } ; ?>">Edit</button>
                            </div>
                            <div class="col-sm-5 col-md-5 col-lg-5 col-xs-5">
                            <?php
                                    $modalDelete = $action['modal_delete'];
                                    $value["modalId"] = $modalDelete["modalId"].$sale->{ $modalDelete["dataParam"] };
                                    $value["modalTitle"] = $modalDelete["modalTitle"];
                                    $value["formMethod"] = $modalDelete["formMethod"];
                                    $value["formUrl"] = $modalDelete["formUrl"]."/".$sale->{ $modalDelete["dataParam"] };
                                    $dialog = "
                                        <div class='alert alert-danger alert-dismissible'>
                                        <h5>".
                                            ( $message = ( isset( $modalDelete["message"] ) ) ? $modalDelete["message"] : "yakin ingin menghapus sales ini?" ) 
                                        ."</h5></div>
                                        ";
                                    $value["modalBody"] = $dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $modalDelete["formFields"], "data" => $sale ] );
                                
                                    echo view('layouts.templates.modals.modal_no_button', $value);
                                ?>
                                <button type="button" class="pull-right btn btn-sm btn-danger" data-toggle="modal" style="margin-left: 5px;" data-target="#<?= $modalDelete["modalId"].$sale->{ $modalDelete["dataParam"] } ; ?>">X</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection
