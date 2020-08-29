<?php
    $formMethod     = ( isset( $formMethod ) ) ? $formMethod : 'get' ;
    $formUrl        = ( isset( $formUrl ) ) ? $formUrl : '#' ;

    $formAttr        = ( isset( $formAttr ) ) ? $formAttr : '' ;

    $formAttr        .= ( isset( $blank ) ) ? 'target="_blank"' : '' ;

    $content      = ( isset( $content ) ) ? $content : '' ;
?>
 @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
                <br>
            @endforeach
    </div>
@endif
<div class="row" >
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" >
        <form action="<?= $formUrl ?>" method="<?= strtoupper( $formMethod ) ?>"  >
            @csrf
            <div class="row mb-2 ">
                <div class="col-10">
                    <?= $content ?>
                </div>
                <div class="col-2" style="margin-top:3px">
                    <button type="submit" class="btn btn-primary btn-sm"  style="margin-left: 5px;">
                        ok
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

