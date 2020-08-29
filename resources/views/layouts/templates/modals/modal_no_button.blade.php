<?php
    $formMethod     = ( isset( $formMethod ) ) ? $formMethod : 'get' ;
    $formUrl        = ( isset( $formUrl ) ) ? $formUrl : '#' ;

    $buttonColor    = ( isset( $buttonColor ) ) ? $buttonColor : 'primary' ;
    $modalId        = ( isset( $modalId ) ) ? $modalId : 'modalId' ;
    $modalTitle     = ( isset( $modalTitle ) ) ? $modalTitle : 'modalTitle' ;
    $buttonName     = ( isset( $buttonName ) ) ? $buttonName : $modalTitle ;

    $modalForm      = '<form action="'.$formUrl.'" method="'.strtoupper( $formMethod ).'"  >';

    $modalBody      = ( isset( $modalBody ) ) ? $modalBody : '' ;
    $modalFooter    = ( isset( $modalFooter ) ) ? $modalFooter : view( 'layouts.templates.modals.modal_footer' ) ;
?>

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