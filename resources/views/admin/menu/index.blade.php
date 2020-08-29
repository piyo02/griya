@extends('layouts.admin.app')
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
                                <?= $message_alert = ( isset( $message_alert ) ) ? $message_alert : ''  ?>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                                <br>
                                            @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <h5 class="box-title">
                                        <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?>
                                        <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                                    </h5>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <div class="pull-right" style="margin-rigth: 2rem;">
                                                <?php echo (isset($header_button)) ? $header_button : '';  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div style="  " >
                                <div class="tree" >
                                    <ol>
                                        <?php
                                            function print_tree( $datas )
                                            {
                                                foreach( $datas as $data )
                                                {       
                                                        echo  '<li>';
                                                                echo '<a href="#">'.$data->name.'</a>';
                                                            ?>
                                                            <button class="btn btn-white btn-info btn-bold btn-xs" data-toggle="modal" data-target="#add_menu_<?php echo $data->id ?>">
                                                                + 
                                                            </button>
                                                            <button class="btn btn-white btn-info btn-bold btn-xs" data-toggle="modal" data-target="#edit_menu_<?php echo $data->id ?>">
                                                                Edit
                                                            </button>
                                                            <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#delete_menu_<?php echo $data->id ?>">
                                                                X
                                                            </button>
                                                            <?php echo $data->description?>
                                                            <?php
                                                            echo "<ol>";
                                                                print_tree( $data->branch );
                                                            echo "</ol>";
                                                        echo  '</li>';
                                                }
                                            };
                                            print_tree( $menus_tree );
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <?php
    // $menu_list =[];
    foreach( $menu_list as $menu )
    {
        // dd( $menu ); die;
        $formFields = [
            'role_id' => [
                'type' => 'hidden',
				'value' => $role->id,
            ],
            'id' => [
                'type' => 'hidden',
            ],
            'menu_id' => [
                'type' => 'hidden',
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Nama Menu',
            ],
            'link' => [
                'type' => 'text',
                'label' => 'Link',
            ],
            'list_id' => [
                'type' => 'text',
                'label' => 'List ID',
            ],
            'icon' => [
                'type' => 'text',
                'label' => 'Icon',
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status',
                'options' => [
                    1 => 'Aktif',
					0 => 'Non Aktif',
                ],
            ],
            'position' => [
                'type' => 'text',
                'label' => 'Urutan Ke',
            ],
            'description' => [
                'type' => 'textarea',
                'label' => 'Deskripsi',
                'placeholder' => 'Ex. admin/member',
            ],
        ];
        $modalCreate = array(
          "modalTitle" => "Tambah Child Menu",
          "modalId" => "add_menu_".$menu->id,
          "formMethod" => "post",
          "formUrl" => url('menus') ,
        );
        $modalCreate['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields, 'data' => ( object ) [ 'menu_id' => $menu->id ] ] );
        echo view('layouts.templates.modals.modal_no_button', $modalCreate );

        $modalEdit = array(
            "modalTitle" => "Edit Menu",
            "modalId" => "edit_menu_".$menu->id,
            "formMethod" => "post",
            "formUrl" => url('menus')."/".$menu->id,
        );
        $formFields["_method"] = [
            'type' => 'hidden',
            'value' => "PUT"
        ];
        $modalEdit['modalBody']     = view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields, 'data' => $menu ] );
        echo view('layouts.templates.modals.modal_no_button', $modalEdit );

        $formFields = [
            '_method' => [
                'type' => 'hidden',
                'value'=> 'DELETE'
            ],
            'role_id' => [
                'type' => 'hidden',
				'value' => $role->id,
            ],
            'id' => [
                'type' => 'hidden',
            ],
        ];
        $modalDelete = array(
            "modalTitle" => "Hapus",
            "modalId" => "delete_menu_".$menu->id,
            "formMethod" => "post",
            "formUrl" => url('menus')."/".$menu->id,
        );
        $dialog = "
            <div class='alert alert-danger alert-dismissible'>
            <h5>".
                "anda yakin menghapus .". $menu->name ." ?"
            ."</h5></div>
        ";
        $modalDelete['modalBody']     = $dialog.view('layouts.templates.forms.form_fields', [ 'formFields' => $formFields, 'data' => $menu ] );
        echo view('layouts.templates.modals.modal_no_button', $modalDelete );
    }
  ?>
@endsection
