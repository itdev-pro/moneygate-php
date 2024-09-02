<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\HostToHostDepositing;

class HostToHostDepositingTest extends TestCase
{
    public $right_auth;

    protected static $id;

    protected static $sbp = null;

    protected static $card2card = null;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/moneygate.key');

        $this->right_auth = new Auth($privateKey, $_ENV['Token']);

    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostDepositingCreate(): void
    {
        $hostToHostDepositing = new HostToHostDepositing($this->right_auth, true);
        $resultCreating = $hostToHostDepositing->create();
        $this->assertArrayHasKey('data', $resultCreating);
        $this->assertArrayHasKey('id', $resultCreating);
        $this->assertArrayHasKey('success', $resultCreating);
        $this->assertEquals('true', $resultCreating['success']);
        self::$id = $hostToHostDepositing->getId();
        $resultPayment = $hostToHostDepositing->getPaymentInstruments();
        $this->assertArrayHasKey('success', $resultPayment);
        $this->assertEquals('true', $resultPayment['success']);
        $this->assertArrayHasKey('data', $resultPayment);
    }

    public function testHostToHostDepositingPaymentInstruments(): void
    {
        $testPaymentInstruments = new HostToHostDepositing($this->right_auth, true);
        $resultPayment = $testPaymentInstruments->getPaymentInstruments(self::$id);
        $this->assertArrayHasKey('success', $resultPayment);
        $this->assertEquals('true', $resultPayment['success']);
        $this->assertArrayHasKey('data', $resultPayment);
        foreach ($resultPayment['data']['payment_instruments'] as $paymentInstrument) {
            if ($paymentInstrument['payment_type'] == "sbp") {
                self::$sbp = $paymentInstrument;
            }

            if ($paymentInstrument['payment_type'] == "card2card") {
                self::$card2card = $paymentInstrument;
            }

        }
    }

    public function testHostToHostDepositingSetPaymentInstrumentsSBP(): void
    {
        if (self::$sbp) {
            $testSetPaymentInstruments = new HostToHostDepositing($this->right_auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$sbp["payment_type"], self::$sbp["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

    public function testHostToHostDepositingSetPaymentInstrumentsCard2Card(): void
    {
        if (self::$card2card) {
            $testSetPaymentInstruments = new HostToHostDepositing($this->right_auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$card2card["payment_type"], self::$card2card["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca", "1234");
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

}
