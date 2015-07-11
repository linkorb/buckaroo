<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * StatusCode
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class StatusCode
{
    /**
     * @var int
     */
    public $Code;

    /**
     * @var string
     */
    public $_;

    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->_;
    }
}
