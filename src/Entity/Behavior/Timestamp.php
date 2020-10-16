<?php

/*
 * This file is part of Symfony Boilerplate.
 *
 * (c) Saif Eddin Gmati
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity\Behavior;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Psl;
use Psl\Str;

trait Timestamp
{
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected ?DateTimeInterface $createdAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected ?DateTimeInterface $updatedAt = null;

    /**
     * Updates createdAt and updatedAt timestamps.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(): void
    {
        $dateTime = static::getCurrentDateTime();

        if (null === $this->createdAt) {
            $this->createdAt = $dateTime;
        }

        $this->updatedAt = $dateTime;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function isRevised(): bool
    {
        $createdAt = $this->getCreatedAt();
        $updatedAt = $this->getUpdatedAt();

        if (null === $updatedAt || null === $createdAt) {
            return false;
        }

        return $createdAt->getTimestamp() !== $updatedAt->getTimestamp();
    }

    public static function getCurrentDateTime(): DateTime
    {
        // Create a datetime with microseconds
        $dateTime = DateTime::createFromFormat('U.u', Str\format('%.6F', microtime(true)));
        Psl\invariant(false !== $dateTime, 'unable to create a datetime object with microseconds.');

        $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));

        return $dateTime;
    }
}
