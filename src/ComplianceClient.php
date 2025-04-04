<?php

namespace Dokan\Compliance;

use Dokan\Compliance\Jobs\CreateInvoiceJob;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Bus;

class ComplianceClient
{
    private Client $client;
    private string $baseUrl;
    private string $apiKey;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => $this->baseUrl . '/',
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Get business details
     *
     * @return array
     * @throws GuzzleException
     */
    public function getBusinessDetails(): array
    {
        $response = $this->client->get('business');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a new invoice
     *
     * @param array $data
     * @param bool $queue Whether to process the request in queue
     * @param string|null $queueName The name of the queue to use
     * @return array|null Returns array when not queued, null when queued
     * @throws GuzzleException
     */
    public function createInvoice(array $data, bool $queue = false, ?string $queueName = null): ?array
    {
        if ($queue) {
            Bus::dispatch(new CreateInvoiceJob($data, $queueName));
            return null;
        }

        $response = $this->client->post('invoice', [
            'json' => $data
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get invoice details
     *
     * @param int $invoiceId
     * @return array
     * @throws GuzzleException
     */
    public function getInvoiceDetails(int $invoiceId): array
    {
        $response = $this->client->get("invoice/{$invoiceId}");
        return json_decode($response->getBody()->getContents(), true);
    }
} 