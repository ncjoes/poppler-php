<?php
/**
 * Php-PopplerUtils
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:50 PM
 **/

namespace NcJoes\PhpPoppler\PopplerOptions;

use NcJoes\PhpPoppler\Constants as C;

trait VersionFlags
{
    protected function versionFlags()
    {
        return [C::_V];
    }

    public function printVersionInfo()
    {
        return $this->setFlag(C::_V);
    }
}