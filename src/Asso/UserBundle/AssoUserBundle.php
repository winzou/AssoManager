<?php

namespace Asso\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssoUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
