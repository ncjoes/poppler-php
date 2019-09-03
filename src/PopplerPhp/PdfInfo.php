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
use NcJoes\PopplerPhp\PopplerOptions\InfoFlags;
use NcJoes\PopplerPhp\PopplerOptions\PageRangeOptions;

/**
 * Class PdfInfo
 * @package NcJoes\PopplerPhp
 */
class PdfInfo extends PopplerUtil
{
    use CredentialOptions;
    use DateFlags;
    use EncodingOptions;
    use PageRangeOptions;
    use ConsoleFlags;
    use InfoFlags;

    /**
     * @var
     */
    private $pdfInfo;

    /**
     * PdfInfo constructor.
     * @param string $pdfFile
     * @param array $options
     * @throws Exceptions\PopplerPhpException
     */
    public function __construct($pdfFile = '', array $options = [])
    {
        $this->setRequireOutputDir(false);
        $this->binFile = C::PDF_INFO;

        return parent::__construct($pdfFile, $options);
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        $this->checkInfo();

        return $this->pdfInfo;
    }

    /**
     * @return $this
     */
    protected function checkInfo()
    {
        if (is_null($this->pdfInfo)) {
            $content = $this->shellExec();
            $lines = explode("\n", $content);
            $info = [];
            foreach ($lines as $item) {
                if (!empty($item)) {
                    list($key, $value) = explode(":", $item);
                    $info[ str_replace([" "], ["_"], strtolower($key)) ] = trim(implode(':', (array)$value));
                }
            }
            $this->pdfInfo = $info;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['title']) ? $this->pdfInfo['title'] : null;
    }

    /**
     * @return array
     */
    public function getAuthors()
    {
        $this->checkInfo();
        $authors = isset($this->pdfInfo['author']) ? explode(',', $this->pdfInfo['author']) : [];

        return array_map(function ($item) {
            return ltrim(rtrim($item, ' '), ' ');
        }, $authors);
    }

    /**
     * @return string|null
     */
    public function getCreator()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['creator']) ? $this->pdfInfo['creator'] : null;
    }

    /**
     * @return string|null
     */
    public function getProducer()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['producer']) ? $this->pdfInfo['producer'] : null;
    }

    /**
     * @return string|null
     */
    public function getCreationDate()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['creationdate']) ? $this->pdfInfo['creationdate'] : null;
    }

    /**
     * @return string|null
     */
    public function getModificationDate()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['moddate']) ? $this->pdfInfo['moddate'] : null;
    }

    /**
     * @return bool
     */
    public function isTagged()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['tagged']) ? ($this->pdfInfo['tagged'] != 'no') : false;
    }

    /**
     * @return bool
     */
    public function hasJavaScript()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['javascript']) ? ($this->pdfInfo['javascript'] != 'no') : false;
    }

    /**
     * @return string|null
     */
    public function getNumOfPages()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['pages']) ? $this->pdfInfo['pages'] : null;
    }

    /**
     * @return bool
     */
    public function isEncrypted()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['encrypted']) ? ($this->pdfInfo['encrypted'] != 'no') : false;
    }

    /**
     * @return string|null
     */
    public function getSizeUnit()
    {
        $dimensions = explode(' ', $this->getPageSize());

        return isset($dimensions[3]) ? $dimensions[3] : null;
    }

    /**
     * @return string|null
     */
    public function getPageSize()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['page_size']) ? $this->pdfInfo['page_size'] : null;
    }

    /**
     * @return float|null
     */
    public function getPageWidth()
    {
        $dimensions = explode('x', $this->getPageSize());

        return isset($dimensions[0]) ? doubleval($dimensions[0]) : null;
    }

    /**
     * @return float|null
     */
    public function getPageHeight()
    {
        $dimensions = explode('x', $this->getPageSize());

        return isset($dimensions[1]) ? doubleval($dimensions[1]) : null;
    }

    /**
     * @return string|null
     */
    public function getPageRot()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['page_rot']) ? $this->pdfInfo['page_rot'] : null;
    }

    /**
     * @return int|null
     */
    public function getFileSize()
    {
        $this->checkInfo();

        if (isset($this->pdfInfo['file_size'])) {
            return intval($this->pdfInfo['file_size']);
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isOptimized()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['optimized']) ? ($this->pdfInfo['optimized'] != 'no') : false;
    }

    /**
     * @return string|null
     */
    public function getPdfVersion()
    {
        $this->checkInfo();

        return isset($this->pdfInfo['pdf_version']) ? $this->pdfInfo['pdf_version'] : null;
    }

    /**
     * @return array|mixed
     */
    public function utilOptions()
    {
        return array_merge(
            $this->pageRangeOptions(),
            $this->encodingOptions(),
            $this->credentialOptions()
        );
    }

    /**
     * @return array|mixed
     */
    public function utilOptionRules()
    {
        return [
            'alt' => [],
        ];
    }

    /**
     * @return array|mixed
     */
    public function utilFlags()
    {
        return array_merge(
            $this->infoFlags(),
            $this->dateFlags(),
            $this->encodingFlags(),
            $this->allConsoleFlags()
        );
    }

    /**
     * @return array|mixed
     */
    public function utilFlagRules()
    {
        return [
            'alt' => [],
        ];
    }

    /**
     * @return mixed|null
     */
    public function outputExtension()
    {
        return null;
    }
}
