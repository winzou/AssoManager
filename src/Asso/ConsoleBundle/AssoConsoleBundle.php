<?php

namespace Asso\ConsoleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssoConsoleBundle extends Bundle
{
    public function getParent()
    {
        return 'CoreSphereConsoleBundle';
    }
}
