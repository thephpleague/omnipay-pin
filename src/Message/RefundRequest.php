<?php

namespace Omnipay\Pin\Message;

/**
 * Pin Refund Request
 */
class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference', 'amount');

        $data = array();
        $data['amount'] = $this->getAmountInteger();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('/charges/' . $this->getTransactionReference() . '/refunds', $data);

        return $this->response = new Response($this, $httpResponse->json());
    }
}
