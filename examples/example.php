<?php

namespace LinkORB\Buckaroo;

use LinkORB\Buckaroo;
use LinkORB\Buckaroo\SOAP;

class Example {
	static function demoRequest() {

		// Start autoloader for class files
		require_once(__DIR__ . '/../vendor/autoload.php');

		// Configuration
		$websiteKey = 'CHANGEME';
		$req = new Buckaroo\Request($websiteKey);
		$req->loadPem('private_key.pem');

		// Create the message body (actual request) 
		$TransactionRequest = new SOAP\Body();
		$TransactionRequest->Currency = 'EUR';
		$TransactionRequest->AmountDebit = 1.34;
		$TransactionRequest->Invoice = 'DNK_PHP_1';
		$TransactionRequest->Description = 'Example description for this request';
		$TransactionRequest->ReturnURL = 'http://www.linkorb.com/';
		$TransactionRequest->StartRecurrent = FALSE;

		// Specify which service / action we are calling
		$TransactionRequest->Services = new SOAP\Services();
		$TransactionRequest->Services->Service 
			= new SOAP\Service('ideal', 'Pay', 1);

		// Add parameters for this service
		$TransactionRequest->Services->Service->RequestParameter 
			= new SOAP\RequestParameter('issuer', '0031');

		// Optionally pass the client ip-address for logging
		$TransactionRequest->ClientIP = new SOAP\IPAddress('123.123.123.123');

		// Send the request to Buckaroo, and retrieve the response
		$response = $req->sendTransactionRequest($TransactionRequest);

		// Display the response:
		var_dump($response);
	}
}

Example::demoRequest();
