<?php
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\Balance;

class BalanceTest extends TestCase
{

    private $right_balance;
    private $wrong_balance;
    private $wrong_auth;
    private $right_auth;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/moneygate.key');
        $this->right_auth = new Auth($privateKey, $_ENV['Token']);
        $this->right_balance = new Balance($this->right_auth,  true);
 
        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/wrong.key');
        $this->wrong_auth = new Auth($privateKey, $_ENV['Token']);
        $this->wrong_balance = new Balance($this->wrong_auth, true);

    }

    protected function tearDown(): void
    {

    }

    public function testWrongGetBalance()
    {
        $auth_error_result = [
            'error' => 'auth error',
            'error_code' => 400,
        ];
        $this->assertEquals($auth_error_result, $this->wrong_balance->get_balance());
    }

    public function testRightGetBalance()
    {
        $this->assertArrayHasKey('data', $this->right_balance->get_balance());
        $this->assertArrayHasKey('amounts', $this->right_balance->get_balance()['data']);
    }
}
