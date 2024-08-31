<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\HostToHostDepositing;

class HostToHostDepositingTest extends TestCase
{
    private $right_auth;
    private $hostToHostDepositing;

    private $create_result;
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/moneygate.key');

        $this->right_auth = new Auth($privateKey, $_ENV['Token']);
        $this->hostToHostDepositing = new HostToHostDepositing($this->right_auth, true);
    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostDepositingCreate()
    {
        $this->create_result = $this->hostToHostDepositing->create();
        $this->assertArrayHasKey('data', $this->create_result);
        $this->assertArrayHasKey('id', $this->create_result);
        $this->assertArrayHasKey('success', $this->create_result);
    }

    public function testHostToHostDepositingGetPaymentInstruments()
    {
        // TODO: тут исправить потому что setUp работает каждый раз при вызове теста
        $result = $this->hostToHostDepositing->getPaymentInstruments();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

 
}
