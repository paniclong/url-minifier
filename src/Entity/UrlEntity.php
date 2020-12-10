<?php

declare(strict_types=1);

namespace UrlMinifier\Entity;

use Illuminate\Database\Eloquent\Model;

class UrlEntity extends Model
{
    protected $table = 'urls';
    protected $casts = [
        'expires_at' => 'timestamp'
    ];

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->setAttribute('uuid', $uuid);
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->setAttribute('url', $url);
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->getAttributeValue('uuid');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getAttributeValue('url');
    }

    /**
     * @param int $expiresAt
     */
    public function setExpiresAt(int $expiresAt): void
    {
        $this->setAttribute('expires_at', date('Y-m-d H:i:s', $expiresAt));
    }

    /**
     * @return int|null
     */
    public function getExpiresAt(): ?int
    {
        return $this->getAttributeValue('expires_at');
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->getExpiresAt() !== null && $this->getExpiresAt() < time();
    }
}
