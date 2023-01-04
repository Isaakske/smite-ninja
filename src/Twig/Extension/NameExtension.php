<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Entity\Mode;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NameExtension extends AbstractExtension
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('portal_name', [$this, 'getPortalName']),
            new TwigFunction('mode_name', [$this, 'getModeName']),
            new TwigFunction('rank_name', [$this, 'getRankName']),
            new TwigFunction('status_name', [$this, 'getStatusName']),
        ];
    }

    public function getPortalName(int $portal): string
    {
        switch ($portal) {
            case 1: return $this->translator->trans('portal.hi_rez');
            case 5: return $this->translator->trans('portal.steam');
            case 9: return $this->translator->trans('portal.playstation');
            case 10: return $this->translator->trans('portal.xbox');
            case 22: return $this->translator->trans('portal.nintendo');
            case 25: return $this->translator->trans('portal.discord');
            case 28: return $this->translator->trans('portal.epic_games');
            default: return $this->translator->trans('portal.unknown');
        }
    }

    public function getModeName(Mode $mode): string
    {
        switch ($mode->getId()) {
            case 426: return $this->translator->trans('mode.conquest');
            case 435: return $this->translator->trans('mode.arena');
            case 448: return $this->translator->trans('mode.joust');
            case 445: return $this->translator->trans('mode.assault');
            case 10189: return $this->translator->trans('mode.slash');
            case 434: return $this->translator->trans('mode.motd');
            case 504:
            case 451: return $this->translator->trans('mode.ranked_conquest');
            case 503:
            case 450: return $this->translator->trans('mode.ranked_joust');
            case 502:
            case 440: return $this->translator->trans('mode.ranked_duel');
            default: return $mode->getName() ?: $this->translator->trans('mode.unknown');
        }
    }

    public function getRankName(int $rank): string
    {
        switch ($rank) {
            case 0: return $this->translator->trans('rank.unranked');
            case 1: return $this->translator->trans('rank.bronze_5');
            case 2: return $this->translator->trans('rank.bronze_4');
            case 3: return $this->translator->trans('rank.bronze_3');
            case 4: return $this->translator->trans('rank.bronze_2');
            case 5: return $this->translator->trans('rank.bronze_1');
            case 6: return $this->translator->trans('rank.silver_5');
            case 7: return $this->translator->trans('rank.silver_4');
            case 8: return $this->translator->trans('rank.silver_3');
            case 9: return $this->translator->trans('rank.silver_2');
            case 10: return $this->translator->trans('rank.silver_1');
            case 11: return $this->translator->trans('rank.gold_5');
            case 12: return $this->translator->trans('rank.gold_4');
            case 13: return $this->translator->trans('rank.gold_3');
            case 14: return $this->translator->trans('rank.gold_2');
            case 15: return $this->translator->trans('rank.gold_1');
            case 16: return $this->translator->trans('rank.platinum_5');
            case 17: return $this->translator->trans('rank.platinum_4');
            case 18: return $this->translator->trans('rank.platinum_3');
            case 19: return $this->translator->trans('rank.platinum_2');
            case 20: return $this->translator->trans('rank.platinum_1');
            case 21: return $this->translator->trans('rank.diamond_5');
            case 22: return $this->translator->trans('rank.diamond_4');
            case 23: return $this->translator->trans('rank.diamond_3');
            case 24: return $this->translator->trans('rank.diamond_2');
            case 25: return $this->translator->trans('rank.diamond_1');
            case 26: return $this->translator->trans('rank.master');
            case 27: return $this->translator->trans('rank.grandmaster');
            default: return $this->translator->trans('rank.unknown');
        }
    }

    public function getStatusName(int $status): string
    {
        switch ($status) {
            case 1:
            case 4: return $this->translator->trans('status.online');
            case 2: return $this->translator->trans('status.god_selection');
            case 3: return $this->translator->trans('status.in_game');
            default: return $this->translator->trans('status.offline');
        }
    }
}
