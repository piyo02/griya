<?php

namespace App;



class Alert
{
    const SUCCESS          = 1;
	const DANGER           = 0;
	const WARNING          = 2;

	public function __construct(  )
	{

			// Do something with $params
	}

	static public function setAlert( $mode, $message )
	{
		$_mode = array(
			array(
				"label" => "Alert! ",
				"icon" => "icon fa fa-ban",
				"style" => "alert alert-danger alert-dismissible",
			),
			array(
				"label" => "Information! ",
				"icon" => "icon fa fa-globe",
				"style" => "alert alert-info alert-dismissible",
			),
			array(
				"label" => "Warning! ",
				"icon" => "icon fa fa-ban",
				"style" => "alert alert-warning alert-dismissible",
			),
		);

		return "
				<div class='".$_mode[ $mode ][ "style" ]."'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<h4><i class='".$_mode[ $mode ][ "icon" ]."'></i> ".$_mode[ $mode ][ "label" ]."</h4>".
					$message
				."</div>
				";

	}
}
