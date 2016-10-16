<?php

namespace NcJoes\PopplerPhp;

use Illuminate\Config\Repository;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\Helpers as H;

class Config
{
    protected static $instance;

    public static function __callStatic($function, $arguments)
    {
        return call_user_func_array([static::getInstance(), $function], $arguments);
    }

    public static function getInstance()
    {
        if (!(static::$instance instanceof Repository))
            static::$instance = new Repository;

        return static::$instance;
    }

    public static function isSet($key)
    {
        return self::get($key, C::DEFAULT) != C::DEFAULT;
    }

    public static function setBinDirectory($dir)
    {
        $real_path = realpath($dir);

        if ($real_path) {
            $real_path = H::parseDirName($real_path);
            self::set(C::BIN_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DEFAULT) {
            return self::setBinDirectory(self::getBinDirectory());
        }
        throw new PopplerPhpException("Poppler bin directory does not exist: ".$dir);
    }

    public static function getBinDirectory()
    {
        return self::get(C::BIN_DIR, H::parseDirName(realpath(__DIR__.'/../../vendor/bin/poppler')));
    }

    public static function setOutputDirectory($dir, $new = false)
    {
        $real_path = $new ? $dir : realpath($dir);

        if ($real_path) {
            $real_path = H::parseDirName($real_path);
            self::set(C::OUTPUT_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DEFAULT) {
            return self::setOutputDirectory(self::getOutputDirectory());
        }
        throw new PopplerPhpException("Output directory does not exist: ".$dir);
    }

    public static function getOutputDirectory($default = null)
    {
        $check = is_dir($default);
        $default = $check ? $default : H::parseDirName(__DIR__.'/../../tests/results');

        return self::get(C::OUTPUT_DIR, realpath($default));
    }
}
