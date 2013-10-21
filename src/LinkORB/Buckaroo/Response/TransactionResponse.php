<?php

namespace LinkORB\Buckaroo\Response;

use LinkORB\Buckaroo\Response;

/**
 * TransactionResponse
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class TransactionResponse extends Response
{
    public $Key;
    public $Status;
    public $RequiredAction;
    public $Invoice;
    public $IsTest;
    public $Currency;
    public $AmountDebit;
    public $MutationType;
    public $StartRecurrent;
    public $Recurring;

    public function hasErrors()
    {

    }
}
