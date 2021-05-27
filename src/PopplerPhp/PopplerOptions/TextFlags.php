<?php

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

/**
 * Trait TextFlags
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait TextFlags
{
    /**
     * @return mixed
     */
    public function setBboxLayout()
    {
        return $this->setFlag(C::_BBOX_LAYOUT);
    }

    /**
     * @return mixed
     */
    public function setLayout()
    {
        return $this->setFlag(C::_LAYOUT);
    }

    /**
     * @return array
     */
    protected function textFlags()
    {
        return [C::_BBOX_LAYOUT, C::_LAYOUT];
    }
}
