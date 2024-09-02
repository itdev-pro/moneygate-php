<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\SynchronousHostToHostDepositing;

class SynchronousHostToHostDepositingTest extends TestCase
{
    public $auth;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->auth = new Auth($_ENV['privateKey'], $_ENV['Token']);

    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostWithdrawalCreate(): void
    {
        $synchronousHostToHostDepositing = new SynchronousHostToHostDepositing($this->auth, true);
        $resultCreating = $synchronousHostToHostDepositing->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
        $this->assertArrayHasKey('data', $resultCreating);
        $this->assertArrayHasKey('id', $resultCreating);
        $this->assertArrayHasKey('success', $resultCreating);
        $this->assertEquals('true', $resultCreating['success']);
    }



}
