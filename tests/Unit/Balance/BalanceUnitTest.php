<?php
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\Balance;

class BalanceUnitTest extends TestCase
{

    public Auth $auth;
    public Balance $balance;
    protected function setUp(): void
    {
        $this->auth = new Auth(getenv('RIGHT_PRIVATE_KEY'), getenv('TOKEN'));
        $this->balance = new Balance($this->auth, true);
    }

    protected function tearDown(): void
    {

    }

    public function testGetOptionsmethod()
    {
        $result = $this->balance->getOptions();
        $this->assertArrayHasKey('http', $result);
        $this->assertArrayHasKey('method', $result['http']);
        $this->assertEquals('GET', $result['http']['method']);
        $this->assertArrayHasKey('header', $result['http']);
    }
}
