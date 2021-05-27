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

/**
 * Trait EncodingOptions
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait EncodingOptions
{
    /**
     * @param $string
     * @return mixed
     */
    public function setEncoding($string)
    {
        return $this->setOption(C::_ENC, $string);
    }

    /**
     * @return mixed
     */
    public function defaultEncoding()
    {
        return $this->unsetOption(C::_ENC);
    }

    /**
     * @return mixed
     */
    public function listEncodings()
    {
        return $this->setFlag(C::_LISTENC);
    }

    /**
     * @return array
     */
    protected function encodingOptions()
    {
        return [
            C::_ENC => C::T_STRING,
        ];
    }

    /**
     * @return array
     */
    protected function encodingFlags()
    {
        return [C::_LISTENC];
    }
}
