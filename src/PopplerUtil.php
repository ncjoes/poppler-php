<?php
/**
 * Php-PopplerUtils
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    11:59 AM
 **/

namespace NcJoes\PhpPoppler;

use NcJoes\PhpPoppler\Constants as C;
use NcJoes\PhpPoppler\Exceptions\FileNotFoundException;
use NcJoes\PhpPoppler\Exceptions\InvalidArgumentException;
use NcJoes\PhpPoppler\Exceptions\InvalidDirectoryException;

abstract class PopplerUtil
{
    private   $binary_dir;
    private   $flags              = [];
    private   $options            = [];
    private   $source_pdf;
    private   $output_dir;
    protected $bin_file;
    private   $output_file_name;
    protected $output_file_extension;
    protected $require_output_dir = true;

    public function __construct($pdfFile = '', array $options = [])
    {
        if ($pdfFile != '') {
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

    public function open($pdfFile)
    {
        $real_path = realpath(C::parseDir($pdfFile));
        if (is_file($real_path)) {
            $this->source_pdf = $real_path;

            if (Config::isSet(C::OUTPUT_DIR))
                return $this;
            else
                return $this->outputDir(dirname($pdfFile));
        }
        throw new FileNotFoundException($pdfFile);
    }

    public function setOption($key, $value)
    {
        $util_options = $this->utilOptions();

        if (array_key_exists($key, $util_options) and $util_options[ $key ] == gettype($value)) {
            $this->options[ $key ] = $value;

            return $this;
        }
        throw new InvalidArgumentException("Unknown '".get_class($this)."' Option (or Invalid Type): ".$key.'('.gettype($value).')');
    }

    public function unsetOption($key)
    {
        if ($this->hasOption($key))
            $this->options = array_except($this->options, $key);

        return $this;
    }

    public function setFlag($key)
    {
        $util_flags = $this->utilFlags();

        if (in_array($key, $util_flags)) {
            $this->flags[ $key ] = $key;

            return $this;
        }
        throw new InvalidArgumentException("Unknown '".get_class($this)."' Flag: ".$key);
    }

    public function unsetFlag($key)
    {
        if ($this->hasFlag($key))
            $this->flags = array_except($this->flags, $key);

        return $this;
    }

    public function getOption($key)
    {
        return $this->hasOption($key) ? $this->options[ $key ] : null;
    }

    public function getFlag($key)
    {
        return $this->hasFlag($key) ? $this->flags[ $key ] : null;
    }

    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    public function hasFlag($key)
    {
        return array_key_exists($key, $this->flags);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function binDir($dir = '')
    {
        $real_path = realpath($dir);
        if (!empty($dir) and is_dir($real_path)) {
            $this->binary_dir = $real_path;
            Config::setBinDirectory($real_path);

            return $this;
        }

        return Config::getBinDirectory();
    }

    public function outputDir($dir = '')
    {
        if (!empty($dir)) {
            $real_path = realpath($dir);

            if (is_dir($real_path)) {
                $this->output_dir = $real_path;
                Config::setOutputDirectory($real_path);

                return $this;
            }
            elseif ($dir == C::DEFAULT) {
                Config::setOutputDirectory(Config::getOutputDirectory());
            }
            throw new InvalidDirectoryException($dir);
        }

        return Config::getOutputDirectory();
    }

    public function outputFilename($name = '')
    {
        if (!empty($name) and is_string($name)) {
            $this->output_file_name = basename($name);

            Config::setOutputFilename($this->output_file_name);

            return $this;
        }
        else {
            $base = basename($this->source_pdf);
            $default_name = str_replace('.pdf', '', $base) ?: '';

            return Config::getOutputFilename($default_name);
        }
    }

    protected function shellExec()
    {
        $command = $this->makeShellCommand();

        if ($this->require_output_dir) {
            $outputDir = $this->outputDir();
            if (!file_exists($outputDir))
                mkdir($outputDir, 0777, true);
        }

        return shell_exec($command);
    }

    private function makeShellCommand()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $options = $this->makeShellOptions();

        $command[] = C::parseDir($q.$this->binDir().'/'.$this->bin_file.$q);

        if ($options != '') {
            $command[] = $options;
        }

        $command[] = $q.$this->source_pdf.$q;

        if ($this->require_output_dir) {
            $output_path = C::parseDir($this->outputDir().'/'.$this->outputFilename());

            $command[] = $q.$output_path.$this->output_file_extension.$q;
        }

        return implode(' ', $command);
    }

    private function makeShellOptions()
    {
        $generated = [];
        array_walk($this->options, function ($value, $key) use (&$generated) {
            $generated[] = $key.' '.$value;
        });

        array_walk($this->flags, function ($value) use (&$generated) {
            $generated[] = $value;
        });

        return implode(' ', $generated);
    }

    public function previewShellCommand()
    {
        return $this->makeShellCommand();
    }

    public function previewShellOptions()
    {
        return $this->makeShellOptions();
    }

    public function clearOutputDirectory()
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->outputDir(), \FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            $path = (string)$file;
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

    abstract public function utilOptions();

    abstract public function utilOptionRules();

    abstract public function utilFlags();

    abstract public function utilFlagRules();
}