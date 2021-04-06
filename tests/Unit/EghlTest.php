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
     
        return $this->assertEquals($url , "http://localhost?TransactionType=SALE&PymtMethod=ANY&ServiceID=&MerchantReturnURL=&MerchantCallBackURL=&CurrencyCode=MYR&HashValue=e2f2564329977c39be297ef49efcdf7ac2f8e8b4f8e9b442eefbe3fde06db6a4&Amount=228.00&PaymentID=TestingId&OrderNumber=IJKLMN&PaymentDesc=ADNEXIO&CustName=Jason&CustEmail=Jasonabc%40gmail.com&CustPhone=60121235678");
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