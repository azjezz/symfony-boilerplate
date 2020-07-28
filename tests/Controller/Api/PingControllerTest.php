<?php


namespace App\Tests\Controller\Api;


use App\Fixtures\UserFixture;
use App\Test\TestCase;

class PingControllerTest extends TestCase
{
    protected array $fixtures = [
        UserFixture::class
    ];

    public function testPingWithLogin(): void
    {
        $browser = $this->createAuthenticatedClient();
        $browser->request('GET', '/api/ping');

        $response = $browser->getResponse();
        $content = $response->getContent();

        $data = json_decode($content, true);
        self::assertSame('pong!', $data['ping']);
    }

    public function testPingWithoutLogin(): void
    {
        $this->browser->request('GET', '/api/ping');

        $response = $this->browser->getResponse();

        self::assertSame(401, $response->getStatusCode());
    }
}