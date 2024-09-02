<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;
// use sdk_moneygate\OnSiteRedirectDepositing;

class OnSiteRedirectDepositingTest extends TestCase
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
}
