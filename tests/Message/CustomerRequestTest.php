<?php

namespace Omnipay\Pin\Message;

use Omnipay\Tests\TestCase;

class CustomerRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CustomerRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'email' => 'roland@pin.net.au',
                'card' => $this->getValidCard(),
            )
        );
    }

    public function testDataWithCardToken()
    {
        $this->request->setToken('card_abc');
        $data = $this->request->getData();

        $this->assertSame('card_abc', $data['card_token']);
    }

    public function testDataWithCard()
    {
        $card = $this->getValidCard();
        $this->request->setCard($card);
        $data = $this->request->getData();

        $this->assertSame($card['number'], $data['card']['number']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CustomerSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('cus_Mb-8S1ZgEbLUUUJ97dfhfQ', $response->getCustomerToken());
        $this->assertTrue($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CustomerFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCustomerToken());
        $this->assertSame('One or more parameters were missing or invalid', $response->getMessage());
    }
}
