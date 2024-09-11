<?php
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\Balance;

class BalanceUnitTest extends TestCase
{

    public Auth $auth;
    public Balance $balance;
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
        $this->auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);
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
