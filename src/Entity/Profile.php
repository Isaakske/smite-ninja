<?php

declare(strict_types=1);

namespace App\Entity;

class Profile extends AccountInfo
{
    private Stats $conquestStats;
    private Stats $joustStats;
    private Stats $duelStats;
    private int $status;

    public function __construct(int $id, string $name, int $level, int $masteryLevel, string $createdAtString, Stats $conquestStats, Stats $joustStats, Stats $duelStats, int $status)
    {
        parent::__construct($id, $name, $level, $masteryLevel, $createdAtString);

        $this->conquestStats = $conquestStats;
        $this->joustStats = $joustStats;
        $this->duelStats = $duelStats;
        $this->status = $status;
    }

    public static function createFromData(array $data): ?self
    {
        if (!$data || !$data['Id']) {
            return null;
        }

        return new self(
            (int) $data['Id'],
            $data['hz_player_name'] ?? $data['hz_gamer_tag'],
            (int) $data['Level'],
            (int) $data['MasteryLevel'],
            $data['Created_Datetime'],
            Stats::createForProfile($data['RankedConquest']),
            Stats::createForProfile($data['RankedJoust']),
            Stats::createForProfile($data['RankedDuel']),
            (int) $data['status'],
        );
    }

    public function getConquestStats(): Stats
    {
        return $this->conquestStats;
    }

    public function getJoustStats(): Stats
    {
        return $this->joustStats;
    }

    public function getDuelStats(): Stats
    {
        return $this->duelStats;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
