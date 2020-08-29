<!-- <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{url('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-scrollbar-vertical-hidden">
        <div class="os-resize-observer-host">
            <div class="os-resize-observer observed" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer observed"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 592px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{url('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="{{ route('profiles.show', Auth::user()->id ) }}" class="d-block"><?= Auth::user()->name ?></a>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <?php
                                    // function print_menus( $datas )
                                    // {
                                    //     foreach( $datas as $data )
                                    //     {
                                    //         if( ( !$data->status )  ) continue;

                                    //         if( isset( $data->branch[0] )  )
                                    //         {
                                    //             ?>
                                    //                 <li class="nav-item has-treeview ">
                                    //                     <a id="<?php // echo $data->list_id ?>" href="#" class="nav-link ">
                                    //                     <i class="nav-icon fas fa-<?php // echo $data->icon ?>"></i>                                  
                                    //                     <p>
                                    //                         <?php // echo $data->name?>
                                    //                         <i class="right fas fa-angle-left"></i>
                                    //                     </p>
                                    //                     </a>
                                    //                     <ul class=" ml-4 nav nav-treeview">
                                    //                     <?php //
                                    //                         print_menus( $data->branch );
                                    //                     ?>
                                    //                     </ul>
                                    //                 </li>
                                    //             <?php
                                    //         }else{
                                    //             ?>
                                    //                 <li class="nav-item">
                                    //                 <a id="<?php // echo $data->list_id ?>" href="<?php // echo url( $data->link ) ?>" class="nav-link">
                                    //                     <i class="nav-icon fas fa-<?php // echo $data->icon ?>"></i>
                                    //                     <p>
                                    //                     <?php // echo $data->name?>
                                    //                     <span id="<?php // echo 'notif_'.$data->list_id ?>" class="right badge badge-danger"></span>
                                    //                     </p>
                                    //                 </a>
                                    //                 </li>
                                    //             <?php //
                                    //         }
                                    //     }
                                    // }
                                
                                    // print_menus( $menus );
                                ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
</aside> -->

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('adminlte2/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <a href="{{ route('profiles.show', Auth::user()->id ) }}"><?= Auth::user()->name ?></a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu</li>
            <?php
                function print_menus( $datas )
                {
                    foreach( $datas as $data )
                    {
                        if( ( !$data->status )  ) continue;

                        if( isset( $data->branch[0] )  )
                        {
                            ?>
                                <li class="treeview">
                                    <a id="<?php echo $data->list_id ?>" href="#">
                                        <i class="fas fa-<?php echo $data->icon ?>"></i>
                                        <span><?php echo $data->name?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="ml-4 treeview-menu">
                                        <?php
                                            print_menus( $data->branch );
                                        ?>
                                    </ul>
                                </li>
                            <?php
                        }else{ ?>
                                <li>
                                    <a id="<?php echo $data->list_id ?>" href="<?php echo url( $data->link ) ?>">
                                        <i class="fas fa-<?php echo $data->icon ?>"></i>
                                        <span>
                                            <?php echo $data->name?>
                                            <span id="<?php echo 'notif_'.$data->list_id ?>" class="right badge badge-danger"></span>
                                        </span>
                                    </a>
                                </li>
                            <?php
                        }
                    }
                }
            
                print_menus( $menus );
            ?>
        </ul>
    </section>
</aside>

<script type="text/javascript">
    function menuActive(id) {
        // console.log( id );
        id = id.trim();
        a = document.getElementById(id.trim())
        a.classList.add("active");
        b = a.parentNode.parentNode.parentNode;
        b.classList.add("menu-open");
        b.children[0].classList.add("active");
    }
    menuActive('<?= $menu_id ?>' )
</script>