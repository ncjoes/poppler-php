<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    11:59 AM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\Helpers as H;

abstract class PopplerUtil
{
    protected $bin_file;
    protected $output_file_extension;
    protected $require_output_dir = true;
    private   $binary_dir;
    private   $flags              = [];
    private   $options            = [];
    private   $source_pdf;
    private   $output_sub_dir;
    private   $output_file_name;

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

    public function open($pdfFile)
    {
        $real_path = H::parseFileRealPath($pdfFile);

        if (is_file($real_path)) {
            $this->source_pdf = $real_path;

            if (!Config::isSet(C::OUTPUT_DIR)) {
                Config::setOutputDirectory(dirname($pdfFile));
            }

            return $this;
        }
        throw new PopplerPhpException("File not found: ".$real_path);
    }

    public function setOutputSubDir($dir_name)
    {
        $dir_name = H::parseDirName($dir_name);

        if (!empty($dir_name)) {
            $this->output_sub_dir = $dir_name;

            return $this;
        }
        throw new PopplerPhpException("Directory name must be an alphanumeric string");
    }

    public function getOutputSubDir()
    {
        if (!is_string($this->output_sub_dir)) {
            $this->output_sub_dir = uniqid('test-'.date('m-d-Y_H-i'));
        }

        return $this->output_sub_dir;
    }

    public function getOutputPath()
    {
        return Config::getOutputDirectory().C::DS.$this->getOutputSubDir();
    }

    public function setOption($key, $value)
    {
        $util_options = $this->utilOptions();

        if (array_key_exists($key, $util_options) and $util_options[ $key ] == gettype($value)) {
            $this->options[ $key ] = $value;

            return $this;
        }
        throw new PopplerPhpException("Unknown '".get_class($this)."' Option (or Invalid Type): ".$key.'='.$value.' ('.gettype($value).')');
    }

    public function unsetOption($key)
    {
        if ($this->hasOption($key))
            $this->options = array_except($this->options, $key);

        return $this;
    }

    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    public function setFlag($key)
    {
        $util_flags = $this->utilFlags();

        if (in_array($key, $util_flags)) {
            $this->flags[ $key ] = $key;

            return $this;
        }
        throw new PopplerPhpException("Unknown '".get_class($this)."' Flag: ".$key);
    }

    public function unsetFlag($key)
    {
        if ($this->hasFlag($key))
            $this->flags = array_except($this->flags, $key);

        return $this;
    }

    public function hasFlag($key)
    {
        return array_key_exists($key, $this->flags);
    }

    public function getOption($key)
    {
        return $this->hasOption($key) ? $this->options[ $key ] : null;
    }

    public function getFlag($key)
    {
        return $this->hasFlag($key) ? $this->flags[ $key ] : null;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function previewShellCommand()
    {
        return $this->makeShellCommand();
    }

    public function previewShellOptions()
    {
        return $this->makeShellOptions();
    }

    public function clearUtilOutputs()
    {
        $directory = $this->getOutputPath();

        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));

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

    protected function shellExec()
    {
        $command = $this->makeShellCommand();

        if ($this->require_output_dir) {
            $outputDir = $this->getOutputPath();
            if (!file_exists($outputDir))
                @mkdir($outputDir, 0777, true);
        }

        /**
         * Replace shell_exec with Symfony Process
         */
        return shell_exec($command);
    }

    private function makeShellCommand()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $options = $this->makeShellOptions();

        $command[] = H::parseDirName($q.$this->binDir().C::DS.$this->bin_file.$q);

        if ($options != '') {
            $command[] = $options;
        }

        $command[] = $q.$this->sourcePdf().$q;

        if ($this->require_output_dir) {
            $directory = $this->getOutputPath();

            $output_path = H::parseDirName($directory.C::DS.$this->getOutputFilenamePrefix());

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

    public function binDir($dir = '')
    {
        if (!empty($dir)) {
            $this->binary_dir = Config::setBinDirectory($dir);

            return $this;
        }
        elseif ($dir == C::DEFAULT) {
            $this->binary_dir = Config::setBinDirectory(Config::getBinDirectory());
        }

        return Config::getBinDirectory();
    }

    public function sourcePdf()
    {
        return $this->source_pdf;
    }

    public function setOutputFilenamePrefix($name)
    {
        $name = H::parseFileName($name);
        if (!empty($name)) {
            $this->output_file_name = $name;

            return $this;
        }
        throw new PopplerPhpException("Filename must be an alphanumeric string");
    }

    public function getOutputFilenamePrefix()
    {
        if (!empty($this->output_file_name)) {
            return $this->output_file_name;
        }

        $base = basename($this->sourcePdf());
        $default_name = str_replace('.pdf', '', $base);
        $this->output_file_name = $default_name;

        return $default_name;
    }

    abstract public function outputExtension();

    abstract public function utilOptions();

    abstract public function utilFlags();

    abstract public function utilOptionRules();

    abstract public function utilFlagRules();

}