<?php

namespace Omnipay\Pin;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'card'   => $this->getValidCard(),
        );
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('ch_fXIxWf0gj1yFHJcV1W-d-w', $response->getTransactionReference());
        $this->assertSame('Success!', $response->getMessage());
    }

    public function testPurchaseError()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('The current resource was deemed invalid.', $response->getMessage());
    }

    public function testGetCardTokenSuccess()
    {
        $this->setMockHttpResponse('CardSuccess.txt');

        $response = $this->gateway->getCardToken($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('card_8LmnNMTYWG4zQZ4YnYQhBg', $response->getCardToken());
        $this->assertTrue($response->getMessage());
    }

    public function testGetCardTokenError()
    {
        $this->setMockHttpResponse('CardFailure.txt');

        $response = $this->gateway->getCardToken($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCardToken());
        $this->assertSame('One or more parameters were missing or invalid', $response->getMessage());
    }

    public function testCreateCustomerSuccess()
    {
        $this->setMockHttpResponse('CustomerSuccess.txt');

        $response = $this->gateway->createCustomer($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('cus_Mb-8S1ZgEbLUUUJ97dfhfQ', $response->getCustomerToken());
        $this->assertTrue($response->getMessage());
    }

    public function testCreateCustomerError()
    {
        $this->setMockHttpResponse('CustomerFailure.txt');

        $response = $this->gateway->createCustomer($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCustomerToken());
        $this->assertSame('One or more parameters were missing or invalid', $response->getMessage());
    }
}
