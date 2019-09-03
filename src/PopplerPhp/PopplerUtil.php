<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    11:59 AM
 **/

namespace NcJoes\PopplerPhp;

use FilesystemIterator;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\Helpers as H;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function is_array;
use function is_string;

/**
 * Class PopplerUtil
 *
 * @package NcJoes\PopplerPhp
 */
abstract class PopplerUtil
{
    /**
     * @var string
     */
    protected $binFile;
    /**
     * @var
     */
    protected $outputFileExtension;
    /**
     * @var bool
     */
    protected $requireOutputDir = true;
    /**
     * @var bool
     */
    protected $requireSubDir = false;
    /**
     * @var string
     */
    protected $outputFileSuffix = '';
    /**
     * @var array
     */
    protected $sourcePdfs = [];
    /**
     * @var string
     */
    private $binaryDir;
    /**
     * @var array
     */
    private $flags = [];
    /**
     * @var array
     */
    private $options = [];
    /**
     * @var string
     */
    private $outputSubDir;
    /**
     * @var string
     */
    private $outputFileNamePrefix;


    /**
     * PopplerUtil constructor.
     * @param string $pdfFile
     * @param array $options
     * @throws PopplerPhpException
     */
    public function __construct($pdfFile = '', array $options = [])
    {
        if ($pdfFile !== '') {
            $poppler_util = $this;
            if (!empty($options)) {
                array_walk($options, function ($value, $key) use ($poppler_util) {
                    $poppler_util->setOption($key, $value);
                });
            }

            return $this->open($pdfFile);
        }

        return $this;
    }

    /**
     * @param $pdfFile
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function open($pdfFile)
    {
        $real_path = H::parseFileRealPath($pdfFile);

        if (is_file($real_path)) {
            $this->setSourcePdfs($real_path);

            if (!Config::isKeySet(C::OUTPUT_DIR)) {
                Config::setOutputDirectory(dirname($pdfFile));
            }

            return $this;
        }
        throw new PopplerPhpException("File not found: ".$real_path);
    }

    /**
     * @param $dir_name
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function setOutputSubDir($dir_name)
    {
        $dir_name = H::parseDirName($dir_name);

        if (!empty($dir_name)) {
            $this->outputSubDir = $dir_name;

            return $this;
        }
        throw new PopplerPhpException("Directory name must be an alphanumeric string");
    }

    /**
     * @return string
     */
    public function getOutputSubDir()
    {
        if ($this->isSubDirRequired() && empty($this->outputSubDir)) {
            $this->outputSubDir = uniqid('test-'.date('m-d-Y_H-i'));
        }

        return $this->outputSubDir;
    }

    /**
     * @return string
     */
    public function getOutputPath()
    {
        $output_sub_dir = $this->getOutputSubDir();

        if ($this->isSubDirRequired() && !empty($output_sub_dir)) {
            return Config::getOutputDirectory().C::DS.$output_sub_dir;
        }

        return Config::getOutputDirectory();
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function setOption($key, $value)
    {
        $util_options = $this->utilOptions();

        if (array_key_exists($key, $util_options) and $util_options[$key] == gettype($value)) {
            $this->options[$key] = $value;

            return $this;
        }
        throw new PopplerPhpException("Unknown '".get_class($this)."' Option (or Invalid Type): ".$key.'='.$value.' ('.gettype($value).')');
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function unsetOption($key)
    {
        if ($this->hasOption($key))
            $this->options = array_except($this->options, $key);

        return $this;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * @param $key
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function setFlag($key)
    {
        $util_flags = $this->utilFlags();

        if (in_array($key, $util_flags)) {
            $this->flags[$key] = $key;

            return $this;
        }
        throw new PopplerPhpException("Unknown '".get_class($this)."' Flag: ".$key);
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function unsetFlag($key)
    {
        if ($this->hasFlag($key))
            $this->flags = array_except($this->flags, $key);

        return $this;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function hasFlag($key)
    {
        return array_key_exists($key, $this->flags);
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function getOption($key)
    {
        return $this->hasOption($key) ? $this->options[$key] : null;
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function getFlag($key)
    {
        return $this->hasFlag($key) ? $this->flags[$key] : null;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return string
     * @throws PopplerPhpException
     */
    public function previewShellCommand()
    {
        return $this->makeShellCommand();
    }

    /**
     * @return string
     */
    public function previewShellOptions()
    {
        return implode(' ', $this->makeShellOptions());
    }

    /**
     * @return $this
     */
    public function clearUtilOutputs()
    {
        $directory = $this->getOutputPath();

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS));

        foreach ($files as $file) {
            $path = (string) $file;
            $basename = basename($path);
            if ($basename != '..' && $basename != ".gitignore") {
                if (is_file($path) && file_exists($path))
                    unlink($path);
                elseif (is_dir($path) && file_exists($path))
                    rmdir($path);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function shellExec()
    {
        $command = $this->makeShellCommand();

        if ($this->isOutputDirRequired()) {
            $outputDir = $this->getOutputPath();
            if (!file_exists($outputDir))
                @mkdir($outputDir, 0777, true);
        }

        /**
         * Replace shell_exec with Symfony Process
         */
        return shell_exec($command);
    }

    /**
     * @return string
     */
    protected function getShellQuoteStr()
    {
        return PHP_OS === 'WINNT' ? "\"" : "'";
    }

    /**
     * @return string
     * @throws PopplerPhpException
     */
    private function makeShellCommand()
    {
        $q = $this->getShellQuoteStr();

        $bin = PHP_OS === 'WINNT' ? H::parseDirName($q.$this->binDir().C::DS.$this->binFile.$q) : $q.$this->binFile.$q;

        $opts_and_args = array_merge(
            $this->makeShellOptions(),
            $this->makeShellArgs()
        );

        return $bin.' '.implode(' ', $opts_and_args);
    }

    /**
     * @param string $dir
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function binDir($dir = '')
    {
        if (!empty($dir)) {
            $this->binaryDir = Config::setBinDirectory($dir);

            return $this;
        } elseif ($dir == C::DFT) {
            $this->binaryDir = Config::setBinDirectory(Config::getBinDirectory());
        }

        return Config::getBinDirectory();
    }

    /**
     * @return array
     */
    private function makeShellOptions()
    {
        $generated = [];
        array_walk($this->options, function ($value, $key) use (&$generated) {
            $generated[] = $key.' '.$value;
        });

        array_walk($this->flags, function ($value) use (&$generated) {
            $generated[] = $value;
        });

        return $generated;
    }


    /**
     * @return array
     */
    protected function makeShellArgs()
    {
        $q = $this->getShellQuoteStr();

        return array_merge(
            $this->makeShellArgSrc(),
            $this->makeShellArgDest()
        );
    }

    /**
     * @return array
     */
    protected function makeShellArgSrc()
    {
        $q = $this->getShellQuoteStr();

        return array_map(function ($src_pdf) use ($q) {
            return "{$q}{$src_pdf}{$q}";
        }, $this->getSourcePdfs());
    }

    /**
     * @return array
     */
    protected function makeShellArgDest()
    {
        $generated = [];

        $q = $this->getShellQuoteStr();

        if ($this->isOutputDirRequired()) {
            $directory = $this->getOutputPath();
            $output_path = H::parseDirName($directory.C::DS.$this->getOutputFilenamePrefix());
            $generated[] = $q.$output_path.$this->outputFileSuffix.$this->outputFileExtension.$q;
        }

        return $generated;
    }

    /**
     * @return array
     */
    public function getSourcePdfs()
    {
        return $this->sourcePdfs;
    }

    /**
     * @param mixed $src
     * @return $this
     */
    public function setSourcePdfs($src)
    {
        if (is_string($src)) {
            $this->sourcePdfs = [$src];
        } elseif (is_array($src)) {
            $this->sourcePdfs = $src;
        } else {
            throw new PopplerPhpException("src must be string or array");
        }

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function setOutputFilenamePrefix($name)
    {
        $name = H::parseFileName($name);
        if (!empty($name)) {
            $this->outputFileNamePrefix = $name;

            return $this;
        }
        throw new PopplerPhpException("Filename must be an alphanumeric string");
    }

    /**
     * @param $name
     *
     * @return $this
     * @throws PopplerPhpException
     */
    public function setOutputFilenameSuffix($suffix = '')
    {
        $this->outputFileSuffix = $suffix;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutputFilenamePrefix()
    {
        if (!empty($this->outputFileNamePrefix)) {
            return $this->outputFileNamePrefix;
        }

        $base = basename($this->getSourcePdfs()[0]);
        $default_name = str_replace('.pdf', '', $base);
        $this->outputFileNamePrefix = $default_name;

        return $default_name;
    }

    /**
     * @return string
     */
    public function getOutputFilenameSuffix()
    {
        return $this->outputFileSuffix;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setRequireOutputDir($bool)
    {
        $this->requireOutputDir = $bool;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOutputDirRequired()
    {
        return $this->requireOutputDir;
    }

    /**
     * @return bool
     */
    public function isSubDirRequired()
    {
        return $this->requireSubDir;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setSubDirRequired($bool)
    {
        $this->requireSubDir = $bool;

        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function outputExtension();

    /**
     * @return mixed
     */
    abstract public function utilOptions();

    /**
     * @return mixed
     */
    abstract public function utilFlags();

    /**
     * @return mixed
     */
    abstract public function utilOptionRules();

    /**
     * @return mixed
     */
    abstract public function utilFlagRules();

}
