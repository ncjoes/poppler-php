<?php

namespace NcJoes\PopplerPhp;

use Illuminate\Config\Repository;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\Helpers as H;

/**
 * Class Config
 *
 * @package NcJoes\PopplerPhp
 */
class Config
{
    /**
     * @var Repository $instance
     */
    protected static $instance;

    /**
     * @param $function
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($function, $arguments)
    {
        return call_user_func_array([static::getInstance(), $function], $arguments);
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (!(static::$instance instanceof Repository))
            static::$instance = new Repository;

        return static::$instance;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function isKeySet($key)
    {
        return self::get($key, C::DFT) != C::DFT;
    }

    /**
     * @param $dir
     *
     * @return mixed|string
     * @throws PopplerPhpException
     */
    public static function setBinDirectory($dir)
    {
        $real_path = realpath($dir);

        if ($real_path) {
            $real_path = H::parseDirName($real_path);
            self::set(C::BIN_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DFT) {
            return self::setBinDirectory(self::getBinDirectory());
        }
        throw new PopplerPhpException("Poppler bin directory does not exist: ".$dir);
    }

    /**
     * @return mixed
     */
    public static function getBinDirectory()
    {
        $win = self::get(C::BIN_DIR, H::parseDirName(realpath(__DIR__.'/../../vendor/bin/poppler')));

        return PHP_OS === 'WINNT' ? $win : "";
    }

    /**
     * @param $dir
     * @param bool $new
     *
     * @return mixed|string
     * @throws PopplerPhpException
     */
    public static function setOutputDirectory($dir, $new = false)
    {
        $real_path = $new ? $dir : realpath($dir);

        if ($real_path) {
            $real_path = H::parseDirName($real_path);
            self::set(C::OUTPUT_DIR, $real_path);

            return $real_path;
        }
        elseif ($dir == C::DFT) {
            return self::setOutputDirectory(self::getOutputDirectory());
        }
        throw new PopplerPhpException("Output directory does not exist: ".$dir);
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public static function getOutputDirectory($default = null)
    {
        $check = is_dir($default);
        $default = $check ? $default : H::parseDirName(C::DEFAULT_OUTPUT_DIR);

        return self::get(C::OUTPUT_DIR, realpath($default));
    }
}
