<?php

/*
 * This file is part of Symfony Boilerplate.
 *
 * (c) omar kebir
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Test;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class TestCase extends WebTestCase
{
    use FixturesTrait;

    protected array $fixtures = [];

    protected array $options = [];

    protected KernelBrowser $browser;

    protected function setUp(): void
    {
        $this->browser = static::createClient($this->options);
        $this->loadFixtures($this->fixtures, false);
    }

    /**
     * Create a client with a default Authorization header.
     */
    protected function createAuthenticatedClient(string $username = 'user', string $password = 'password'): KernelBrowser
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                '_username' => $username,
                '_password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $browser = $this->browser;
        $browser->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $browser;
    }
}
