<?php

namespace Dokan\Compliance\Tests\Unit;

use Dokan\Compliance\ComplianceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use Orchestra\Testbench\TestCase;

class ComplianceClientTest extends TestCase
{
    private array $container = [];
    private MockHandler $mock;
    private ComplianceClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mock = new MockHandler();
        $handlerStack = HandlerStack::create($this->mock);
        $history = Middleware::history($this->container);
        $handlerStack->push($history);

        $guzzleClient = new Client(['handler' => $handlerStack]);
        $this->client = new ComplianceClient('http://test.com', 'test-key');
    }

    public function test_get_business_details()
    {
        $this->mock->append(new Response(200, [], json_encode([
            'data' => 'Business Details'
        ])));

        $response = $this->client->getBusinessDetails();
        $this->assertEquals(['data' => 'Business Details'], $response);
    }

    public function test_create_invoice()
    {
        $this->mock->append(new Response(200, [], json_encode([
            'message' => 'Invoice has been reported successfully',
            'invoice' => 'INV-123'
        ])));

        $response = $this->client->createInvoice([
            'business_config_id' => 'test-id',
            'invoice_identifier' => 'INV-123',
            'type' => 'simplified',
            'type_code' => 388,
            'currency' => 'SAR',
            'payment_status' => 'Paid',
            'nature' => 'Sale',
            'invoice_date' => '2025-04-24 12:00:00',
            'client' => [
                'email' => 'test@example.com',
                'type' => 'individual'
            ],
            'lineItems' => [
                [
                    'label' => 'Test Item',
                    'price' => 100,
                    'quantity' => 1,
                    'is_vat_inclusive' => true
                ]
            ]
        ]);

        $this->assertEquals([
            'message' => 'Invoice has been reported successfully',
            'invoice' => 'INV-123'
        ], $response);
    }

    public function test_get_invoice_details()
    {
        $this->mock->append(new Response(200, [], json_encode([
            'data' => 'Invoice Details'
        ])));

        $response = $this->client->getInvoiceDetails(123);
        $this->assertEquals(['data' => 'Invoice Details'], $response);
    }
} 