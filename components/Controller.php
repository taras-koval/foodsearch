<?php

abstract class Controller
{
	protected $title;

	function __construct($title = 'Food Factory')
	{
		$this->title = $title;
	}

}

?>