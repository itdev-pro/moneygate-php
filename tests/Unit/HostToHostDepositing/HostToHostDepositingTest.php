<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\HostToHostDepositing;

class HostToHostDepositingTest extends TestCase
{
    public $auth;

    protected static $id;

    protected static $sbp = null;

    protected static $card2card = null;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();

        $this->auth = new Auth($_ENV['privateKey'], $_ENV['Token']);

    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostDepositingCreate(): void
    {
        $hostToHostDepositing = new HostToHostDepositing($this->auth, true);
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
        $testPaymentInstruments = new HostToHostDepositing($this->auth, true);
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
            $testSetPaymentInstruments = new HostToHostDepositing($this->auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$sbp["payment_type"], self::$sbp["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

    public function testHostToHostDepositingSetPaymentInstrumentsCard2Card(): void
    {
        if (self::$card2card) {
            $testSetPaymentInstruments = new HostToHostDepositing($this->auth, true);
            $resultSetPaymentInstruments = $testSetPaymentInstruments->setPaymentInstruments(self::$id, self::$card2card["payment_type"], self::$card2card["bank"], "2a1bc47b-38d2-4631-9f8c-0d497081f1ca", "1234");
            $this->assertArrayHasKey('success', $resultSetPaymentInstruments);
            $this->assertEquals('true', $resultSetPaymentInstruments['success']);
        }
    }

    public function testHostToHostDepositingConfirm(): void
    {
        if (self::$sbp or self::$card2card) {
            $testConfirm = new HostToHostDepositing($this->auth, true);
            $resultConfirm = $testConfirm->confirm(self::$id);
            $this->assertArrayHasKey('success', $resultConfirm);
            $this->assertEquals('true', $resultConfirm['success']);
        }
    }

    public function testHostToHostDepositingGetStatus(): void
    {
        $testGetStatus = new HostToHostDepositing($this->auth, true);
        $resultGetStatus = $testGetStatus->getStatus(self::$id);
        $this->assertArrayHasKey('status', $resultGetStatus);
        $this->assertNotEquals('error', $resultGetStatus['status']);
    }

}
