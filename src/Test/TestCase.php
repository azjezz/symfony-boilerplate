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

    protected array

 $fixtures = [];

    protected array

 $options = [];

    protected KernelBrowser $browser;

    protected function setUp(): void
    {
        $this->browser = static::createClient($this->options);
        $this->loadFixtures($this->fixtures, false);
    }
}
