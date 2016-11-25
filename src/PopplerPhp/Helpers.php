<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    2:58 PM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;

abstract class Helpers
{
    public static function parseDirName($dir)
    {
        $dir = str_replace('/', C::DS, $dir);

        return $dir;
    }

    public static function parseFileName($name)
    {
        $name = preg_replace("/[^A-Za-z0-9-_. ]/", '', $name);

        return $name;
    }

    public static function parseFileRealPath($dir)
    {
        $dir = str_replace('\\', C::DS, $dir);

        return $dir;
    }

}
