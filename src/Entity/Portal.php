<?php

declare(strict_types=1);

namespace App\Entity;

class Portal
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromIdentifier(int $portal): self
    {
        switch ($portal) {
            case 1: return new self(1, 'Hi-Rez');
            case 5: return new self(5, 'Steam');
            case 9: return new self(9, 'Playstation');
            case 10: return new self(10, 'Xbox');
            case 22: return new self(22, 'Nintendo');
            case 25: return new self(25, 'Discord');
            case 28: return new self(28, 'Epic Games');
            default: return new self($portal, 'Unknown');
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
