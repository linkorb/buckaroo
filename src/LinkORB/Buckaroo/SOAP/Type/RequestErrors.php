<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * RequestErrors
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class RequestErrors
{
    /**
     * @var ChannelError
     */
    public $ChannelError;

    /**
     * @var ServiceError
     */
    public $ServiceError;

    /**
     * @var ActionError
     */
    public $ActionError;

    /**
     * @var ParameterError
     */
    public $ParameterError;

    /**
     * @var CustomParameterError
     */
    public $CustomParameterError;

    public function getErrors()
    {
        $errors = array();

        if ($this->ChannelError) {
            $errors[] = $this->ChannelError;
        }

        if ($this->ServiceError) {
            $errors[] = $this->ServiceError;
        }

        if ($this->ActionError) {
            $errors[] = $this->ActionError;
        }

        if ($this->ParameterError) {
            $errors[] = $this->ParameterError;
        }

        if ($this->CustomParameterError) {
            $errors[] = $this->CustomParameterError;
        }

        return $errors;
    }
}
