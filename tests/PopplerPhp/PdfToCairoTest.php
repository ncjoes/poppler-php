<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    11:35 AM
 **/

use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PdfToCairo;

class PdfToCairoTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testGeneratorMethods()
    {
        Config::setOutputDirectory(Config::getOutputDirectory());
        $cairo1 = new PdfToCairo(__DIR__.'/sources/test1.pdf');
        $cairo2 = clone $cairo1;
        $cairo3 = clone $cairo1;
        $cairo4 = clone $cairo1;
        $cairo5 = clone $cairo1;
        $cairo6 = clone $cairo1;

        $cairo1->firstPageOnly();
        $cairo1->generatePNG();

        $cairo2->firstPageOnly();
        $cairo2->generateJPG();

        //$cairo3->firstPageOnly();
        //$cairo3->generateTIFF();

        $cairo4->startFromPage(1)->stopAtPage(1);
        $cairo4->generatePS();

        $cairo5->setPostScriptLevel(C::_LEVEL3)->startFromPage(1)->stopAtPage(1);
        $cairo5->generateEPS();

        $cairo6->startFromPage(1)->stopAtPage(2);
        $cairo6->generateSVG();
    }

}