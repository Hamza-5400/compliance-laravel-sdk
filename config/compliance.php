<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Dokan Compliance API Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure your Dokan Compliance API settings. The API is designed
    | to facilitate seamless integration with Dokan's compliance services, enabling
    | businesses to automate and streamline their compliance processes.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Dokan Compliance API. This can be set to either the
    | development or production URL:
    |
    | Development: http://127.0.0.1:8001/api
    | Production: https://compliance.dokan.sa/api
    |
    */
    'api_url' => env('DOKAN_COMPLIANCE_API_URL', 'https://compliance.dokan.sa/api'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your Dokan Compliance API authentication key. This key is used to authenticate
    | all API requests to the Dokan Compliance service.
    |
    */
    'api_key' => env('DOKAN_COMPLIANCE_API_KEY'),
]; 