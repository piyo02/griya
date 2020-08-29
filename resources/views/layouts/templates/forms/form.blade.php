<?php
    $Enctype = [
        'none' => ' ',
        'multipart' => 'enctype="multipart/form-data" '
    ];

    $formMethod     = ( isset( $formMethod ) ) ? $formMethod : 'get' ;
    $formUrl        = ( isset( $formUrl ) ) ? $formUrl : '#' ;

    $formAttr        = ( isset( $formAttr ) ) ? $formAttr : '' ;

    $formAttr        .= ( isset( $blank ) ) ? 'target="_blank"' : '' ;

    $formEnctype        = ( isset( $formEnctype ) ) ? $formEnctype : 'none' ;


    $content      = ( isset( $content ) ) ? $content : '' ;
?>
<form action="<?= $formUrl ?>" method="<?= strtoupper( $formMethod ) ?>" <?= $Enctype[ $formEnctype ] ?>  >
    @csrf
    <?= $content ?>
    <br>
    <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
        Simpan
    </button>
</form>
