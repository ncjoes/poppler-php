<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:37 PM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

/**
 * Trait DateFlags
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait DateFlags
{
    /**
     * @return mixed
     */
    public function isoDates()
    {
        return $this->setFlag(C::_ISODATES);
    }

    /**
     * @return mixed
     */
    public function rawDates()
    {
        return $this->setFlag(C::_RAWDATE);
    }

    /**
     * @return mixed
     */
    public function defaultDates()
    {
        $this->unsetFlag(C::_RAWDATE);

        return $this->unsetFlag(C::_ISODATES);
    }

    /**
     * @return array
     */
    protected function dateFlags()
    {
        return [C::_ISODATES, C::_RAWDATE];
    }
}
