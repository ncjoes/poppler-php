<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    3:36 PM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PopplerOptions\ConsoleFlags;
use NcJoes\PopplerPhp\PopplerOptions\CredentialOptions;
use NcJoes\PopplerPhp\PopplerOptions\EncodingOptions;
use NcJoes\PopplerPhp\PopplerOptions\HtmlOptions;
use NcJoes\PopplerPhp\PopplerOptions\PageRangeOptions;
use NcJoes\PopplerPhp\PopplerOptions\TextFlags;

class PdfToText extends PopplerUtil
{
    use PageRangeOptions;
    use ConsoleFlags;
    use HtmlOptions;
    use EncodingOptions;
    use CredentialOptions;
    use TextFlags;


     /**
     * PdfToCairo constructor.
     *
     * @param string $pdfFile
     * @param array $options
     */
    public function __construct($pdfFile = '', array $options = [])
    {
        $this->bin_file = C::PDF_TO_TEXT;

        return parent::__construct($pdfFile, $options);
    }

    public function utilOptions()
    {
        return array_merge(
            $this->pageRangeOptions(),
            $this->htmlOptions(),
            $this->credentialOptions(),
            $this->encodingOptions()
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
        return $this->textFlags();
    }

    public function utilFlagRules()
    {
        return [
            'alt' => [],
        ];
    }

    public function outputExtension()
    {
        return '.txt';
    }

       /**
     * @return string
     */
    public function generate()
    {
        $this->output_file_extension = $this->outputExtension();

        return $this->shellExec();
    }

    public function startFromPage($page)
    {
        return $this->setOption(C::_F, $page);
    }

    public function stopAtPage($page)
    {
        return $this->setOption(C::_L, $page);
    }

    protected function pageRangeOptions()
    {
        return [
            C::_F => C::T_INTEGER,
            C::_L => C::T_INTEGER,
        ];
    }
}