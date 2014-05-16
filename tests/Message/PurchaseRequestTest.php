<?php

namespace Omnipay\Pin\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount'   => '10.00',
                'currency' => 'AUD',
                'card'     => $this->getValidCard(),
            )
        );
    }

    public function testDataWithCardToken()
    {
        $this->request->setToken('card_abc');
        $data = $this->request->getData();

        $this->assertSame('card_abc', $data['card_token']);
    }

    public function testDataWithCcustomerToken()
    {
        $this->request->setToken('cus_abc');
        $data = $this->request->getData();

        $this->assertSame('cus_abc', $data['customer_token']);
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
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('ch_fXIxWf0gj1yFHJcV1W-d-w', $response->getTransactionReference());
        $this->assertSame('Success!', $response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('The current resource was deemed invalid.', $response->getMessage());
    }
}
