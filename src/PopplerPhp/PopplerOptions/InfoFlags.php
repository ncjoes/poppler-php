<?php

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

trait InfoFlags
{
    public function setBox()
    {
        return $this->setFlag(C::_BOX);
    }

    protected function infoFlags()
    {
        return [C::_BOX];
    }
}