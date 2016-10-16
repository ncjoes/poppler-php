<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:05 PM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PopplerOptions\ConsoleFlags;
use NcJoes\PopplerPhp\PopplerOptions\CredentialOptions;
use NcJoes\PopplerPhp\PopplerOptions\DateFlags;
use NcJoes\PopplerPhp\PopplerOptions\EncodingOptions;
use NcJoes\PopplerPhp\PopplerOptions\PageRangeOptions;

class PdfInfo extends PopplerUtil
{
    use CredentialOptions;
    use DateFlags;
    use EncodingOptions;
    use PageRangeOptions;
    use ConsoleFlags;

    private $pdf_info;

    public function __construct($pdfFile = '', array $options = [])
    {
        $this->require_output_dir = false;
        $this->bin_file = C::PDF_INFO;

        return parent::__construct($pdfFile, $options);
    }

    public function getInfo()
    {
        $this->checkInfo();

        return $this->pdf_info;
    }

    protected function checkInfo()
    {
        if (is_null($this->pdf_info)) {
            $content = $this->shellExec();
            $lines = explode("\n", $content);
            $info = [];
            foreach ($lines as $item) {
                if (!empty($item)) {
                    list($key, $value) = explode(":", $item);
                    $info[ str_replace([" "], ["_"], strtolower($key)) ] = trim(implode(':', (array)$value));
                }
            }
            $this->pdf_info = $info;
        }

        return $this;
    }

    public function getTitle()
    {
        $this->checkInfo();

        return isset($this->pdf_info['title']) ? $this->pdf_info['title'] : null;
    }

    public function getAuthors()
    {
        $this->checkInfo();
        $authors = isset($this->pdf_info['author']) ? explode(',', $this->pdf_info['author']) : [];

        return array_map(function ($item) {
            return ltrim(rtrim($item, ' '), ' ');
        }, $authors);
    }

    public function getCreator()
    {
        $this->checkInfo();

        return isset($this->pdf_info['creator']) ? $this->pdf_info['creator'] : null;
    }

    public function getProducer()
    {
        $this->checkInfo();

        return isset($this->pdf_info['producer']) ? $this->pdf_info['producer'] : null;
    }

    public function getCreationDate()
    {
        $this->checkInfo();

        return isset($this->pdf_info['creationdate']) ? $this->pdf_info['creationdate'] : null;
    }

    public function getModificationDate()
    {
        $this->checkInfo();

        return isset($this->pdf_info['moddate']) ? $this->pdf_info['moddate'] : null;
    }

    public function isTagged()
    {
        $this->checkInfo();

        return isset($this->pdf_info['tagged']) ? ($this->pdf_info['tagged'] != 'no') : false;
    }

    public function hasJavaScript()
    {
        $this->checkInfo();

        return isset($this->pdf_info['javascript']) ? ($this->pdf_info['javascript'] != 'no') : false;
    }

    public function getNumOfPages()
    {
        $this->checkInfo();

        return isset($this->pdf_info['pages']) ? $this->pdf_info['pages'] : null;
    }

    public function isEncrypted()
    {
        $this->checkInfo();

        return isset($this->pdf_info['encrypted']) ? ($this->pdf_info['encrypted'] != 'no') : false;
    }

    public function getSizeUnit()
    {
        $dimensions = explode(' ', $this->getPageSize());

        return isset($dimensions[3]) ? $dimensions[3] : null;
    }

    public function getPageSize()
    {
        $this->checkInfo();

        return isset($this->pdf_info['page_size']) ? $this->pdf_info['page_size'] : null;
    }

    public function getPageWidth()
    {
        $dimensions = explode('x', $this->getPageSize());

        return isset($dimensions[0]) ? doubleval($dimensions[0]) : null;
    }

    public function getPageHeight()
    {
        $dimensions = explode('x', $this->getPageSize());

        return isset($dimensions[1]) ? doubleval($dimensions[1]) : null;
    }

    public function getPageRot()
    {
        $this->checkInfo();

        return isset($this->pdf_info['page_rot']) ? $this->pdf_info['page_rot'] : null;
    }

    public function getFileSize()
    {
        $this->checkInfo();

        if (isset($this->pdf_info['file_size'])) {
            return intval($this->pdf_info['file_size']);
        }

        return null;
    }

    public function isOptimized()
    {
        $this->checkInfo();

        return isset($this->pdf_info['optimized']) ? ($this->pdf_info['optimized'] != 'no') : false;
    }

    public function getPdfVersion()
    {
        $this->checkInfo();

        return isset($this->pdf_info['pdf_version']) ? $this->pdf_info['pdf_version'] : null;
    }

    public function utilOptions()
    {
        return array_merge(
            $this->pageRangeOptions(),
            $this->encodingOptions(),
            $this->credentialOptions()
        );
    }

    public function utilOptionRules()
    {
        return [
            'alt' => [],
        ];
    }

    public function utilFlags()
    {
        return array_merge(
            $this->dateFlags(),
            $this->encodingFlags(),
            $this->allConsoleFlags()
        );
    }

    public function utilFlagRules()
    {
        return [
            'alt' => [],
        ];
    }

    public function outputExtension()
    {
        return null;
    }
}