<?php

declare(strict_types=1);

namespace App\Services;

use App\Common\Mapper;
use App\Entity\MatchInfo;
use App\Entity\Player;

class MatchHelper
{
    public function createMatchWithTeams(array $info): ?MatchInfo
    {
        if (!$info) {
            return null;
        }

        $matchData = reset($info);
        $match = MatchInfo::creareFromData($matchData);

        $players = array_map(static fn (array $data) => Player::createFromData($data), $info);
        usort($players, static fn (Player $player1, Player $player2) => $player2->getStats()->getMmr() <=> $player1->getStats()->getMmr());
        $teams = Mapper::mapObjects($players, static fn (Player $player) => $player->getTeam(), static fn (Player $player) => [$player]);

        $match->setTeams($teams);

        return $match;
    }
}
