<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\OnSiteRedirectDepositing;

class OnSiteRedirectDepositingTest extends TestCase
{
    public $auth;
    private static $id;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->auth = new Auth($_ENV['privateKey'], $_ENV['Token']);
    }

    protected function tearDown(): void
    {

    }

    public function testOnSiteRedirectDepositingCreate(): void
    {
        $onSiteRedirectDepositing = new OnSiteRedirectDepositing($this->auth, true);
        $resultCreating = $onSiteRedirectDepositing->create(customer_id: "2a1bc47b-38d2-4631-9f8c-0d497081f1ca");
        $this->assertArrayHasKey('data', $resultCreating);
        $this->assertArrayHasKey('id', $resultCreating);
        $this->assertArrayHasKey('success', $resultCreating);
        $this->assertEquals('true', $resultCreating['success']);
        self::$id = $onSiteRedirectDepositing->getId();
    }
    
    public function testOnSiteRedirectDepositingGetStatus(): void
    {
        $testGetStatus = new OnSiteRedirectDepositing($this->auth, true);
        $resultGetStatusm = $testGetStatus->getStatus(self::$id);
        $this->assertArrayHasKey('status', $resultGetStatusm);
        $this->assertArrayHasKey('id', $resultGetStatusm);
        $this->assertEquals(self::$id, $resultGetStatusm['id']);
    }
}
