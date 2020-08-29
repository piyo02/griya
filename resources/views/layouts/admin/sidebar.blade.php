<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('adminlte2/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <a href="{{ route('profiles.show', Auth::user()->id ) }}" style="font-size: 20px;"><?= Auth::user()->name ?></a>
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
                                        <i class="fa fa-<?php echo $data->icon ?>"></i>
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
                                        <i class="fa fa-<?php echo $data->icon ?>"></i>
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
        id = id.trim();
        a = document.getElementById(id.trim())
        a.parentNode.classList.add("active");
        b = a.parentNode.parentNode.parentNode;
        b.classList.add("menu-open");
        b.classList.add("active");
    }
    menuActive('<?= $menu_id ?>' )
</script>