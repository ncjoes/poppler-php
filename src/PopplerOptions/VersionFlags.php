<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:50 PM
 **/

namespace NcJoes\PhpPdfSuite\PopplerOptions;

use NcJoes\PhpPdfSuite\Constants as C;

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