<div class="table-responsive">
    <table id="table" class="table table-striped table-bordered table-hover  ">
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <?php foreach ( $header as $key => $value) : ?>
                    <th><?php echo $value ?></th>
                <?php endforeach; ?>
                <?php if (isset($action)) : ?>
                    <th><?php echo "Aksi" ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = (isset($number) && ($number != NULL))  ? $number : 1;
            foreach ($rows as $ind => $row) :
                ?>
                <tr>
                    <td> <?php echo $no++ ?> </td>
                    <?php foreach ($header as $key => $value) : ?>
                        <td>
                        <?php
                                $attr = "";
                                if (is_numeric($row->$key) && ($key != 'phone' && $key != 'username'))
                                    $attr = number_format($row->$key);
                                else if($key == 'date')
                                    $attr = date('d F Y', strtotime($row->$key));
                                else if($key == 'datetime')
                                    $attr = date('d F Y H:i:s', strtotime($row->$key));
                                else if(($key == 'state' && $row->$key == 'TERISI') OR ($key == 'state_name' && $row->$key == 'Approve'))
                                    $attr = '<span class="label label-success">' . $row->$key . '</span>';
                                else if(($key == 'state' && $row->$key == 'BELUM TERISI') OR ($key == 'state_name' && $row->$key == 'Reject'))
                                    $attr = '<span class="label label-danger">' . $row->$key . '</span>';
                                else if($key == 'state_name' && $row->$key == 'On Process')
                                    $attr = '<span class="label label-primary">' . $row->$key . '</span>';
                                else
                                    $attr = $row->$key;
                                
                                if( strpos( $key , '->' ) )
                                {
                                    $output = $row;
                                    $keys = explode('->', $key );
                                    $isValid = true;
                                    foreach( $keys as $key )
                                    {
                                        if( strpos( $key , '()' ) )
                                        {
                                            if( $output->{$key}() == NULL ) 
                                            {
                                                $isValid = false;
                                                break;
                                            }
                                            $output = $output->{$key}();
                                        }
                                        else
                                        {
                                            if( $output->{$key} == NULL ) 
                                            {
                                                $isValid = false;
                                                break;
                                            }
                                            $output = $output->{$key};
                                        }
                                    }
                                    if( !$isValid ) continue;

                                    $attr = $output;
                                }
                                echo $attr; 
                        ?>
                        </td>
                    <?php endforeach; ?>
                    <?php if( isset( $action ) ):?>
                        <td>
                                    <?php 
                                        foreach ( $action as $type => $value) :
                                    ?>
                                            <?php 
                                                    switch( $type )
                                                    {
                                                        case "link" :
                                                                $value["data"] = $row;
                                                                echo view('layouts.templates.tables.actions.link', $value);
                                                            break;
                                                        case "modal_delete" :
                                                                $value["modalId"] = $value["modalId"].$row->{ $value["dataParam"] };
                                                                $value["formUrl"] = $value["formUrl"]."/".$row->{ $value["dataParam"] };
                                                                $dialog = "
                                                                    <div class='alert alert-danger alert-dismissible'>
                                                                    <h5>".
                                                                        ( $message = ( isset( $value["message"] ) ) ? $value["message"] : "yakin ?" ) 
                                                                    ."</h5></div>
                                                                    ";
                                                                $value["modalBody"] = $dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $value["formFields"], "data" => $row ] );
                                                            
                                                                echo view('layouts.templates.modals.modal', $value);
                                                            break;
                                                        case "modal_form" :
                                                                $value["modalId"] = $value["modalId"].$row->{ $value["dataParam"] };
                                                                $additional_dialog = ( isset( $value["additional_dialog"] ) ) ? $value["additional_dialog"] : ""  ;
                                                                if( isset( $value["isCreateMode"] ) )
                                                                    $value["formUrl"] = $value["formUrl"];
                                                                else
                                                                    $value["formUrl"] = $value["formUrl"]."/".$row->{ $value["dataParam"] };

                                                                $value["modalBody"] = $additional_dialog.view('layouts.templates.forms.form_fields', [ "formFields" => $value["formFields"], "data" => $row ] );
                                                                echo view('layouts.templates.modals.modal', $value);
                                                            break;
                                                        case "modal_form_multipart" :
                                                                $value["data"] = $row;
                                                                $this->load->view('templates/actions/modal_form_multipart', $value ); 
                                                            break;
                                                    }
                                            ?>
                                    <?php 
                                        endforeach;
                                    ?>
                        </td>
                    <?php endif;?>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<script>
    var width = window.innerWidth;
    var element = document.getElementsByClassName('table');
    element = element[0];
    if (width <= 600) {
        element.classList.add('rg-table');
    } else {
        element.classList.remove('rg-table');
    }
</script>