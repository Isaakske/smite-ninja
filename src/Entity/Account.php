<?php

declare(strict_types=1);

namespace App\Entity;

class Account
{
    private int $id;
    private string $name;
    private string $hirezName;
    private int $portal;

    public function __construct(int $id, string $name, string $hirezName, int $portal)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hirezName = $hirezName;
        $this->portal = $portal;
    }

    public static function createFromData(array $data): self
    {
        return new self(
            (int) $data['player_id'],
            $data['Name'],
            $data['hz_player_name'] ?? '',
            (int) $data['portal_id']
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

    public function getHirezName(): string
    {
        return $this->hirezName;
    }

    public function setHirezName(string $hirezName): void
    {
        $this->hirezName = $hirezName;
    }

    public function getPortal(): int
    {
        return $this->portal;
    }

    public function setPortal(int $portal): void
    {
        $this->portal = $portal;
    }
}
