<?php

namespace LinkORB\Buckaroo\SOAP\Type;

/**
 * RequiredAction
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class RequiredAction
{
    public $RedirectURL;
    public $Type;
    public $Name;

    public function isRedirect()
    {
        return $this->Type == 'Redirect';
    }
}
