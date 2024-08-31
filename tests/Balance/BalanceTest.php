<?php
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\Balance;

class BalanceTest extends TestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    protected function tearDown(): void
    {

    }

    public function testWrongGetBalance()
    {
        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/wrong.key');
        $auth = new Auth($privateKey, $_ENV['Token']);
        $balance = new Balance($auth, true);
        $auth_error_result = [
            'error' => 'auth error',
            'error_code' => 400,
        ];
        $this->assertEquals($auth_error_result, $balance->getBalance());
    }

    public function testRightGetBalance()
    {

        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/moneygate.key');
        $auth = new Auth($privateKey, $_ENV['Token']);
        $balance = new Balance($auth, true);
        $result = $balance->getBalance();
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('amounts', $result['data']);
    }
}
