<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:17 AM
 **/

namespace NcJoes\PhpPdfSuite;

use NcJoes\PhpPdfSuite\Constants as C;
use NcJoes\PhpPdfSuite\PopplerOptions\CairoOptions;
use NcJoes\PhpPdfSuite\PopplerOptions\HelpFlags;
use NcJoes\PhpPdfSuite\PopplerOptions\PageRangeOptions;

class PdfToCairo extends PopplerUtil
{
    use CairoOptions;
    use PageRangeOptions;
    use HelpFlags;

    private $products;

    public function __construct($pdfFile, array $options = [])
    {
        parent::__construct($pdfFile, $options);
        $this->bin_file = C::PDF_TO_CAIRO;
    }

    public function utilOptions()
    {
        return array_merge(
            $this->cairoOptions(),
            $this->pageRangeOptions()
        );
    }

    public function utilFlags()
    {
        return array_merge(
            $this->cairoFlags(),
            $this->pageRangeFlags(),
            $this->helpFlags()
        );
    }

    public function utilOptionRules()
    {
        return [
            'alt' => [],
        ];
    }

    public function utilFlagRules()
    {
        return [
            'alt' => [],
        ];
    }

    public function generatePNG($regenerate = false)
    {
        $this->setOutputFormat(C::_PNG);

        return $this->generate($regenerate);
    }

    public function generateJPG($regenerate = false)
    {
        $this->setOutputFormat(C::_JPEG);

        return $this->generate($regenerate);
    }

    public function generateTIFF($regenerate = false)
    {
        $this->setOutputFormat(C::_TIFF);

        return $this->generate($regenerate);
    }

    public function generatePS($regenerate = false)
    {
        $this->setOutputFormat(C::_PS);

        return $this->generate($regenerate);
    }

    public function generateEPS($regenerate = false)
    {
        $this->setOutputFormat(C::_EPS);

        return $this->generate($regenerate);
    }

    public function generatePDF($regenerate = false)
    {
        $this->setOutputFormat(C::_PDF);

        return $this->generate($regenerate);
    }

    public function generateSVG($regenerate = false)
    {
        $this->setOutputFormat(C::_SVG);
        $this->output_file_extension = '.svg';

        return $this->generate($regenerate);
    }

    public function generate($regenerate = false)
    {
        if (is_null($this->products) or $regenerate == true) {
            $content = $this->shellExec();

            $this->products = $content;
        }

        return $this->products;
    }
}