<?php

namespace LinkORB\Buckaroo\SOAP;

class Transaction
{
	public $CustomParameter;
	public $AdditionalParameter;
	
	public $Key;
	public $Invoice;
	
	public function __construct( $Key = null, $Invoice = null )
	{
		$this->Key = $Key;
		$this->Invoice = $Invoice;
	}
}