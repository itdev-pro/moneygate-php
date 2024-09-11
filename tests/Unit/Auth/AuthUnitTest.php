<?php
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sdk_moneygate\Auth;

class AuthUnitTest extends TestCase
{

    public Auth $auth;
    public string $token;
    public string $privateKey;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
        $this->token = $_ENV['TOKEN'];
        $this->token = $_ENV['RIGHT_PRIVATE_KEY'];
        $this->auth = new Auth($_ENV['RIGHT_PRIVATE_KEY'], $_ENV['TOKEN']);
    }

    protected function tearDown(): void
    {

    }

    public function testGetXAuthSign()
    {
        $data = 'test';
        $xAuthSign = "IAJGJwX1GGB70WwThn0sF6ehH/KN/N1F/cu/jjUgddux31OciCTSrii3WK2v3oR42+4BmwVgeFmn2dqrVxJcg7+zGtknDDqUPx2Agk7eaOd3I5jit+CQ3JW9ctCYk4FGBkOA1xJKACDPThUw5f8F9EbObvxo3jyL2ny1LtYnNjk/vdwU2FvxZ91r9wyMCUXI3MfrRnFbsBlJyU119MaimT8Czl9oESK1fps6yQIPruVAQiU5zdv5LAKOVQ9Y6GV+iKyGvF4q9etiBo5/y97ei8a/6JzyNMEZsqvoB1Tn7bepuiiELewVt/DpCHWsdNrB1+PEzuyvu+ZC2iwAPxrV5g==";
        $this->assertEquals($xAuthSign, $this->auth->getXAuthSign($data));
    }
}
