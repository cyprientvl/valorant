<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\LockerRepository;
use App\Repository\ItemRepository;

use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Locker;
use App\Entity\Item;

use App\Service\ValorantApi;

class ItemService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private ValorantApi $valorantApi,
        private Security $security,
        private ItemRepository $itemRepository
    ) {

    }



    public function addItem($id, $display_name, $item_type, $display_icon)
    {

        $item = new Item();
        $item->setDisplayName($display_name);
        $item->setItemType($item_type);
        $item->setDisplayIcon($display_icon);
        $item->setId($id);
        $this->itemRepository->add($item);
    }



    public function getItem($id, $type)
    {
        $item = $this->valorantApi->get($this->getUrlByItemType($type) . $id);
        return $item;
    }

    public function getItemInBd($id)
    {
        return $this->itemRepository->getItem($id);
    }

    public function getItemByIdInLocker(Locker $locker, $itemId)
    {
        $items = $locker->getLockerItems();
        foreach ($items as $item) {

            if ($item->getId() === intval($itemId)) {
                return $item;
            }
        }
    }

    public function getItemByTypeInLocker(Locker $locker, $type)
    {

        $returns = [];
        $items = $locker->getLockerItems();

        foreach ($items as $item) {
            if ($item->getItem()->getItemType() === $type) {
                array_push($returns, $item);
            }
        }

        return $returns;
    }

    public function getWeaponType($name)
    {

        foreach ($this->getItemType() as $item) {
            if (strpos(strtolower($name), strtolower($item)) !== false) {
                return $item;
            }
        }
        return "Melee";
    }

    public function getUrlByItemType($type)
    {
        if ($this->isWeapon($type))
            return "weapons/skins/";
        if ($this->isPlayerCard($type))
            return "playercards/";
        if ($this->isSpray($type))
            return "sprays/";
        if ($this->isPlayerTitle($type))
            return "playertitles/";
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

    public function getItemType()
    {
        return [
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
    }
}
