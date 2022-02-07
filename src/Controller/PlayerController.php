<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Data\PlayerSearchData;
use App\Form\Type\PlayerSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/', name: 'player_search', methods: ['GET', 'POST'])]
    #[Template]
    public function search(Request $request): array
    {
        $data = new PlayerSearchData();

        $form = $this->createForm(PlayerSearchType::class, $data);

        if (Request::METHOD_POST === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // do stuff
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
