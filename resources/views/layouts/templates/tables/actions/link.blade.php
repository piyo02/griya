<?php
    $data_param     = ((isset($dataParam) && isset($data->$dataParam)) ? $data->$dataParam : "");
    $get            = ((isset($get)) ? $get : "");
    $buttonColor    = ( isset( $buttonColor ) ) ? $buttonColor : 'primary' ;
    $linkName       = ( isset( $linkName ) ) ? $linkName : 'linkName' ;
?>
<a href="<?php echo $url.'/' . $data_param . $get; ?>" style="margin-top:0px !important;padding-top:4px !important;padding-bottom:5px !important;" style="margin-left: 5px;" class=" btn btn-sm btn-<?= $buttonColor ?>"><?= $linkName ?></a>