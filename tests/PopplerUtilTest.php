<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:31 PM
 **/

use NcJoes\PhpPdfSuite\Config;
use NcJoes\PhpPdfSuite\PdfInfo;
use NcJoes\PhpPdfSuite\PdfToCairo;

class PopplerUtilTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        Config::set('poppler.bin_dir', realpath(dirname(__FILE__).'\..\vendor\bin\poppler'));
    }

    public function testSetOutputDirectory()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
        $pdf = new PdfToCairo($file);

        $this->assertStringEndsWith('source', $pdf->outputDir(dirname(__FILE__).'\source')->outputDir());
    }

    public function testSetOutputFileName()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
        $pdf = new PdfToCairo($file);
        $pdf->outputFilename('test.png');

        $this->assertStringEndsWith('test.png', $pdf->outputFilename());
    }

    public function testMakeCommand()
    {
        $file = realpath(dirname(__FILE__).'\source\test1.pdf');
        $pdf = new PdfToCairo($file);

        $pdf->outputFilename('test-file.png');
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->outputFilename()));
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->binDir()));
        $this->assertTrue(str_contains($pdf->previewShellCommand(), $pdf->outputDir()));
    }
}