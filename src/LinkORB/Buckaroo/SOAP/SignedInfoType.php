<?php

namespace LinkORB\Buckaroo\SOAP;

class SignedInfoType
{
	public $CanonicalizationMethod;
	public $SignatureMethod;
	public $Reference;
	
	public function __construct() {
		$this->CanonicalizationMethod = new CanonicalizationMethodType();
		$this->CanonicalizationMethod->Algorithm = 'http://www.w3.org/2001/10/xml-exc-c14n#';
		$this->SignatureMethod = new SignatureMethodType();
		$this->SignatureMethod->Algorithm = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
	}
}
