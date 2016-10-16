<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    12:59 AM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PopplerOptions\ConsoleFlags;
use NcJoes\PopplerPhp\PopplerOptions\CredentialOptions;
use NcJoes\PopplerPhp\PopplerOptions\EncodingOptions;
use NcJoes\PopplerPhp\PopplerOptions\HtmlOptions;
use NcJoes\PopplerPhp\PopplerOptions\PageRangeOptions;

class PdfToHtml extends PopplerUtil
{
    use PageRangeOptions;
    use ConsoleFlags;
    use HtmlOptions;
    use EncodingOptions;
    use CredentialOptions;

    private $products;

    public function __construct($pdfFile = '', array $options = [])
    {
        $this->bin_file = C::PDF_TO_HTML;
        $this->setFlag(C::_Q);

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

    public function utilFlags()
    {
        return array_merge(
            $this->allConsoleFlags(),
            $this->htmlFlags()
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

    public function defaultEncoding()
    {
        return $this;
    }

    public function listEncodings()
    {
        return $this;
    }

    public function oddPagesOnly()
    {
        return $this;
    }

    public function evenPagesOnly()
    {
        return $this;
    }

    public function firstPageOnly()
    {
        return $this;
    }

    public function generate($regenerate = false)
    {
        if (is_null($this->products) or $regenerate == true) {
            $content = $this->shellExec();

            $this->products = $content;
        }

        return $this->products;
    }

    public function outputExtension()
    {
        return '.html';
    }
}