<?php
    $formMethod     = ( isset( $formMethod ) ) ? $formMethod : 'get' ;
    $formUrl        = ( isset( $formUrl ) ) ? $formUrl : '#' ;

    $buttonColor    = ( isset( $buttonColor ) ) ? $buttonColor : 'primary' ;
    $buttonName     = ( isset( $buttonName ) ) ? $buttonName : 'buttonName' ;
    $modalId        = ( isset( $modalId ) ) ? $modalId : 'modalId' ;
    $modalTitle     = ( isset( $modalTitle ) ) ? $modalTitle : $buttonName ;

    $modalForm      = '<form action="'.$formUrl.'" method="'.strtoupper( $formMethod ).'"  >';

    $modalBody      = ( isset( $modalBody ) ) ? $modalBody : '' ;
    $modalFooter    = ( isset( $modalFooter ) ) ? $modalFooter : view( 'layouts.templates.modals.modal_footer' ) ;
?>
<button type="button" class="btn btn-<?= $buttonColor ?> btn-sm" data-toggle="modal" style="margin-left: 5px;" data-target="#<?= $modalId ; ?>">
    <?= $buttonName ?>
</button>

@extends('layouts.templates.modals.plain_modal')
@section('modal_id')<?= $modalId ?>@endsection

@section('modal_title')
    <?= $modalTitle ?>
@endsection

@section('form')
    <?= $modalForm ?>
    @csrf
@endsection

@section('modal_body')
    <?= $modalBody ?>
@endsection

@section('modal_footer')
    <?= $modalFooter ?>
@endsection