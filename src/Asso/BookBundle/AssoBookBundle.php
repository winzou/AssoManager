<?php

namespace Asso\BookBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AssoBookBundle extends Bundle
{
    public function getParent()
    {
        return 'winzouBookBundle';
    }
}
