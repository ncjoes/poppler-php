<?php
/**
 * Php-PopplerUtils
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:37 PM
 **/

namespace NcJoes\PhpPoppler\PopplerOptions;

use NcJoes\PhpPoppler\Constants as C;

trait DateFlags
{
    protected function dateFlags()
    {
        return [C::_ISODATES, C::_RAWDATE];
    }

    public function isoDates()
    {
        return $this->setFlag(C::_ISODATES);
    }

    public function rawDates()
    {
        return $this->setFlag(C::_RAWDATE);
    }

    public function defaultDates()
    {
        $this->unsetFlag(C::_RAWDATE);

        return $this->unsetFlag(C::_ISODATES);
    }
}