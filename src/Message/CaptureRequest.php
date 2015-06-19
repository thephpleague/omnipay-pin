<?php

namespace Omnipay\Pin\Message;

/**
 * Pin Capture Request
 */
class CaptureRequest extends AbstractRequest
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
        $httpResponse = $this->sendRequest('/charges/' . $this->getTransactionReference() . '/capture', $data);

        return $this->response = new CaptureResponse($this, $httpResponse->json());
    }
}
