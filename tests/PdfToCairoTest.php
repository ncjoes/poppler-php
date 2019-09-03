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
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\PdfToCairo;

/**
 * Class PdfToCairoTest
 */
class PdfToCairoTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @throws PopplerPhpException
     */
    public function testGeneratorMethods()
    {
        Config::setOutputDirectory(Config::getOutputDirectory());
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $cairo1 = new PdfToCairo($file);
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
