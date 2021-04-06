<?php 

return [
    "password" => env("EGHL_PASSWORD"),
    "service_id" => env("EGHL_SERVICE_ID"),
    "service_url" => env("EGHL_SERVICE_URL"),
    "merchant_return_url" => env("MERCHANT_RETURN_URL"),
    "merchant_approval_url" => env("MERCHANT_APPROVAL_URL"),
    "merchant_unapproval_url" => env("MERCHANT_UNAPPROVAL_URL"),
    "merchant_callback_url" => env("MERCHANT_CALLBACK_URL"),
    "currency_code" => env("CURRENCY_CODE","MYR"),
    "page_timeout" => env("PAGE_TIMOUT",300),
    "transaction_type" => env("EGHL_TRANSACTION_TYPE","SALE"),
    "payment_method" => env("EGHL_PAYMENT_METHOD","ANY"),
];
