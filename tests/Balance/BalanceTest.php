<?php
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\Balance;

class BalanceTest extends TestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
    }

    protected function tearDown(): void
    {

    }

    public function testWrongGetBalance()
    {
        $auth = new Auth($_ENV['wronkPrivateKey'], $_ENV['Token']);
        $balance = new Balance($auth, true);
        $auth_error_result = [
            'error' => 'auth error',
            'error_code' => 400,
        ];
        $this->assertEquals($auth_error_result, $balance->getBalance());
    }

    public function testRightGetBalance()
    {
        $auth = new Auth($_ENV['privateKey'], $_ENV['Token']);
        $balance = new Balance($auth, true);
        $result = $balance->getBalance();
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('amounts', $result['data']);
    }
}
