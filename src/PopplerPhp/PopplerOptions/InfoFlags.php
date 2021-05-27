<?php

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

/**
 * Trait InfoFlags
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait InfoFlags
{
    /**
     * @return mixed
     */
    public function setBox()
    {
        return $this->setFlag(C::_BOX);
    }

    /**
     * @return array
     */
    protected function infoFlags()
    {
        return [C::_BOX];
    }
}
