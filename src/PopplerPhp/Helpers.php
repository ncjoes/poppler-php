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

/**
 * Class Helpers
 * @package NcJoes\PopplerPhp
 */
abstract class Helpers
{
    /**
     * @param $dir
     * @return mixed
     */
    public static function parseDirName($dir)
    {
        $dir = str_replace('/', C::DS, $dir);

        return $dir;
    }

    /**
     * @param $name
     * @return string|string[]|null
     */
    public static function parseFileName($name)
    {
        $name = preg_replace("/[^A-Za-z0-9-_. ]/", '', $name);

        return $name;
    }

    /**
     * @param $dir
     * @return mixed
     */
    public static function parseFileRealPath($dir)
    {
        $dir = str_replace('\\', C::DS, $dir);

        return $dir;
    }

}
