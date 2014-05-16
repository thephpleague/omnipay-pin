<?php

namespace Omnipay\Pin\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Pin Response
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

    public function getCardToken()
    {
        if (isset($this->data['response']['token'])) {
            return $this->data['response']['token'];
        }
    }

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
