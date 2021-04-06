<?php

namespace Killallskywalker\Eghl\Tests;

use Killallskywalker\Eghl\Facades\Eghl;
use Killallskywalker\Eghl\EghlServiceProvider;
use Killallskywalker\Eghl\Tests\TestCase;

class EghlTest extends TestCase
{
    /**
     * @test
     */
    public function can_generate_proper_url_when_all_required_data_available()
    {
        $data = [
            "PaymentID" => "TestingId", 
            "OrderNumber" => "IJKLMN", 
            "Amount" => "228.00", 
            "CustName" => "Jason",
            "CustEmail" => "Jasonabc@gmail.com",
            "CustPhone" => "60121235678",
            "PaymentDesc" => "ADNEXIO",
        ];

        $url = Eghl::processPaymentRequest($data);
     
        return $this->assertEquals($url , "https://pay.e-ghl.com/IPGSG/Payment.aspx?TransactionType=SALE&PymtMethod=ANY&ServiceID=SIT&MerchantReturnURL=http%3A%2F%2F7a9f415a0322.ngrok.io%2Fapi%2Freturn_url&MerchantCallBackURL=http%3A%2F%2F7a9f415a0322.ngrok.io%2Fapi%2Fcallback_url&CurrencyCode=MYR&HashValue=e8bada49b7b69953affc97b055fca7fc482ec86c4cd765e6dd511131189acec0&Amount=228.00&PaymentID=TestingId&OrderNumber=IJKLMN&PaymentDesc=ADNEXIO&CustName=Jason&CustEmail=Jasonabc%40gmail.com&CustPhone=60121235678");
    }

    /**
     * @test
     */
    public function exception_throw_when_required_value_not_available()
    {
        $this->expectExceptionMessage('Payment ID Required!');

        $data = [
            "OrderNumber" => "IJKLMN", 
            "Amount" => "228.00", 
            "CustName" => "Jason",
            "CustEmail" => "Jasonabc@gmail.com",
            "CustPhone" => "60121235678",
            "PaymentDesc" => "ADNEXIO",
        ];

        $url = Eghl::processPaymentRequest($data);

    }
}