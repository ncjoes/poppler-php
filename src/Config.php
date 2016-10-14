<?php

namespace NcJoes\PhpPoppler;

use Illuminate\Config\Repository;
use NcJoes\PhpPoppler\Constants as C;
use NcJoes\PhpPoppler\Exceptions\InvalidDirectoryException;

class Config
{
    protected static $instance;

    public static function getInstance()
    {
        if (!(static::$instance instanceof Repository))
            static::$instance = new Repository;

        return static::$instance;
    }

    public static function __callStatic($function, $arguments)
    {
        return call_user_func_array([static::getInstance(), $function], $arguments);
    }

    public static function isSet($key)
    {
        return self::get($key, C::DEFAULT) != C::DEFAULT;
    }

    public static function setBinDirectory($dir)
    {
        $real_path = realpath($dir);

        if ($real_path) {
            $real_path = C::parseDir($real_path);
            Config::set(C::BIN_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DEFAULT) {
            return Config::setBinDirectory(Config::getBinDirectory());
        }
        throw new InvalidDirectoryException($dir);
    }

    public static function getBinDirectory()
    {
        return Config::get(C::BIN_DIR, C::parseDir(realpath(__DIR__.'/../vendor/bin/poppler')));
    }

    public static function setOutputDirectory($dir, $new = false)
    {
        $real_path = $new ? $dir : realpath($dir);

        if ($real_path) {
            $real_path = C::parseDir($real_path);
            Config::set(C::OUTPUT_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DEFAULT) {
            return Config::setOutputDirectory(Config::getOutputDirectory($new));
        }
        throw new InvalidDirectoryException($dir);
    }

    public static function getOutputDirectory($new = false)
    {
        $dir = C::parseDir(realpath(__DIR__.'/../tests/results').'/test-'.date('m-d-Y_H-i'));
        if ($new) {
            return $dir;
        }

        return Config::get(C::OUTPUT_DIR, $dir);
    }

    public static function setOutputFilename($name)
    {
        Config::set(C::OUTPUT_NAME, $name);
    }

    public static function getOutputFilename($default = 'test')
    {
        return Config::get(C::OUTPUT_NAME, $default);
    }
}
