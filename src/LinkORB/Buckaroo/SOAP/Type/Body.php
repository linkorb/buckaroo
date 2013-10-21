<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * Body
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class Body
{
    /**
     * @var string
     */
    public $Key;

    /**
     * @var Status
     */
    public $Status;

    /**
     * @var RequiredAction
     */
    public $RequiredAction;

    /**
     * Order number
     * @var string
     */
    public $Invoice;

    /**
     * Whether this is a test transaction
     * @var boolean
     */
    public $IsTest;

    /**
     * @var string
     */
    public $Currency;

    /**
     * @var float
     */
    public $AmountDebit;

    /**
     * One of: NotSet, Collecting, Processing, Informational
     * @var string
     */
    public $MutationType;

    /**
     * @var boolean
     */
    public $StartRecurrent;

    /**
     * @var boolean
     */
    public $Recurring;

    /**
     * @var RequestErrors
     */
    public $RequestErrors;

    public function hasRequiredAction()
    {
        return $this->RequiredAction !== null;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return $this->RequestErrors !== null;
    }
}
