<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:31 PM
 **/

use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\PdfToCairo;

class PopplerUtilTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSetOutputFileName()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfToCairo($file);
        $pdf->setOutputFilenamePrefix('different-name');

        $this->assertEquals('different-name', $pdf->getOutputFilenamePrefix());
    }

    public function testMakeOptionsMethod()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfInfo($file);

        $pdf->startFromPage(10);
        $this->assertArrayHasKey('-f', $pdf->getOptions());

        $pdf->stopAtPage(20);
        $this->assertArrayHasKey('-l', $pdf->getOptions());

        $pdf->listEncodings();
        $this->assertArrayHasKey('-listenc', $pdf->getFlags());

        $pdf->isoDates();
        $this->assertArrayHasKey('-isodates', $pdf->getFlags());

        $this->assertContains('-f', $pdf->previewShellOptions());
    }

    public function testOutputDirMethodSetterAndGetter()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(C::DFT));
        $this->assertTrue(Config::isKeySet(C::OUTPUT_DIR));

        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $cairo = new PdfToCairo($file);

        $this->assertTrue($cairo->getOutputPath() != dirname($file));
    }

    public function testMakeCommandMethod()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfToCairo($file);

        $pdf->setOutputFilenamePrefix('test-file');
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->getOutputFilenamePrefix()));
        //$this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->binDir()));
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->getOutputSubDir()));
    }

}