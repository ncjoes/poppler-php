<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:53 PM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

trait EncodingOptions
{
    public function setEncoding($string)
    {
        return $this->setOption(C::_ENC, $string);
    }

    public function defaultEncoding()
    {
        return $this->unsetOption(C::_ENC);
    }

    public function listEncodings()
    {
        return $this->setFlag(C::_LISTENC);
    }

    protected function encodingOptions()
    {
        return [
            C::_ENC => C::T_STRING,
        ];
    }

    protected function encodingFlags()
    {
        return [C::_LISTENC];
    }
}