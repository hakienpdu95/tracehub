<?php

return [
    'name' => 'Sapo',

    'base_url'       => env('SAPO_BASE_URL'),
    'access_token'   => env('SAPO_ACCESS_TOKEN'),
    'webhook_secret' => env('SAPO_WEBHOOK_SECRET'),
    'organization_id' => env('SAPO_ORGANIZATION_ID'),

    'receipt_push_endpoint' => env('SAPO_RECEIPT_PUSH_ENDPOINT', '/admin/receipts.json'),
    'sold_serials_endpoint' => env('SAPO_SOLD_SERIALS_ENDPOINT', '/admin/orders.json'),
];
