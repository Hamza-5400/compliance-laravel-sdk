<?php

namespace Dokan\Compliance\Tests\Feature;

use Dokan\Compliance\ComplianceClient;
use Orchestra\Testbench\TestCase;

class ComplianceServiceProviderTest extends TestCase
{
    public function test_compliance_client_can_be_resolved()
    {
        $client = $this->app->make(ComplianceClient::class);
        $this->assertInstanceOf(ComplianceClient::class, $client);
    }

    protected function getPackageProviders($app)
    {
        return ['Dokan\Compliance\ComplianceServiceProvider'];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('compliance.api_url', 'http://test.com');
        $app['config']->set('compliance.api_key', 'test-key');
    }
} 