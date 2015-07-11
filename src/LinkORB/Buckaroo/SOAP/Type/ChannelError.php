<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * ChannelError
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class ChannelError extends Error
{
    /**
     * @var string
     */
    public $Service;

    /**
     * @var string
     */
    public $Action;
}
