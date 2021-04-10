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

        return $this->assertEquals($url , "http://your-eghl-service-url.com?TransactionType=SALE&PymtMethod=ANY&ServiceID=serviceId&MerchantReturnURL=http%3A%2F%2Fyour-return-url.com&MerchantCallBackURL=http%3A%2F%2Fyour-callback-url.com&CurrencyCode=MYR&HashValue=46e682c196de2d4dc44e58436ecff9a8538493969faf7d92882df98be0d146a4&Amount=228.00&PaymentID=TestingId&OrderNumber=IJKLMN&PaymentDesc=ADNEXIO&CustName=Jason&CustEmail=Jasonabc%40gmail.com&CustPhone=60121235678");
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