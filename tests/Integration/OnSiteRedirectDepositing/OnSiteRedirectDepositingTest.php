<?php

use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\OnSiteRedirectDepositing;

class OnSiteRedirectDepositingTest extends TestCase
{
    public $auth;
    private static $id;

    protected function setUp(): void
    {
        $this->auth = new Auth(getenv('RIGHT_PRIVATE_KEY'), getenv('TOKEN'));
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
        $resultGetStatus = $testGetStatus->getStatus(self::$id);
        $this->assertArrayHasKey('status', $resultGetStatus);
        $this->assertArrayHasKey('id', $resultGetStatus);
        $this->assertEquals(self::$id, $resultGetStatus['id']);
    }
}
