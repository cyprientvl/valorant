<?php

namespace App\Service;

use App\Repository\StatsRepository;

class StatsService
{
    public function __construct(
        private StatsRepository $statsRepository
    ) {
    }

    public function getMostUsedSkins(): array
    {
        return $this->statsRepository->findMostUsedSkins();
    }

    public function getMostUsedWeaponChromas(): array
    {
        return $this->statsRepository->findMostUsedWeaponChromas();
    }

    public function getMostLikedSkinsByLockers(): array
    {
        return $this->statsRepository->findMostLikedSkinsByLockers();
    }

    public function getUsersWithMostItems(): array
    {
        return $this->statsRepository->findUsersWithMostItems();
    }
}