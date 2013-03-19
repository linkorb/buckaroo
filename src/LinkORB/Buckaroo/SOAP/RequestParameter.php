<?php

namespace LinkORB\Buckaroo\SOAP;

class RequestParameter
{
 	public $_;
 	public $Name;
 	public $Group;
	
	public function __construct($Name, $Value, $Group = null) {
		$this->Name = $Name;
		$this->_ = $Value;
		$this->Group = $Group;
	}
}
