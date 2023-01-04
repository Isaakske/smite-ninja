<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use App\Entity\Account;
use App\Form\Data\AccountSearchData;
use App\Form\Type\AccountSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/', name: 'account_search', methods: ['GET', 'POST'])]
    public function search(Request $request, Smite $smite): Response
    {
        $recentSearches = explode(',', $request->cookies->get('recent_searches', ''));
        $recentSearches = array_filter($recentSearches);
        $data = new AccountSearchData(reset($recentSearches) ?: null);

        $form = $this->createForm(AccountSearchType::class, $data);

        if (
            (
                $request->getMethod() === Request::METHOD_POST
                && $form->handleRequest($request)
                && $form->isSubmitted()
                && $form->isValid()
                && ($accountName = $data->getAccountName())
            )
            || (
                $request->getMethod() === Request::METHOD_GET
                && ($accountName = $request->query->get('accountName'))
            )
        ) {
            array_unshift($recentSearches, $accountName);
            $recentSearches = array_unique($recentSearches);
            $recentSearches = array_slice($recentSearches, 0, 5);
            $cookie = Cookie::create('recent_searches', implode(',', $recentSearches), new \DateTime('+14 days'));

            $accounts = $smite->accounts($accountName);

            $matchingAccounts = array_filter($accounts, static fn (Account $account) => $account->getName() === $accountName);

            if (count($matchingAccounts) === 1) {
                /** @var Account $account */
                $account = reset($matchingAccounts);

                $response = $this->redirectToRoute('match_live', ['playerId' => $account->getId()]);
                $response->headers->setCookie($cookie);

                return $response;
            }
        }

        $response = $this->render('account/search.html.twig', [
            'form' => $form->createView(),
            'accounts' => $accounts ?? null,
            'recentSearches' => $recentSearches,
            'disableHome' => true,
        ]);

        if (isset($cookie)) {
            $response->headers->setCookie($cookie);
        }

        return $response;
    }
}
