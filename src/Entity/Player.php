<?php

declare(strict_types=1);

namespace App\Entity;

class Player
{
    private int $id;
    private string $name;
    private int $level;
    private int $team;
    private string $god;
    private ?int $godLevel;
    private ?AccountInfo $accountInfo;

    public function __construct(int $id, string $name, int $level, int $team, string $god, ?int $godLevel, array $data = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->team = $team;
        $this->god = $god;
        $this->godLevel = $godLevel;
        $this->accountInfo = AccountInfo::createFromData($data);
    }

    public static function createFromData(array $data): self
    {
        return new self(
            (int) $data['playerId'],
            $data['hz_player_name'] ?? $data['playerName'],
            (int) $data['Account_Level'],
            (int) ($data['TaskForce'] ?? $data['taskForce']),
            $data['Reference_Name'] ?? $data['GodName'],
            array_key_exists('GodLevel', $data) ? ((int) $data['GodLevel']) - 1 : null,
            $data
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

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getTeam(): int
    {
        return $this->team;
    }

    public function setTeam(int $team): void
    {
        $this->team = $team;
    }

    public function getGod(): string
    {
        return $this->god;
    }

    public function setGod(string $god): void
    {
        $this->god = $god;
    }

    public function getGodLevel(): ?int
    {
        return $this->godLevel;
    }

    public function setGodLevel(?int $godLevel): void
    {
        $this->godLevel = $godLevel;
    }

    public function getAccountInfo(): ?AccountInfo
    {
        return $this->accountInfo;
    }

    public function setAccountInfo(?AccountInfo $accountInfo): void
    {
        $this->accountInfo = $accountInfo;
    }
}
