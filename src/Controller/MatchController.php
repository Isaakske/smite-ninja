<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/live/{playerId}', name: 'match_live', methods: ['GET'])]
    #[Template]
    public function live(int $playerId, Smite $smite): array
    {
        $match = $smite->liveMatch($playerId);

        if ($match) {
            $smite->fillPlayersWithAccountInfo($match->getPlayers());
        }

        return [
            'match' => $match,
        ];
    }

    #[Route('/match/{matchId}', name: 'match_details', methods: ['GET'])]
    #[Template]
    public function details(int $matchId, Smite $smite): array
    {
        $match = $smite->matchDetails($matchId);

        if ($match) {
            $smite->fillPlayersWithAccountInfo($match->getPlayers());
        }

        return [
            'match' => $match,
        ];
    }
}
