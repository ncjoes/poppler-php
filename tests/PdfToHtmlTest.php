<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    4:46 AM
 **/

use NcJoes\PhpPdfSuite\Config;
use NcJoes\PhpPdfSuite\Constants as C;
use NcJoes\PhpPdfSuite\PdfToHtml;

class PdfToHtmlTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testGenerateMethod()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(true));
        $pdfToHtml = new PdfToHtml(__DIR__.'/sources/test1.pdf');

        //$cairo->oddPagesOnly();
        //$cairo->generatePNG();

        //$cairo->startFromPage(1)->stopAtPage(1);
        //$cairo->generateSVG();

        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->noFrames();
        $pdfToHtml->oddPagesOnly();
        print_r($pdfToHtml->generate());
    }

}