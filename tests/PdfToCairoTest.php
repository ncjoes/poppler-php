<?php
/**
 * Php-PopplerUtils
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    11:35 AM
 **/

use NcJoes\PhpPoppler\Config;
use NcJoes\PhpPoppler\Constants as C;
use NcJoes\PhpPoppler\PdfToCairo;

class PdfToCairoTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testGeneratorMethods()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(true));
        $cairo = new PdfToCairo(__DIR__.'/sources/test1.pdf');

        //$cairo->oddPagesOnly();
        //$cairo->generatePNG();

        //$cairo->startFromPage(1)->stopAtPage(1);
        //$cairo->generateSVG();

        $cairo->startFromPage(1)->stopAtPage(5);
        $cairo->generateJPG();
    }

}