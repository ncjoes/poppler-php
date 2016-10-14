<?php
/**
 * PHP-Poppler
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    2:58 PM
 **/

namespace NcJoes\PhpPoppler;

use NcJoes\PhpPoppler\Constants as C;

abstract class Helpers
{
    public static function parseDir($dir)
    {
        return str_replace('/', C::DS, $dir);
    }
}