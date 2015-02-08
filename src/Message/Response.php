<?php
/**
 * Pin Response
 */

namespace Omnipay\Pin\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Pin Response
 *
 * This is the response class for all Pin REST requests.
 *
 * @see \Omnipay\Pin\Gateway
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return !isset($this->data['error']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['response']['token'])) {
            return $this->data['response']['token'];
        }
    }

    /**
     * Get Card Token
     *
     * This is used after createCard to get the credit card token to be
     * used in future transactions.
     *
     * @return string
     */
    public function getCardToken()
    {
        if (isset($this->data['response']['token'])) {
            return $this->data['response']['token'];
        }
    }

    /**
     * Get Customer Token
     *
     * This is used after createCustomer to get the customer token to be
     * used in future transactions.
     *
     * @return string
     */
    public function getCustomerToken()
    {
        if (isset($this->data['response']['token'])) {
            return $this->data['response']['token'];
        }
    }

    public function getMessage()
    {
        if ($this->isSuccessful()) {
            if (isset($this->data['response']['status_message'])) {
                return $this->data['response']['status_message'];
            } else {
                return true;
            }
        } else {
            return $this->data['error_description'];
        }
    }
}
