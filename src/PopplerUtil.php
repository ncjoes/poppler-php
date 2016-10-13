<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    11:59 AM
 **/

namespace NcJoes\PhpPdfSuite;

abstract class PopplerUtil
{
    private   $binary_dir;
    private   $flags          = [];
    private   $options        = [];
    private   $source_pdf;
    private   $output_dir;
    private   $output_file;
    protected $bin_file;
    protected $output_extension;
    protected $use_output_dir = true;

    public function __construct($pdfFile = '', array $options = [])
    {
        if (empty($pdfFile) or !is_file($pdfFile)) {
            return $this;
        }

        $poppler_util = $this;
        if (!empty($options)) {
            array_walk($options, function ($value, $key) use ($poppler_util) {
                $poppler_util->setOption($key, $value);
            });
        }

        return $this->open($pdfFile);
    }

    protected function open($pdfFile)
    {
        $this->source_pdf = $pdfFile;

        return $this->outputDir(dirname($pdfFile));
    }

    public function setOption($key, $value = null)
    {
        $util_options = $this->utilOptions();

        if (array_key_exists($key, $util_options) and $util_options[ $value ] == gettype($value))
            $this->options[ $key ] = $value;

        return $this;
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

        if (array_key_exists($key, $util_flags))
            $this->flags[ $key ] = $key;

        return $this;
    }

    public function unsetFlag($key)
    {
        if ($this->hasFlag($key))
            $this->flags = array_except($this->flags, $key);

        return $this;
    }

    public function option($key)
    {
        return $this->hasOption($key) ? $this->options[ $key ] : null;
    }

    public function flag($key)
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

    public function outputDir($dir = '')
    {
        $real_path = realpath($dir);
        if (!empty($dir) and is_dir($real_path)) {
            $this->output_dir = $real_path;
            Config::set('poppler.output_dir', $real_path);

            return $this;
        }

        return Config::get('poppler.output_dir', realpath(dirname(__FILE__).'/../tests/results'));
    }

    public function binDir($dir = '')
    {
        $real_path = realpath($dir);
        if (!empty($dir) and is_dir($real_path)) {
            $this->binary_dir = $real_path;
            Config::set('poppler.bin_dir', $real_path);

            return $this;
        }

        return Config::get('poppler.bin_dir', realpath(dirname(__FILE__).'/../vendor/bin/poppler'));
    }

    private function popplerOptions()
    {
        $generated = [];
        array_walk($this->options, function ($value, $key) use (&$generated) {
            $generated[] = $key.' '.$value;
        });

        array_walk($this->flags, function ($value, $key) use (&$generated) {
            $generated[] = $key.' '.$value;
        });

        return implode(" ", $generated);
    }

    protected function shellExec()
    {
        $command = $this->makeCommand();

        return shell_exec($command);
    }

    private function makeCommand()
    {
        $options = $this->popplerOptions();

        if (PHP_OS === 'WINNT') {
            $command = '"'.$this->binDir().'/'.$this->bin_file.'" '.$options.' "'.$this->source_pdf.'"';
        }
        else {
            $command = $this->binDir().'/'.$this->bin_file." ".$options." '".$this->source_pdf."'";
        }

        if ($this->use_output_dir) {
            $output_path = $this->outputDir().DIRECTORY_SEPARATOR.$this->outputFilename().'.'.$this->output_extension;
            $command .= '"'.$output_path.'"';
        }

        return $command;
    }

    public function outputFilename($name = '')
    {
        if (!empty($name) and is_string($name)) {
            $this->output_file = basename($name);
            Config::set('poppler.output_name', $this->output_file);

            return $this;
        }
        $default_name = basename($this->source_pdf) ?: uniqid('output-');

        return Config::get('poppler.output_name', $default_name);
    }

    public function clearOutputDirectory()
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->output_dir, \FilesystemIterator::SKIP_DOTS));
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