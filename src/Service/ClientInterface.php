<?php

namespace Caesar\SecurityMessageBundle\Service;


interface ClientInterface
{
    /**
     * Set the string value in argument as value of the key.
     * @param string $key
     * @param string $value
     * @param int|null $timeout
     * @return bool
     */
    public function set(string $key, ?string $value, int $timeout = null): bool;

    /**
     * Get the value related to the specified key
     * @param string $key
     * @return string
     */
    public function get(string $key): string;

    /**
     * Sets an expiration date (a timeout) on an item
     * @param string $key
     * @param int $ttl
     * @return bool
     */
    public function expire(string $key, int $ttl): bool;

    /**
     * Remove specified keys.
     * @param string $key
     * @param mixed ...$otherKeys
     * @return int
     */
    public function del(string $key, ...$otherKeys): int;

    /**
     * Decrement the number stored at key by one.
     * @param string $key
     * @return int
     */
    public function decr(string $key): int;

    /**
     * Returns the time to live left for a given key, in seconds.
     * If the key doesn't exist, FALSE is returned.
     *
     * @param string $key
     * @return mixed
     */
    public function ttl(string $key);
}