<?php

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class HostToHostDepositingTest extends TestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    protected function tearDown(): void
    {

    }

    public function testHostToHostDepositing()
    {
        $this->assertEquals(true, true);
    }
}
