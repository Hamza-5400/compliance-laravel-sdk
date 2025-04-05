<?php

namespace Dokan\Compliance\Jobs;

use Dokan\Compliance\ComplianceClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateInvoiceJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 5; // 5 seconds between retries

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $invoiceData
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(ComplianceClient $client): void
    {
        try {
            $response = $client->createInvoice($this->invoiceData);
            
            Log::info('Invoice created successfully', [
                'invoice_identifier' => $this->invoiceData['invoice_identifier'] ?? null,
                'response' => $response
            ]);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true) : null;

            Log::error('Failed to create invoice', [
                'invoice_identifier' => $this->invoiceData['invoice_identifier'] ?? null,
                'status_code' => $statusCode,
                'response' => $responseBody,
                'error' => $e->getMessage()
            ]);

            // Only retry on connection issues or 5xx server errors
            if ($this->shouldRetry($e)) {
                $this->release($this->backoff);
                return;
            }

            // For other errors (like 4xx), fail the job without retrying
            $this->fail($e);
        } catch (\Exception $e) {
            Log::error('Unexpected error while creating invoice', [
                'invoice_identifier' => $this->invoiceData['invoice_identifier'] ?? null,
                'error' => $e->getMessage()
            ]);

            // For unexpected errors, retry
            $this->release($this->backoff);
        }
    }

    /**
     * Determine if the job should be retried.
     */
    protected function shouldRetry(\Exception $e): bool
    {
        // Retry on connection issues
        if ($e instanceof ConnectException) {
            return true;
        }

        // Retry on server errors (5xx)
        if ($e instanceof RequestException && $e->hasResponse()) {
            $statusCode = $e->getResponse()->getStatusCode();
            return $statusCode >= 500;
        }

        return false;
    }
} 