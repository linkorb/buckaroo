<?php

namespace LinkORB\Buckaroo\SOAP;

class AdditionalParameter
{
 	public $_;
 	public $Name;
	
	public function __construct($Name, $Value) {
		$this->Name = $Name;
		$this->_ = $Value;
	}
}
