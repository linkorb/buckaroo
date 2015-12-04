<?php

namespace LinkORB\Buckaroo;

use LinkORB\Buckaroo;
use LinkORB\Buckaroo\SOAP;

class Request
{

    private $soapClient = null;
    private $websiteKey = null;
    private $culture = 'nl-NL';
    private $testMode = false;
    private $channel  = 'Web';
    protected static $defaultSoapOptions = array(
        'trace' => 1,
        'classmap' => array(
            'Body' => 'LinkORB\\Buckaroo\\SOAP\\Type\\Body',
            'Status' => 'LinkORB\\Buckaroo\\SOAP\\Type\\Status',
            'RequiredAction' => 'LinkORB\\Buckaroo\\SOAP\\Type\\RequiredAction',
            'ParameterError' => 'LinkORB\\Buckaroo\\SOAP\\Type\\ParameterError',
            'CustomParameterError' => 'LinkORB\\Buckaroo\\SOAP\\Type\\CustomParameterError',
            'ServiceError' => 'LinkORB\\Buckaroo\\SOAP\\Type\\ServiceError',
            'ActionError' => 'LinkORB\\Buckaroo\\SOAP\\Type\\ActionError',
            'ChannelError' => 'LinkORB\\Buckaroo\\SOAP\\Type\\ChannelError',
            'RequestErrors' => 'LinkORB\\Buckaroo\\SOAP\\Type\\RequestErrors',
            'StatusCode' => 'LinkORB\\Buckaroo\\SOAP\\Type\\StatusCode',
            'StatusSubCode' => 'LinkORB\\Buckaroo\\SOAP\\Type\\StatusCode',
        )
    );

    public function __construct($websiteKey = null, $testMode = false, array $soapOptions = array())
    {
        
        $this->websiteKey = $websiteKey;
        $this->testMode = $testMode;

		$wsdl_url = "https://checkout.buckaroo.nl/soap/soap.svc?wsdl";
		$this->soapClient = new SoapClientWSSEC($wsdl_url, array_merge(static::$defaultSoapOptions, $soapOptions));
	}

    public function loadPem($filename)
    {
        $this->soapClient->loadPem($filename);
    }

    public function setChannel($channel)
    {
	$this->channel = $channel;
    }

    public function sendRequest($TransactionRequest, $type)
    {

        if (!$this->websiteKey) {
            throw new \InvalidArgumentException('websiteKey not defined');
        }

        // Envelope and wrapper stuff
        $Header = new Buckaroo\SOAP\Header();
        $Header->MessageControlBlock = new Buckaroo\SOAP\MessageControlBlock();
        $Header->MessageControlBlock->Id = '_control';
        $Header->MessageControlBlock->WebsiteKey = $this->websiteKey;
        $Header->MessageControlBlock->Culture = $this->culture;

        $Header->MessageControlBlock->TimeStamp = time();
        $Header->MessageControlBlock->Channel = $this->channel;
        $Header->Security = new SOAP\SecurityType();
        $Header->Security->Signature = new SOAP\SignatureType();
        $Header->Security->Signature->SignedInfo = new SOAP\SignedInfoType();

        $Reference = new SOAP\ReferenceType();
        $Reference->URI = '#_body';
        $Transform = new SOAP\TransformType();
        $Transform->Algorithm = 'http://www.w3.org/2001/10/xml-exc-c14n#';
        $Reference->Transforms=array($Transform);

        $Reference->DigestMethod = new SOAP\DigestMethodType();
        $Reference->DigestMethod->Algorithm = 'http://www.w3.org/2000/09/xmldsig#sha1';
        $Reference->DigestValue = '';

        $Transform2 = new SOAP\TransformType();
        $Transform2->Algorithm = 'http://www.w3.org/2001/10/xml-exc-c14n#';
        $ReferenceControl = new SOAP\ReferenceType();
        $ReferenceControl->URI = '#_control';
        $ReferenceControl->DigestMethod = new SOAP\DigestMethodType();
        $ReferenceControl->DigestMethod->Algorithm = 'http://www.w3.org/2000/09/xmldsig#sha1';
        $ReferenceControl->DigestValue = '';
        $ReferenceControl->Transforms=array($Transform2);

        $Header->Security->Signature->SignedInfo->Reference = array($Reference,$ReferenceControl);
        $Header->Security->Signature->SignatureValue = '';

        $soapHeaders[] = new \SOAPHeader('https://checkout.buckaroo.nl/PaymentEngine/', 'MessageControlBlock', $Header->MessageControlBlock);
        $soapHeaders[] = new \SOAPHeader('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Security', $Header->Security);
        $this->soapClient->__setSoapHeaders($soapHeaders);
        
		if ($this->testMode) {
			$this->soapClient->__SetLocation('https://testcheckout.buckaroo.nl/soap/');
		} else {
			$this->soapClient->__SetLocation('https://checkout.buckaroo.nl/soap/');
		}

        $return = [];
		switch($type) {
			case 'invoiceinfo':
                $return['result'] = $this->soapClient->InvoiceInfo($TransactionRequest);
				break;
			case 'transaction':
				$return['result'] = $this->soapClient->TransactionRequest($TransactionRequest);
				break;
            case 'transactionstatus':
                $return['result'] = $this->soapClient->TransactionStatus($TransactionRequest);
                break;
			case 'refundinfo':
                $return['result'] = $this->soapClient->RefundInfo($TransactionRequest);
				break;
		}

		$return['response'] = $this->soapClient->__getLastResponse();
		$return['request']  = $this->soapClient->__getLastRequest();
		return $return;
	}

    /**
     * @param boolean $testMode
     * @return Request
     */
    public function setTestMode($testMode) 
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTestMode() 
    {
        return $this->testMode;
    }

    /**
     * @param string $culture
     * @return Request
     */
    public function setCulture($culture)
    {
        $this->culture = $culture;

        return $this;
    }

    /**
     * @return string
     */
    public function getCulture() 
    {
        return $this->culture;
    }
}
