<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use App\Common\Mapper;
use App\Entity\AccountInfo;
use App\Entity\Player;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/live/{playerId}', name: 'match_live', methods: ['GET'])]
    #[Template]
    public function live(int $playerId, Smite $smite): array
    {
        $players = $smite->liveMatch($playerId);

        $knownPlayers = array_filter($players, static fn (Player $player) => $player->getId());
        $playerIds = array_map(static fn (Player $player) => $player->getId(), $knownPlayers);
        $accountInfo = $smite->searchAccountInfo($playerIds);
        $accountInfo = Mapper::mapObjects($accountInfo, static fn (AccountInfo $accountInfo) => $accountInfo->getId());

        $players = array_map(static function (Player $player) use ($accountInfo) {
            $id = $player->getId();

            if (array_key_exists($id, $accountInfo)) {
                $player->setAccountInfo($accountInfo[$id]);
            }

            return $player;
        }, $players);

        return [
            'players' => $players,
        ];
    }
}
