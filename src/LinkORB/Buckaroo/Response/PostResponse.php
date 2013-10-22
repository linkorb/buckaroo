<?php

namespace LinkORB\Buckaroo\Response;

use LinkORB\Buckaroo\Response;
use LinkORB\Buckaroo\SignatureComposer\SignatureComposer;

/**
 * PostResponse can be used to verify and read post and push responses from Buckaroo.
 *
 * <code>
 * use LinkORB\Buckaroo\Response\PostResponse;
 * use LinkORB\Buckaroo\SignatureComposer\Sha1Composer;
 *
 * $response = new PostResponse($_POST);
 * if ($response->isValid(new Sha1Composer('YourSecretKey')) {
 *     var_dump($response->getParameter('BRQ_STATUSCODE'));
 * }
 * </code>
 *
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class PostResponse implements \ArrayAccess
{
    const SIGNATURE_FIELD = 'BRQ_SIGNATURE';

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var array
     */
    protected $upperParameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $upperParameters = array_change_key_case($parameters, CASE_UPPER);
        $this->signature = $this->getSignature($upperParameters);
        unset($parameters[static::SIGNATURE_FIELD], $parameters[strtolower(static::SIGNATURE_FIELD)]);

        $this->parameters = $parameters;
        $this->upperParameters = array_change_key_case($parameters, CASE_UPPER);
    }

    /**
     * Returns whether this response is valid.
     *
     * @param SignatureComposer $composer
     * @return bool
     */
    public function isValid(SignatureComposer $composer)
    {
        return $this->signature === $composer->compose($this->parameters);
    }

    /**
     * Returns the value for the given key.
     *
     * @param string $key
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getParameter($key)
    {
        $key = strtoupper($key);

        if (! isset($this->upperParameters[$key])) {
            throw new \InvalidArgumentException('Parameter ' . $key . ' does not exist.');
        }

        return $this->upperParameters[$key];
    }

    /**
     * Returns whether the parameter exists.
     * @param string $key
     * @return bool
     */
    public function hasParameter($key)
    {
        return isset($this->upperParameters[strtoupper($key)]);
    }

    public function offsetExists($offset)
    {
        return isset($this->upperParameters[strtoupper($offset)]);
    }

    public function offsetGet($offset)
    {
        return $this->getParameter($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('It is not possible to change the parameters.');
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException('It is not possible to change the parameters.');
    }

    /**
     * Extract the sign field.
     *
     * @param array $parameters
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function getSignature(array $parameters)
    {
        if (! array_key_exists(static::SIGNATURE_FIELD, $parameters) || $parameters[static::SIGNATURE_FIELD] == '') {
            throw new \InvalidArgumentException(
                sprintf('Sign key (%s) not present in parameters.', static::SIGNATURE_FIELD)
            );
        }
        return $parameters[static::SIGNATURE_FIELD];
    }
}
