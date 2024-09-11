<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\HostToHostWithdrawal;

class HostToHostWithdrawalTest extends TestCase
{

    public $auth;
    protected static $id;

    protected static $sbp = null;

    protected static $card2card = null;
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();

        $this->auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);

    }
    protected function tearDown(): void
    {

    }

    public function testHostToHostWithdrawalCreate(): void
    {
        $hostToHostWithdrawal = new HostToHostWithdrawal($this->auth, true);
        $resultCreating = $hostToHostWithdrawal->create();
        $this->assertArrayHasKey('data', $resultCreating);
        $this->assertArrayHasKey('id', $resultCreating);
        $this->assertArrayHasKey('success', $resultCreating);
        $this->assertEquals('true', $resultCreating['success']);
        self::$id = $hostToHostWithdrawal->getId();
        $resultPayment = $hostToHostWithdrawal->getPaymentInstruments();
        $this->assertArrayHasKey('success', $resultPayment);
        $this->assertEquals('true', $resultPayment['success']);
        $this->assertArrayHasKey('data', $resultPayment);
    }

    public function testHostToHostWithdrawalPaymentInstruments(): void
    {
        $testPaymentInstruments = new HostToHostWithdrawal($this->auth, true);
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

    public function testHostToHostWithdrawalSetPaymentInstrumentsSBP(): void
    {
        if (self::$sbp) {
            $testSetPaymentInstruments = new HostToHostWithdrawal($this->auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$sbp["payment_type"], self::$sbp["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca", phone:"+79991112233");
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

    public function testHostToHostWithdrawalSetPaymentInstrumentsCard2Card(): void
    {
        if (self::$card2card) {
            $testSetPaymentInstruments = new HostToHostWithdrawal($this->auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$card2card["payment_type"], self::$card2card["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca", card_no: "1111222233334444", card_holder_name: "John Smith" );
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

    public function testHostToHostWithdrawalConfirm(): void
    {
        if (self::$sbp or self::$card2card) {
            $testConfirm = new HostToHostWithdrawal($this->auth, true);
            $resultConfirm = $testConfirm->confirm(self::$id);
            $this->assertArrayHasKey('success', $resultConfirm);
            $this->assertEquals('true', $resultConfirm['success']);
        }
    }

    public function testHostToHostWithdrawalGetStatus(): void
    {
        $testGetStatus = new HostToHostWithdrawal($this->auth, true);
        $resultGetStatus = $testGetStatus->getStatus(self::$id);
        $this->assertArrayHasKey('status', $resultGetStatus);
        $this->assertNotEquals('error', $resultGetStatus['status']);
    }

}
