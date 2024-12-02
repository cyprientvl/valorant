<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Symfony\Bundle\SecurityBundle\Security;

class AppExtension extends AbstractExtension
{

    public function __construct(private Security $security)
    {
        $this->security = $security;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('user_username', [$this, 'getUsername']),
        ];
    }

    public function getUsername()
    {
        $user = $this->security->getUser();
        return $user->getUsername();
    }
}
