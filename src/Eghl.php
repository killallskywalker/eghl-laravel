<?php

namespace Killallskywalker\Eghl;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Eghl
{
    private $password;
    private $serviceId;
    private $serviceUrl;
    private $merchantReturlUrl;
    private $merchantApprovalUrl;
    private $merchantCallbackUrl;
    private $merchantUnApprovalUrl;
    private $currencyCode;
    private $transactionType;
    private $paymentMethod;
    private $orderId;
    private $orderNumber;
    private $paymentDescription;
    private $paymentDetail;

    public function __construct()
    {
        $this->password = config('eghl.password');
        $this->serviceId = config('eghl.service_id');
        $this->merchantReturlUrl = config('eghl.merchant_return_url');
        $this->merchantApprovalUrl = config('eghl.merchant_approval_url');
        $this->merchantUnApprovalUrl = config('eghl.merchant_unapproval_url');
        $this->merchantCallbackUrl = config('eghl.merchant_callback_url');
        $this->currencyCode = config('eghl.currency_code');
        $this->pageTimeout = config('eghl.page_timeout');
        $this->transactionType = config('eghl.transaction_type');
        $this->paymentMethod = config('eghl.payment_method');
        $this->serviceUrl = config('eghl.service_url');
    }

    /**
     * Get the hashing value 
     *
     * @param array]
     * 
     * @return string
     */
    public function generateHash(array $value)
    {
        $this->paymentRequestValidation($value);
        
        $param = $this->password.$this->serviceId.$value['PaymentID'].$this->merchantReturlUrl.$this->merchantCallbackUrl.$value['Amount'].$this->currencyCode;

        return hash('sha256', $param);
    }

    public function generateHttpQuery($data)
    {
        $queryParam = [
            'TransactionType' => $this->transactionType,
            'PymtMethod' => $this->paymentMethod,
            'ServiceID' => $this->serviceId,
            'MerchantReturnURL' => $this->merchantReturlUrl,
            'MerchantCallBackURL' => $this->merchantCallbackUrl,
            "CurrencyCode" => $this->currencyCode,
            "HashValue" => $this->generateHash($data),
            "Amount" => $data["Amount"], 
            'PaymentID' => $data['PaymentID'],
            'OrderNumber'=> $data['OrderNumber'],
            'PaymentDesc' => $data['PaymentDesc'],
            "CustName"  => $data['CustName'] ,
            "CustEmail" => $data['CustEmail'] ,
            "CustPhone" => $data['CustPhone'] 
        ];

        $httpQuery = http_build_query($queryParam);

        return $httpQuery;
    }
    
    /**
     * Process eghl payment for payment request
     *
     * 
     * @return string url payment page
     */
    public function processPaymentRequest($data)
    {
        $url = $this->serviceUrl.'?'.$this->generateHttpQuery($data);

        return url($url);
    }

    /**
     * Validate payment response 
     *
     * 
     * @return boolean
     */
    public function validatePaymentResponse($data)
    {
        $string = $this->password.$data["TxnID"].$this->serviceId.$data["PaymentID"].$data["TxnStatus"].$data["Amount"].$data["CurrencyCode"].$data["AuthCode"];

        $hash = (hash('sha256', $string));

        if($hash === $data["HashValue"]){
            return true;
        }

        return false;
    }

    /**
     * Validate array value that require to process payment
     *
     * @param array []
     * 
     * @return \ErrorException
     */
    private function paymentRequestValidation($value)
    {
        $validator = Validator::make($value,[
            'PaymentID' => 'required|max:20', // no duplicate payment id
            'OrderNumber' => 'required|max:20', // Non unique , can be same under payment id 
            'PaymentDesc' => 'required|max:100',
            'Amount' => 'required|numeric|gt:0', 
            'CustIP' => 'sometimes|max:20',
            'CustName' => 'required|max:50',
            'CustEmail' => 'required|max:60',
            'CustPhone' => 'required|max:25',
            'B4TaxAmt' => 'sometimes|numeric|gt:0',
            'TaxAmt' => 'sometimes|numeric|gt:0',
            'MerchantName' => 'sometimes|max:25',
            'CustMAC' => 'sometimes|max:50',
            'LanguageCode' => 'sometimes|max:2',
            'PageTimeout' => 'sometimes|max:4',
        ],
        [
            "PaymentID.required" => "Payment ID Required!",
        ]
    );

        if ($validator->fails())
            throw new \ErrorException($validator->errors()->first());
    }
}