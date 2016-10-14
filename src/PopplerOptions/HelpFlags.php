<?php
/**
 * Php-PopplerUtils
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:24 PM
 **/

namespace NcJoes\PhpPoppler\PopplerOptions;

use NcJoes\PhpPoppler\Constants as C;

trait HelpFlags
{
    protected function helpFlags()
    {
        return [C::_H, C::_HELP, C::_HELP_, C::_HELP_Q];
    }

    public function printHelpInfo()
    {
        return $this->setFlag(C::_H);
    }
}