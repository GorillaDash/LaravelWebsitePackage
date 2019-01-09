<?php

namespace GorillaDash\LaravelWebsite\Authentication;

use DateTime;
use Exception;
use Serializable;

/**
 * Class AccessToken
 *
 * @package GorillaDash\LaravelWebsite\Authentication
 */
class AccessToken implements Serializable
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var \DateTime|null
     */
    protected $expiredAt;


    /**
     * AccessToken constructor.
     *
     * @param string $accessToken
     * @param int    $expiredAt
     */
    public function __construct(string $accessToken, $expiredAt = null)
    {
        $this->accessToken = $accessToken;
        if ($expiredAt) {
            $this->setExpiresAtFromTimeStamp($expiredAt);
        }
    }

    /**
     * Getter for expiredAt.
     *
     * @return \DateTime|null
     */
    public function getExpiredAt(): ?DateTime
    {
        return $this->expiredAt;
    }

    /**
     * Checks the expiration of the access token
     *
     * @return bool|null
     */
    public function isExpired(): ?bool
    {
        if ($this->getExpiredAt() instanceof \DateTime) {
            return $this->getExpiredAt()->getTimestamp() < time();
        }

        return null;
    }

    /**
     * Returns access token
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->accessToken;
    }

    /**
     * @param $timestamp
     */
    private function setExpiresAtFromTimeStamp($timestamp): void
    {
        try {
            $dt = new DateTime();
            $dt->setTimestamp($timestamp);
            $this->expiredAt = $dt;
        } catch (Exception $e) {
        }
    }

    /**
     * String representation of object
     *
     * @link  https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return implode('|', [$this->accessToken, $this->getExpiredAt()->getTimestamp()]);
    }

    /**
     * Constructs the object
     *
     * @link  https://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list ($value, $expired) = explode('|', $serialized);
        $this->__construct($value, (int)$expired);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
