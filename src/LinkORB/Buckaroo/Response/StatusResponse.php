<?php

namespace LinkORB\Buckaroo\Response;

/**
 * StatusResponse.
 *
 * @see PostResponse
 * @author  Joris van de Sande <joris.van.de.sande@freshheads.com>
 */
class StatusResponse extends PostResponse
{
    const PENDING_INPUT = 790;
    const PENDING_PROCESSING = 791;
    const AWAITING_CUSTOMER = 792;
    const SUCCESS = 190;
    const FAILED = 490;
    const VALIDATION_FAILURE = 491;
    const TECHNICAL_FAILURE = 492;
    const CANCELLED_BY_USER = 890;
    const CANCELLED_BY_MERCHANT = 891;
    const REJECTED = 690;

    /**
     * @return string
     */
    public function getTransactionKey()
    {
        return $this->getParameter('brq_transactions');
    }

    /**
     * @return string
     */
    public function getPayment()
    {
        return $this->getParameter('brq_payment');
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return (int) $this->getParameter('brq_statuscode');
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return $this->hasParameter('brq_test') && $this->getParameter('brq_test') === 'true';
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return new \DateTime($this->getParameter('brq_timestamp'));
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->getPayment('brq_invoicenumber');
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->getStatusCode() == static::SUCCESS;
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return ! $this->isPending();
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return in_array(
            $this->getStatusCode(),
            array(static::PENDING_INPUT, static::PENDING_PROCESSING, static::AWAITING_CUSTOMER)
        );
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return in_array(
            $this->getStatusCode(),
            array(static::CANCELLED_BY_MERCHANT, static::CANCELLED_BY_USER)
        );
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return in_array(
            $this->getStatusCode(),
            array(static::FAILED, static::TECHNICAL_FAILURE, static::VALIDATION_FAILURE)
        );
    }
}
