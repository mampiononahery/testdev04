<?php

namespace App\Bundle\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppMainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
