<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/live/{playerId}', name: 'match_live', methods: ['GET'])]
    #[Template]
    public function live(Request $request, int $playerId, Smite $smite): JsonResponse|Response|array
    {
        $poll = false;
        $async = (bool) $request->query->get('poll');
        $match = $smite->liveMatch($playerId);

        // Player is in God Selection, poll the status continuously
        if ($match === 2) {
            $poll = true;
            $match = null;
        }

        if ($async && $poll && !$match) {
            return new JsonResponse(['finished' => false]);
        }

        return [
            'poll' => $poll,
            'async' => $async,
            'match' => $match,
            'player' => $playerId,
        ];
    }

    #[Route('/match/{matchId}', name: 'match_details', methods: ['GET'])]
    #[Template]
    public function details(int $matchId, Smite $smite): array
    {
        $match = $smite->matchDetails($matchId);

        return [
            'match' => $match,
        ];
    }
}
