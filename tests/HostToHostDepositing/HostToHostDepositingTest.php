<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
use sdk_moneygate\HostToHostDepositing;

class HostToHostDepositingTest extends TestCase
{
    private $data;
    private $right_auth;
    private $hostToHostDepositing;
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $privateKey = file_get_contents('/home/homi/my_projects/SDK_Moneygate_API/tests/Balance/moneygate.key');
        // $this->data =
        $this->right_auth = new Auth($privateKey, $_ENV['Token']);
        $this->hostToHostDepositing = new HostToHostDepositing($this->right_auth, true);

    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostDepositing()
    {
        print_r($this->hostToHostDepositing->create());
        $this->assertEquals(true, true);
        
    }

 
}
