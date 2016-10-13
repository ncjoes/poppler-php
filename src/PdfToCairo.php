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

    public function __construct($pdfFile, array $options = [])
    {
        parent::__construct($pdfFile, $options);
        $this->bin_file = C::PDF_TO_CAIRO;
        $this->setFlag(C::_Q);
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

    public function generate($regenerate = false)
    {

    }

    public function generatePNG($regenerate = false)
    {

    }

    public function generateJPG($regenerate = false)
    {

    }

    public function generateTIFF($regenerate = false)
    {

    }

    public function generatePS($regenerate = false)
    {

    }

    public function generateEPS($regenerate = false)
    {

    }

    public function generatePDF($regenerate = false)
    {

    }

    public function generateSVG($regenerate = false)
    {

    }
}