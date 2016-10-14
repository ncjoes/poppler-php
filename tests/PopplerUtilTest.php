<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:31 PM
 **/

use NcJoes\PhpPdfSuite\Config;
use NcJoes\PhpPdfSuite\Constants as C;
use NcJoes\PhpPdfSuite\PdfInfo;
use NcJoes\PhpPdfSuite\PdfToCairo;

class PopplerUtilTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSetOutputFileName()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
        $pdf = new PdfToCairo($file);
        $pdf->outputFilename('test.png');

        $this->assertStringEndsWith('test.png', $pdf->outputFilename());
    }

    public function testMakeOptionsMethod()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
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

    public function testOutputDirMethod()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(true));
        $this->assertTrue(Config::isSet(C::OUTPUT_DIR));

        $source_file = __DIR__.'/sources/test1.pdf';
        $cairo = new PdfToCairo($source_file);

        $this->assertTrue($cairo->outputDir() != dirname($source_file));
    }

    public function testMakeCommandMethod()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
        $pdf = new PdfToCairo($file);

        $pdf->outputFilename('test-file.png');
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->outputFilename()));
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->binDir()));
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->outputDir()));
    }
}