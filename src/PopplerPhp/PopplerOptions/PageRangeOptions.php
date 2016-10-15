<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:06 PM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

trait PageRangeOptions
{
    public function startFromPage($page)
    {
        return $this->setOption(C::_F, $page);
    }

    public function stopAtPage($page)
    {
        return $this->setOption(C::_L, $page);
    }

    public function oddPagesOnly()
    {
        return $this->setFlag(C::_ODD_ONLY);
    }

    public function evenPagesOnly()
    {
        return $this->setFlag(C::_EVEN_ONLY);
    }

    public function firstPageOnly()
    {
        return $this->setFlag(C::_SINGLE_FILE);
    }

    protected function pageRangeOptions()
    {
        return [
            C::_F => C::T_INTEGER,
            C::_L => C::T_INTEGER,
        ];
    }

    protected function pageRangeFlags()
    {
        return [C::_ODD_ONLY, C::_EVEN_ONLY, C::_SINGLE_FILE];
    }
}