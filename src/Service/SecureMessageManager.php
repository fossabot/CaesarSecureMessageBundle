<?php

declare(strict_types=1);

namespace Fourxxi\SecurityMessageBundle\Service;

use Fourxxi\SecurityMessageBundle\DTO\SecureMessage;
use Symfony\Component\Serializer\SerializerInterface;

class SecureMessageManager
{
    public const PREFIX = 'messages';
    public const LIMIT_PREFIX = 'limits';
    public const UNLIMITED_VALUE = -1;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function save(SecureMessage $message): SecureMessage
    {
        $clientId = $this->buildId($message->getId());
        $limitId = $this->buildLimitId($message->getId());
        $this->client->set($clientId, $this->serialize($message));
        $this->client->set($limitId, $message->getRequestsLimit());

        if (self::UNLIMITED_VALUE !== $message->getSecondsLimit()) {
            $this->client->expire($clientId, $message->getSecondsLimit());
            $this->client->expire($limitId, $message->getSecondsLimit());
        }

        return $message;
    }

    public function has(string $id): bool
    {
        $json = $this->client->get($this->buildId($id));

        return null !== $json;
    }

    public function get($id): ?SecureMessage
    {
        $clientId = $this->buildId($id);

        $rawMessage = $this->client->get($clientId);
        if (false === $rawMessage) {
            return null;
        }

        $ttl = $this->client->ttl($clientId);
        $attemptsLeft = (int)$this->client->get($this->buildLimitId($id));
        $message = $this->deserialize($id, $rawMessage, $ttl, $attemptsLeft);

        if (self::UNLIMITED_VALUE !== $message->getRequestsLimit()) {
            $this->decreaseLimit($message);
            $this->deleteIfLastAttempt($message);
        }

        return $message;
    }

    public function buildId(string $id): string
    {
        return $this::PREFIX . ':' . $id;
    }

    public function buildLimitId(string $id): string
    {
        return $this::LIMIT_PREFIX . ':' . $id;
    }

    public function serialize(SecureMessage $message): string
    {
        return $message->getMessage();
    }

    public function deserialize(string $id, string $data, int $ttl, int $attemptsLeft): SecureMessage
    {
        $message = new SecureMessage();

        $message->setId($id);
        $message->setMessage($data);
        $message->setSecondsLimit($ttl);
        $message->setRequestsLimit($attemptsLeft);

        return $message;
    }

    protected function decreaseLimit(SecureMessage $message): int
    {
        $limit = $this->client->decr($this->buildLimitId($message->getId()));
        $message->setRequestsLimit($limit);
        return $limit;
    }

    /**
     * Returns true if it is last attempt (based on requestsLimit), false - in opposite case.
     *
     * @param SecureMessage $message
     *
     * @return bool
     */
    protected function deleteIfLastAttempt(SecureMessage $message): bool
    {
        if (!$message->getRequestsLimit()) {
            $this->client->del($this->buildId($message->getId()));
            $this->client->del($this->buildLimitId($message->getId()));

            return true;
        }

        return false;
    }
}
