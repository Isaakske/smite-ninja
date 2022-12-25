<?php

declare(strict_types=1);

namespace App\Entity;

class God
{
    private int $id;
    private string $name;
    private ?string $icon;

    public function __construct(int $id, string $name, string $icon = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
    }

    public static function createFromData(array $data): self
    {
        return new self(
            (int) ($data['GodId'] ?? $data['id']),
            $data['Reference_Name'] ?? $data['GodName'] ?? $data['Name'],
            $data['godIcon_URL'] ?? null
        );
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }
}
