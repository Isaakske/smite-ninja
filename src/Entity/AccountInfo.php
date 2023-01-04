<?php

declare(strict_types=1);

namespace App\Entity;

class AccountInfo
{
    private int $id;
    private string $name;
    private int $level;
    private int $masteryLevel;
    private ?\DateTime $createdAt;

    public function __construct(int $id, string $name, int $level, int $masteryLevel, string $createdAtString)
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->masteryLevel = $masteryLevel;

        $createdAt = null;
        $parts = explode(' ', $createdAtString);
        $createdAtString = reset($parts);

        if ($createdAtString) {
            $createdAt = \DateTime::createFromFormat('n/j/Y', $createdAtString);
        }

        $this->createdAt = $createdAt ?: null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getMasteryLevel(): int
    {
        return $this->masteryLevel;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
}
