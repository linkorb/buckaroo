<?php

namespace LinkORB\Buckaroo\SignatureComposer;

/**
 * SignComposer
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
interface SignatureComposer
{
    /**
     * Compose sign string based on Buckaroo response parameters
     * @param array $parameters
     * @return string
     */
    public function compose(array $parameters);
}
