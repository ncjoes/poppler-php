<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:06 PM
 **/

namespace NcJoes\PhpPdfSuite\PopplerOptions;

use NcJoes\PhpPdfSuite\Constants as C;

trait PageRangeOptions
{
    public function pageRangeOptions()
    {
        return [
            [C::_F => C::T_INTEGER],
            [C::_L => C::T_INTEGER]
        ];
    }
}