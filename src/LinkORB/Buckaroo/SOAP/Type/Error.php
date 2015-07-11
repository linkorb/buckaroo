<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * Error
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
abstract class Error
{
    /**
     * @var string
     */
    public $Name;

    /**
     * @var string
     */
    public $Error;

    /**
     * @var string
     */
    public $_;

    /**
     * Returns the error message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_;
    }

    public function __toString()
    {
        return (string) $this->getMessage();
    }
}
