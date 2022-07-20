<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:17 AM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PopplerOptions\CairoOptions;
use NcJoes\PopplerPhp\PopplerOptions\HelpFlags;
use NcJoes\PopplerPhp\PopplerOptions\PageRangeOptions;

/**
 * Class PdfToCairo
 *
 * @package NcJoes\PopplerPhp
 */
class PdfToCairo extends PopplerUtil
{
    use CairoOptions;
    use PageRangeOptions;
    use HelpFlags;

    /**
     * @var string $format
     */
    protected $format;

    /**
     * PdfToCairo constructor.
     *
     * @param string $pdfFile
     * @param array $options
     * @throws Exceptions\PopplerPhpException
     */
    public function __construct($pdfFile = '', array $options = [])
    {
        $this->binFile = C::PDF_TO_CAIRO;

        return parent::__construct($pdfFile, $options);
    }

    /**
     * @return array
     */
    public function utilOptions()
    {
        return array_merge(
            $this->cairoOptions(),
            $this->pageRangeOptions()
        );
    }

    /**
     * @return array
     */
    public function utilFlags()
    {
        return array_merge(
            $this->cairoFlags(),
            $this->pageRangeFlags(),
            $this->helpFlags()
        );
    }

    /**
     * @return array
     */
    public function utilOptionRules()
    {
        return [
            'alt' => [],
        ];
    }

    /**
     * @return array
     */
    public function utilFlagRules()
    {
        return [
            'alt' => [],
        ];
    }

    /**
     * @return string
     */
    public function generatePNG()
    {
        $this->setOutputFormat(C::_PNG);

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generateJPG()
    {
        $this->setOutputFormat(C::_JPEG);

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generateTIFF()
    {
        $this->setOutputFormat(C::_TIFF);

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generatePS()
    {
        $this->setOutputFormat(C::_PS);
        $this->outputFileExtension = $this->outputExtension();

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generateEPS()
    {
        $this->setOutputFormat(C::_EPS);
        $this->outputFileExtension = $this->outputExtension();

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generatePDF()
    {
        $this->setOutputFormat(C::_PDF);

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generateSVG()
    {
        $this->setOutputFormat(C::_SVG);
        $this->outputFileExtension = $this->outputExtension();

        return $this->generate();
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->shellExec();
    }

    /**
     * @return string
     */
    public function outputExtension()
    {
        $dot = '.';
        $extension = null;
        switch ($this->getOutputFormat()) {
            case C::_PNG :
                $extension = 'png';
            break;
            case C::_JPEG :
                $extension = 'jpg';
            break;
            case C::_TIFF :
                $extension = 'tiff';
            break;
            case C::_PS :
                $extension = 'ps';
            break;
            case C::_EPS :
                $extension = 'eps';
            break;
            case C::_PDF :
                $extension = 'pdf';
            break;
            case C::_SVG :
                $extension = 'svg';
            break;
        }

        return $dot.$extension;
    }
}
