<?php

return [
    'environment' => env('FAWATERK_ENVIRONMENT', 'test'),
    'test'     => [
        'apikey'        => env('FAWATERK_API'),
        'apiUrl'     => 'https://fawaterkstage.com/api/v2/createInvoiceLink',
        'fawaterk_transaction_data'     => 'https://fawaterkstage.com/api/v2/getInvoiceData/',
        'currency' => env('FAWATERK_CURRENCY'),
        'successUrl'      => env('FAWATERK_SUCCESS_URL'),
        'pendingUrl'        => env('FAWATERK_PENDING_URL'),
        'failUrl'        => env('FAWATERK_FAIL_URL'),
    ],
    'live'        => [
        'apikey'        => env('FAWATERK_API'),
        'apiUrl'     => 'https://app.fawaterk.com/api/v2/createInvoiceLink',
        'fawaterk_transaction_data'     => 'https://app.fawaterk.com/api/v2/getInvoiceData/',
        'currency' => env('FAWATERK_CURRENCY'),
        'successUrl'      => env('FAWATERK_SUCCESS_URL'),
        'pendingUrl'        => env('FAWATERK_PENDING_URL'),
        'failUrl'        => env('FAWATERK_FAIL_URL'),
    ],
];
