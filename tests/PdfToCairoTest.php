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
use PHPUnit\Framework\TestCase;

/**
 * Class PdfToCairoTest
 */
class PdfToCairoTest extends TestCase
{
    /**
     *
     */
    public function setUp(): void
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

        $outputPath = $cairo1->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.png');

        $cairo2->firstPageOnly();
        $cairo2->generateJPG();

        $outputPath = $cairo2->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.jpg');

        //$cairo3->firstPageOnly();
        //$cairo3->generateTIFF();

        $cairo4->startFromPage(1)->stopAtPage(1);
        $cairo4->generatePS();

        $outputPath = $cairo4->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.ps');

        $cairo5->setPostScriptLevel(C::_LEVEL3)->startFromPage(1)->stopAtPage(1);
        $cairo5->generateEPS();

        $outputPath = $cairo5->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.eps');

        $cairo6->startFromPage(1)->stopAtPage(2);
        $cairo6->generateSVG();

        $outputPath = $cairo6->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.svg');
    }

}
