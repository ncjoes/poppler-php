<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    11:35 AM
 **/

use NcJoes\PhpPdfSuite\Config;
use NcJoes\PhpPdfSuite\Constants as C;
use NcJoes\PhpPdfSuite\PdfToCairo;

class PdfToCairoTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        Config::set('poppler.bin_dir', realpath(C::parseDir(__DIR__.'/../vendor/bin/poppler')));
    }

    public function testGeneratorMethods()
    {
        Config::setOutputDirectory(Config::getOutputDirectory());
        $cairo = new PdfToCairo(__DIR__.'/sources/test1.pdf');

        //$cairo->oddPagesOnly();
        //$cairo->generatePNG();

        //$cairo->startFromPage(1)->stopAtPage(1);
        //$cairo->generateSVG();

        $cairo->startFromPage(1)->stopAtPage(5);
        $cairo->generateJPG();
    }

}