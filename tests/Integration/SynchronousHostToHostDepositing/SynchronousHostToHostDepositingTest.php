<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\SynchronousHostToHostDepositing;

class SynchronousHostToHostDepositingTest extends TestCase
{
    public $auth;

    protected static $id;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();

        $this->auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);

    }

    protected function tearDown(): void
    {

    }

    public function testSynchronousHostToHostDepositingCreate(): void
    {
        $synchronousHostToHostDepositing = new SynchronousHostToHostDepositing($this->auth, true);
        $resultCreating = $synchronousHostToHostDepositing->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
        $this->assertArrayHasKey('data', $resultCreating);
        $this->assertArrayHasKey('id', $resultCreating);
        $this->assertArrayHasKey('success', $resultCreating);
        $this->assertEquals('true', $resultCreating['success']);
        self::$id = $synchronousHostToHostDepositing->getId();
    }

    public function testSynchronousHostToHostDepositingPaymentInstruments(): void
    {
        $testPaymentInstruments = new SynchronousHostToHostDepositing($this->auth, true);
        $resultPayment = $testPaymentInstruments->getPaymentInstruments();
        $this->assertArrayHasKey('success', $resultPayment);
        $this->assertEquals('true', $resultPayment['success']);
        $this->assertArrayHasKey('data', $resultPayment);
    }

    public function testSynchronousHostToHostDepositingGetStatus(): void
    {
        $testGetStatus = new SynchronousHostToHostDepositing($this->auth, true);
        $resultGetStatus = $testGetStatus->getStatus(self::$id);
        $this->assertArrayHasKey('status', $resultGetStatus);
        $this->assertArrayHasKey('id', $resultGetStatus);
        $this->assertEquals(self::$id, $resultGetStatus['id']);
    }

}
