<?php

namespace Omnipay\Pin\Message;

/**
 * Pin Purchase Request
 */
class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array();
        $this->getCard()->validate();

        $data['number'] = $this->getCard()->getNumber();
        $data['expiry_month'] = $this->getCard()->getExpiryMonth();
        $data['expiry_year'] = $this->getCard()->getExpiryYear();
        $data['cvc'] = $this->getCard()->getCvv();
        $data['name'] = $this->getCard()->getName();
        $data['address_line1'] = $this->getCard()->getAddress1();
        $data['address_line2'] = $this->getCard()->getAddress2();
        $data['address_city'] = $this->getCard()->getCity();
        $data['address_postcode'] = $this->getCard()->getPostcode();
        $data['address_state'] = $this->getCard()->getState();
        $data['address_country'] = $this->getCard()->getCountry();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('/cards', $data);

        return $this->response = new Response($this, $httpResponse->json());
    }
}
