<?php

declare(strict_types=1);

namespace Caesar\SecurityMessageBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client as SymfonyClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyTestCase;

/**
 * Class WebTestCase.
 */
class WebTestCase extends SymfonyTestCase
{
    /**
     * @param array $options
     * @param array $server
     *
     * @return SymfonyClient|Client
     */
    public static function createClient(array $options = [], array $server = [])
    {
        return parent::createClient($options, $server);
    }
}
