<?php

declare(strict_types=1);

namespace Caesar\SecurityMessageBundle\Tests\Service;

use Caesar\SecurityMessageBundle\Service\ClientInterface;
use Caesar\SecurityMessageBundle\Service\SecureMessageManager;
use PHPUnit\Framework\TestCase;
use Caesar\SecurityMessageBundle\DTO\SecureMessage;
use Symfony\Component\Serializer\SerializerInterface;

class SecureMessageManagerTest extends TestCase
{
    /**
     * @var SecureMessageManager
     */
    private $secureMessageManager;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        /** @var ClientInterface $client */
        $client = $this->createMock(ClientInterface::class);
        /** @var SerializerInterface $serializer */
        $serializer = $this->createMock(SerializerInterface::class);
        $this->secureMessageManager = new SecureMessageManager($client, $serializer);
    }

    public function testSave()
    {
        $message = new SecureMessage();
        $message->setMessage('test');
        $message->setRequestsLimit(1);
        $message->setSecondsLimit(80000);
        $this->secureMessageManager->save($message);

        $this->assertInstanceOf(SecureMessage::class, $message);
    }
}