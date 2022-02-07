<?php

declare(strict_types=1);

namespace App\Entity;

class AccountInfo
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function createFromData(array $data): self
    {
        return new self((int) $data['Id']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
