<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\LockerRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Locker;
use App\Service\ValorantApi;

class ItemService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private ValorantApi $valorantApi,
        private Security $security
    ) {

    }

    public function getItem($id, $type)
    {
        $item = $this->valorantApi->get($this->getUrlByItemType($type) . $id);
        return $item;
    }

    public function getItemByIdInLocker(Locker $locker, $itemId)
    {
        $items = $locker->getLockerItems();
        foreach ($items as $item) {
            if ($item->getId() === $itemId) {
                return $item;
            }
        }

        return null;
    }

    public function getItemByTypeInLocker(Locker $locker, $type)
    {

        $returns = [];
        $items = $locker->getItems();


        foreach ($items as $item) {
            if ($item->getItemType() === $type) {
                array_push($returns, $item);
            }
        }

        return $returns;
    }

    public function getUrlByItemType($type)
    {
        if ($this->isWeapon($type))
            return "https://valorant-api.com/v1/weapons/skins/";
        if ($this->isPlayerCard($type))
            return "https://valorant-api.com/v1/playercards/";
        if ($this->isSpray($type))
            return "https://valorant-api.com/v1/sprays/";
        if ($this->isPlayerTitle($type))
            return "https://valorant-api.com/v1/playertitles/";
    }

    public function isWeapon($type)
    {
        $items = [
            "Odin",
            "Ares",
            "Vandal",
            "Bulldow",
            "Phantom",
            "Judge",
            "Bucky",
            "Frenzy",
            "Classic",
            "Ghost",
            "Sheriff",
            "Shorty",
            "Operator",
            "Guardian",
            "Outlaw",
            "Marshal",
            "Spectre",
            "Stinger",
            "Melee"
        ];

        return in_array($type, $items);
    }

    public function isPlayerCard($type)
    {
        return $type == 'playerCard';
    }

    public function isSpray($type)
    {
        return $type == 'spray';

    }

    public function isPlayerTitle($type)
    {
        return $type == 'playerTitle';
    }
}
