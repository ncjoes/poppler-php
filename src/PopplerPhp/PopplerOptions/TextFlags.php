<?php

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

trait TextFlags
{
    public function setBboxLayout()
    {
        return $this->setFlag(C::_BBOX_LAYOUT);
    }

    public function setLayout()
    {
        return $this->setFlag(C::_LAYOUT);
    }

    protected function textFlags()
    {
        return [C::_BBOX_LAYOUT, C::_LAYOUT];
    }
}