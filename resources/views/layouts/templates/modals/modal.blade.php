<?php
    $Enctype = [
        'none' => ' ',
        'multipart' => 'enctype="multipart/form-data" '
    ];
    $formMethod     = ( isset( $formMethod ) ) ? $formMethod : 'get' ;
    $formUrl        = ( isset( $formUrl ) ) ? $formUrl : '#' ;
    $formEnctype        = ( isset( $formEnctype ) ) ? $formEnctype : 'none' ;

    $buttonColor    = ( isset( $buttonColor ) ) ? $buttonColor : 'primary' ;
    $modalId        = ( isset( $modalId ) ) ? $modalId : 'modalId' ;
    $modalTitle     = ( isset( $modalTitle ) ) ? $modalTitle : 'modalTitle' ;
    $buttonName     = ( isset( $buttonName ) ) ? $buttonName : $modalTitle ;

    $modalForm      = '<form action="'.$formUrl.'" method="'.strtoupper( $formMethod ).'" '.$Enctype[ $formEnctype ].'  >';

    $modalBody      = ( isset( $modalBody ) ) ? $modalBody : '' ;
    $modalFooter    = ( isset( $modalFooter ) ) ? $modalFooter : view( 'layouts.templates.modals.modal_footer' ) ;
?>
<button type="button" class="btn btn-<?= $buttonColor ?> btn-sm" data-toggle="modal" style="margin-left: 5px;" data-target="#<?= $modalId ; ?>">
    <?= $buttonName ?>
</button>

@extends('layouts.templates.modals.plain_modal')
@section('modal_id')<?= $modalId ?>@overwrite

@section('modal_title')
    <?= $modalTitle ?>
@overwrite

@section('form')
    <?= $modalForm ?>
    @csrf
@overwrite

@section('modal_body')
    <?= $modalBody ?>
@overwrite

@section('modal_footer')
    <?= $modalFooter ?>
@overwrite